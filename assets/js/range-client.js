/**
 * VOSTOKPRIBOR AI • Universal Frontend Client (RangeClient)
 * Provides robust AJAX, CSRF, Toast notifications, and Error Normalization across all 5 systems.
 */

(function () {
    class RangeClient {
        constructor() {
            const script = document.currentScript?.src || new URL('../../assets/js/range-client.js', location.href).href;
            this.appBase = new URL('../..', script).pathname.replace(/\/$/, '');
            this.baseUrl = this.appBase + '/api/v1';
            this.csrfToken = this.getCsrfToken();
            this.initToastContainer();
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
            const url = endpoint.startsWith('http') ? endpoint : `${this.baseUrl}/${endpoint.replace(/^\//, '')}`;
            try {
                if (new URL(url, location.href).origin !== location.origin) return {success:false,error:{code:'INVALID_ORIGIN',message:'API requests must use this application origin.'}};
            } catch (_) { return {success:false,error:{code:'INVALID_URL',message:'Invalid API address.'}}; }
            const headers = options.headers || {};

            if (this.csrfToken && !headers['X-CSRF-TOKEN']) {
                headers['X-CSRF-TOKEN'] = this.csrfToken;
            }

            // Default JSON Content-Type if sending stringified object
            if (options.body && typeof options.body === 'string' && !headers['Content-Type']) {
                headers['Content-Type'] = 'application/json';
            }

            options.headers = headers;
            options.credentials = 'same-origin';

            try {
                const res = await fetch(url, options);

                // Handle session expiry
                if (res.status === 401) {
                    this.showToast('Session expired. Redirecting to login...', 'error');
                    setTimeout(() => {
                        window.location.href = this.appBase + '/login.php?redirect=' + encodeURIComponent(window.location.pathname);
                    }, 1200);
                    return { success: false, error: { code: 'UNAUTHORIZED', message: 'Session expired' } };
                }

                // Handle Forbidden
                if (res.status === 403) {
                    const json = await res.json().catch(() => ({}));
                    const msg = json.error?.message || 'Access denied: insufficient clearance.';
                    this.showToast(msg, 'error');
                    return { success: false, error: { code: 'FORBIDDEN', message: msg } };
                }

                const data = await res.json().catch(() => null);
                if (!res.ok) {
                    return {success:false,error:data?.error||{code:'HTTP_ERROR',message:'API request failed ('+res.status+').'}};
                }
                if (!data || typeof data.success !== 'boolean') {
                    return {success:false,error:{code:'INVALID_RESPONSE',message:'The server returned an invalid API response (' + res.status + ').'}};
                }
                if (data.data?.csrf_token) this.setCsrfToken(data.data.csrf_token);
                return data;
            } catch (err) {
                console.error('RangeClient request failed:', err);
                this.showToast('Network error communicating with range gateway.', 'error');
                return {
                    success: false,
                    error: { code: 'NETWORK_ERROR', message: err.message || 'Network connection failed' }
                };
            }
        }

        get(endpoint, params = {}) {
            let url = endpoint;
            const q = new URLSearchParams(params).toString();
            if (q) {
                url += (url.includes('?') ? '&' : '?') + q;
            }
            return this.request(url, { method: 'GET' });
        }

        post(endpoint, body = {}) {
            return this.request(endpoint, {
                method: 'POST',
                body: JSON.stringify(body)
            });
        }

        patch(endpoint, body = {}) {
            return this.request(endpoint, {
                method: 'PATCH',
                body: JSON.stringify(body)
            });
        }

        upload(endpoint, formData) {
            return this.request(endpoint, {
                method: 'POST',
                body: formData
                // Don't set Content-Type header to allow browser to generate multipart boundary
            });
        }
    }

    window.RangeClient = new RangeClient();
})();
