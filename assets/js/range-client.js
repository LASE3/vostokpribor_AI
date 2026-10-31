/**
 * VOSTOKPRIBOR AI • Universal Frontend Client (RangeClient)
 * Provides robust AJAX, CSRF, Toast notifications, and Error Normalization across all 5 systems.
 */

(function () {
    if (window.RangeClient?.initialized) return;
    class RangeClient {
        constructor() {
            const script = document.currentScript?.src || new URL('../../assets/js/range-client.js', location.href).href;
            this.appBase = new URL('../..', script).pathname.replace(/\/$/, '');
            this.baseUrl = this.appBase + '/api/v1';
            this.csrfToken = this.getCsrfToken();
            this.initialized = true;
            this.defaultTimeoutMs = this.timeoutValue(window.VOSTOK_API_TIMEOUT_MS, 15000);
            this.uploadTimeoutMs = this.timeoutValue(window.VOSTOK_UPLOAD_TIMEOUT_MS, 120000);
            this.readControllers = new Set();
            this.loginRedirectTimer = null;
            window.addEventListener?.('pagehide', () => this.readControllers.forEach(controller => controller.abort()));
            this.initToastContainer();
        }

        timeoutValue(value, fallback) {
            const number = Number(value);
            return Number.isFinite(number) && number > 0 ? Math.min(600000, Math.max(1, number)) : fallback;
        }

        getCsrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta && meta.content) return meta.content;
            if (window.VOSTOK_CSRF_TOKEN) return window.VOSTOK_CSRF_TOKEN;
            return '';
        }

        setCsrfToken(token) {
            this.csrfToken = token;
            window.VOSTOK_CSRF_TOKEN = token;
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) meta.content = token;
        }

        initToastContainer() {
            if (!document.getElementById('range-toast-container')) {
                const c = document.createElement('div');
                c.id = 'range-toast-container';
                c.className = 'fixed bottom-6 right-6 z-50 flex flex-col gap-2 font-mono text-xs pointer-events-none';
                document.body?.appendChild(c);
            }
        }

        showToast(message, type = 'success', duration = 3500) {
            this.initToastContainer();
            const c = document.getElementById('range-toast-container');
            if (!c) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto transform translate-y-4 opacity-0 transition-all duration-300 px-4 py-3 rounded-xl shadow-xl flex items-center gap-2.5 text-white max-w-sm';

            let icon = 'check_circle';
            if (type === 'error') {
                toast.classList.add('bg-rose-700');
                icon = 'error';
            } else if (type === 'warning') {
                toast.classList.add('bg-amber-600');
                icon = 'warning';
            } else {
                toast.classList.add('bg-[#4C1D95]');
            }

            const symbol = document.createElement('span');
            symbol.className = 'material-symbols-outlined text-base shrink-0';
            symbol.textContent = icon;
            const text = document.createElement('span');
            text.className = 'leading-relaxed';
            text.textContent = String(message);
            toast.append(symbol, text);

            c.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            setTimeout(() => {
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        async request(endpoint, options = {}) {
            if (typeof endpoint !== 'string') return {success:false,error:{code:'INVALID_URL',message:'Invalid API address.'}};
            const url = endpoint.startsWith('http') ? endpoint : `${this.baseUrl}/${endpoint.replace(/^\//, '')}`;
            try {
                if (new URL(url, location.href).origin !== location.origin) return {success:false,error:{code:'INVALID_ORIGIN',message:'API requests must use this application origin.'}};
            } catch (_) { return {success:false,error:{code:'INVALID_URL',message:'Invalid API address.'}}; }
            const headers = {...(options.headers || {})};
            if (typeof options.headers?.forEach === 'function') options.headers.forEach((value, key) => { headers[key] = value; });

            if (this.csrfToken && !headers['X-CSRF-TOKEN']) {
                headers['X-CSRF-TOKEN'] = this.csrfToken;
            }

            // Default JSON Content-Type if sending stringified object
            if (options.body && typeof options.body === 'string' && !headers['Content-Type']) {
                headers['Content-Type'] = 'application/json';
            }

            const method = String(options.method || 'GET').toUpperCase();
            const readOnly = ['GET', 'HEAD', 'OPTIONS'].includes(method);
            const controller = new AbortController();
            const callerSignal = options.signal;
            const timeoutMs = this.timeoutValue(options.timeoutMs, this.defaultTimeoutMs);
            const fetchOptions = {...options, headers, method, credentials:'same-origin', signal:controller.signal, redirect:'error'};
            delete fetchOptions.timeoutMs;
            let timedOut = false;
            let deadline;
            let onAbort;
            const forwardAbort = () => controller.abort();
            if (readOnly) this.readControllers.add(controller);
            try {
                const cancelled = new Promise((_, reject) => {
                    onAbort = () => { const error = new Error('Request cancelled'); error.name = 'AbortError'; reject(error); };
                    controller.signal.addEventListener('abort', onAbort, {once:true});
                });
                if (callerSignal) {
                    callerSignal.addEventListener('abort', forwardAbort, {once:true});
                    if (callerSignal.aborted) forwardAbort();
                }
                deadline = setTimeout(() => { timedOut = true; controller.abort(); }, timeoutMs);
                const transport = (async () => {
                    if (controller.signal.aborted) throw Object.assign(new Error('Request cancelled'), {name:'AbortError'});
                    const res = await fetch(url, fetchOptions);
                    const data = await res.json().catch(() => null);
                    if (controller.signal.aborted) throw Object.assign(new Error('Request cancelled'), {name:'AbortError'});
                    return {res, data};
                })();
                const {res, data} = await Promise.race([transport, cancelled]);

                // Handle session expiry
                if (res.status === 401) {
                    if (this.loginRedirectTimer === null) {
                        this.showToast('Session expired. Redirecting to login...', 'error');
                        this.loginRedirectTimer = setTimeout(() => {
                            window.location.href = this.appBase + '/login.php?redirect=' + encodeURIComponent(window.location.pathname);
                        }, 1200);
                    }
                    return { success: false, error: { code: 'UNAUTHORIZED', message: 'Session expired' } };
                }

                // Handle Forbidden
                if (res.status === 403) {
                    const msg = data?.error?.message || 'Access denied: insufficient clearance.';
                    this.showToast(msg, 'error');
                    return { success: false, error: { code: 'FORBIDDEN', message: msg } };
                }

                if (!res.ok) {
                    const error = {...(data?.error || {code:'HTTP_ERROR',message:'API request failed ('+res.status+').'})};
                    if (res.status === 429) {
                        const retryAfter = res.headers?.get?.('Retry-After');
                        const seconds = retryAfter && /^\d+$/.test(retryAfter) ? Number(retryAfter) : Math.ceil((Date.parse(retryAfter) - Date.now()) / 1000);
                        if (Number.isFinite(seconds) && seconds >= 0) error.retry_after_seconds = Math.min(86400, seconds);
                    }
                    return {success:false,status:res.status,error};
                }
                if (!data || typeof data.success !== 'boolean') {
                    return {success:false,error:{code:'INVALID_RESPONSE',message:'The server returned an invalid API response (' + res.status + ').'}};
                }
                if (data.data?.csrf_token) this.setCsrfToken(data.data.csrf_token);
                return data;
            } catch (err) {
                if (controller.signal.aborted || err.name === 'AbortError') {
                    if (!readOnly) return {success:false,error:{code:'UNKNOWN_OUTCOME',outcome_unknown:true,message:'The request '+(timedOut?'timed out':'was interrupted')+'. It may have been saved. Check the current server state before retrying.'}};
                    return {success:false,error:{code:timedOut?'TIMEOUT':'CANCELLED',message:timedOut?'The server did not respond in time. Please try loading again.':'Request cancelled.'}};
                }
                if (!readOnly) return {success:false,error:{code:'UNKNOWN_OUTCOME',outcome_unknown:true,message:'The connection failed before a save could be confirmed. Check the current server state before retrying.'}};
                console.error('RangeClient request failed:', err);
                this.showToast('Network error communicating with range gateway.', 'error');
                return {
                    success: false,
                    error: { code: 'NETWORK_ERROR', message: err.message || 'Network connection failed' }
                };
            } finally {
                clearTimeout(deadline);
                controller.signal.removeEventListener('abort', onAbort);
                callerSignal?.removeEventListener('abort', forwardAbort);
                this.readControllers.delete(controller);
            }
        }

        get(endpoint, params = {}, options = {}) {
            let url = endpoint;
            const q = new URLSearchParams(params).toString();
            if (q) {
                url += (url.includes('?') ? '&' : '?') + q;
            }
            return this.request(url, {...options, method:'GET'});
        }

        post(endpoint, body = {}, options = {}) {
            return this.request(endpoint, {
                ...options,
                method: 'POST',
                body: JSON.stringify(body)
            });
        }

        patch(endpoint, body = {}, options = {}) {
            return this.request(endpoint, {
                ...options,
                method: 'PATCH',
                body: JSON.stringify(body)
            });
        }

        upload(endpoint, formData, options = {}) {
            return this.request(endpoint, {
                timeoutMs:this.uploadTimeoutMs,
                ...options,
                method: 'POST',
                body: formData
                // Don't set Content-Type header to allow browser to generate multipart boundary
            });
        }
    }

    window.RangeClient = new RangeClient();
})();
