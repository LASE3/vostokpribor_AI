'use strict';
// Deterministic deferred HTTP, clock and DOM tests. No server/database or npm dependency.
const fs=require('node:fs'),vm=require('node:vm'),path=require('node:path');
const root=path.join(__dirname,'..');let passed=0;
const check=(ok,label)=>{if(!ok)throw new Error('FAIL '+label);passed++;console.log('PASS '+label);};
const flush=()=>new Promise(resolve=>setImmediate(resolve));
function deferred(){let resolve,reject;const promise=new Promise((a,b)=>{resolve=a;reject=b;});return {promise,resolve,reject};}
class Node {
 constructor(id=''){this.id=id;this.dataset={};this.disabled=false;this.value='';this.options=[];this.children=[];this.listeners={};this.attributes={};this._text='';this._html='';this.focusCount=0;this.tagName='DIV';this.hidden=false;this.style={};const classes=new Set();this.classList={add:(...v)=>v.forEach(x=>classes.add(x)),remove:(...v)=>v.forEach(x=>classes.delete(x)),contains:v=>classes.has(v),toggle:(v,force)=>{const add=force===undefined?!classes.has(v):force;if(add)classes.add(v);else classes.delete(v);return add;}};}
 set textContent(value){this._text=String(value??'');this._html='';this.children=[];}get textContent(){return this._text;}
 set innerText(value){this.textContent=value;}get innerText(){return this.textContent;}
 set innerHTML(value){this._html=String(value);this._text='';this.children=[];}get innerHTML(){return this._html;}
 append(...nodes){nodes.forEach(node=>this.appendChild(node));}appendChild(node){this.children.push(node);return node;}replaceChildren(...nodes){this.children=[...nodes];this._html='';this._text='';}get childNodes(){return this.children;}
 addEventListener(type,listener){(this.listeners[type]??=[]).push(listener);}fire(type,event={}){return Promise.all((this.listeners[type]||[]).map(fn=>fn({preventDefault(){},stopPropagation(){},target:this,...event})));}
 setAttribute(key,value){this.attributes[key]=String(value);}getAttribute(key){return this.attributes[key]??null;}removeAttribute(key){delete this.attributes[key];}
 querySelector(){return null;}querySelectorAll(){return [];}contains(node){return node===this||this.children.includes(node);}focus(){this.focusCount++;}getClientRects(){return this.hidden?[]:[{}];}remove(){}getBoundingClientRect(){return {top:0,right:64,height:32};}
}
function harness(autoNodes=false){
 const nodes=new Map(),selectors=new Map(),timers=new Map(),events={},docEvents={};let nextTimer=0;
 const node=id=>{if(!nodes.has(id))nodes.set(id,new Node(id));return nodes.get(id);};
 const body=new Node('body');body.appendChild=element=>{body.children.push(element);if(element.id)nodes.set(element.id,element);return element;};
 const document={readyState:'loading',currentScript:{src:'http://localhost/nested/vostok/assets/js/range-client.js'},body,activeElement:null,getElementById:id=>autoNodes?node(id):nodes.get(id)||null,createElement:()=>new Node(),querySelector:selector=>(selectors.get(selector)||[])[0]||null,querySelectorAll:selector=>selectors.get(selector)||[],addEventListener:(type,fn)=>(docEvents[type]??=[]).push(fn)};
 const location={origin:'http://localhost',href:'http://localhost/nested/vostok/SOC/Page.php',pathname:'/nested/vostok/SOC/Page.php',reloads:0,reload(){this.reloads++;},assign(url){this.assigned=url;}};
 const window={location,innerWidth:768,addEventListener:(type,fn)=>(events[type]??=[]).push(fn)};
 const context={window,document,location,URL,URLSearchParams,AbortController,structuredClone,console:{error(){}},setTimeout:(fn,ms)=>{const id=++nextTimer;timers.set(id,{fn,ms});return id;},clearTimeout:id=>timers.delete(id),requestAnimationFrame:fn=>fn(),FormData:class{constructor(form){this.form=form;}entries(){return Object.entries(this.form.fields||{}).values();}[Symbol.iterator](){return this.entries();}get(key){return this.form.fields?.[key];}},Option:class{constructor(text,value){this.text=text;this.value=value;}},fetch:()=>{throw new Error('Unexpected real transport');}};
 vm.createContext(context);
 return {context,window,document,location,nodes,node,selectors,timers,events,docEvents,run(file){vm.runInContext(fs.readFileSync(path.join(root,file),'utf8'),context,{filename:file});},ready(){for(const fn of docEvents.DOMContentLoaded||[])fn();},tick(ms){for(const [id,timer] of [...timers])if(timer.ms===ms){timers.delete(id);timer.fn();}},emit(type){for(const fn of events[type]||[])fn();}};
}
function response(status=200,data={success:true,data:[]},json){return {status,ok:status>=200&&status<300,headers:{get:()=>null},json:json||(()=>Promise.resolve(data))};}
function deferredApi(h){const calls=[];h.window.RangeClient={request:(endpoint,options={})=>{const item={endpoint,options,...deferred()};calls.push(item);return item.promise;},get:(endpoint,params,options)=>h.window.RangeClient.request(endpoint,options),showToast:(message,type)=>{h.toasts.push({message,type});}};h.toasts=[];return calls;}
const succeed=(call,data)=>call.resolve({success:true,data,...(Array.isArray(data)?{pagination:{total:data.length,offset:0,limit:25,returned:data.length,has_more:false,next_offset:null,previous_offset:null}}:{})});
function fields(form,names){form.elements={};for(const name of names){form.elements[name]=new Node();form[name]=form.elements[name];}return form;}

async function clientTests(){
 const h=harness();const calls=[];h.window.VOSTOK_API_TIMEOUT_MS=25;h.context.fetch=(url,options)=>{const call={url,options,...deferred()};calls.push(call);return call.promise;};h.run('assets/js/range-client.js');const client=h.window.RangeClient;
 let request=client.get('soc/models');h.tick(25);let result=await request;
 check(!result.success&&result.error.code==='TIMEOUT','hung GET reaches configurable deadline instead of infinite Loading');
 check(calls[0].options.signal.aborted&&client.readControllers.size===0,'deadline aborts transport and releases active read');
 check(![...h.timers.values()].some(timer=>timer.ms===25),'timed-out request clears deadline timer');
 request=client.get('soc/models');const body=deferred();calls.at(-1).resolve(response(200,null,()=>body.promise));await flush();h.tick(25);result=await request;
 check(result.error.code==='TIMEOUT','response-body stall is included in request deadline');body.resolve({success:true,data:['late']});await flush();
 const controller=new AbortController();request=client.get('soc/models',{}, {signal:controller.signal});controller.abort();result=await request;
 check(result.error.code==='CANCELLED'&&!result.success,'explicit read cancellation is classified without invented success');
 request=client.post('soc/tickets',{title:'write'});const before=calls.length;h.tick(25);result=await request;
 check(result.error.code==='UNKNOWN_OUTCOME'&&result.error.outcome_unknown,'write timeout warns that server commit is unknown');
 check(calls.length===before,'timed-out mutation is never automatically retried');
 const writeController=new AbortController();request=client.patch('soc/models/1',{}, {signal:writeController.signal});writeController.abort();result=await request;
 check(result.error.code==='UNKNOWN_OUTCOME','interrupted PATCH never pretends cancellation proves rollback');
 request=client.post('soc/tickets',{});calls.at(-1).reject(new Error('connection lost'));result=await request;
 check(result.error.code==='UNKNOWN_OUTCOME','lost write connection requires checking server state before retry');
 const uploadBody={};request=client.upload('soc/datasets',uploadBody);check([...h.timers.values()].some(timer=>timer.ms===120000),'upload uses separately configurable bounded allowance');check(calls.at(-1).options.body===uploadBody&&!calls.at(-1).options.headers['Content-Type'],'multipart body remains intact and browser chooses its boundary');calls.at(-1).resolve(response());await request;
 for(const status of [400,401,403,404,429,500]){request=client.get('soc/models');const res=response(status,{success:false,error:{code:'DENIED',message:'Rejected '+status}});if(status===429)res.headers.get=()=> '17';calls.at(-1).resolve(res);result=await request;check(!result.success&&!client.readControllers.size&&! [...h.timers.values()].some(timer=>timer.ms===25),'HTTP '+status+' ends pending request and clears read resources');if(status===429)check(result.error.retry_after_seconds===17,'429 exposes valid Retry-After without silently retrying');}
 request=client.get('soc/models');calls.at(-1).resolve(response(401));await request;
 check([...h.timers.values()].filter(timer=>timer.ms===1200).length===1,'concurrent expired sessions schedule a single login redirect');
 request=client.get('soc/models');h.emit('pagehide');result=await request;check(result.error.code==='CANCELLED','page departure cancels outstanding reads');
 request=client.post('soc/tickets',{});h.emit('pagehide');check(!calls.at(-1).options.signal.aborted,'page cleanup does not abort an in-flight mutation');calls.at(-1).resolve(response());await request;
 const original=client;h.run('assets/js/range-client.js');check(h.window.RangeClient===original&&(h.events.pagehide||[]).length===1,'repeated client inclusion reuses singleton and cleanup listener');
 check(calls.every(call=>call.options.credentials==='same-origin'&&call.url.startsWith('/nested/vostok/api/v1/')),'timeouts preserve nested same-origin session transport');
}

async function trainingTests(){
 const h=harness(),calls=deferredApi(h),form=fields(h.node('form-edit-student'),['student_id','full_name','email','cohort','department']);h.context.openModal=id=>h.node(id).classList.remove('hidden');h.context.closeModal=id=>{h.window.cancelSocRead(id);h.node(id).classList.add('hidden');};h.run('assets/js/soc-training.js');
 const a=h.window.openEditStudentModal(1),b=h.window.openEditStudentModal(2);succeed(calls[1],{profile:{full_name:'new student'}});await b;succeed(calls[0],{profile:{full_name:'old student'}});await a;
 check(form.student_id.value===2&&form.full_name.value==='new student','slower earlier student response cannot replace latest edit form');
 check(calls[0].options.signal.aborted,'replaced student read is aborted');
 const c=h.window.openEditStudentModal(3);h.window.cancelSocRead('modal-edit-student');h.node('modal-edit-student').classList.add('hidden');succeed(calls.at(-1),{profile:{full_name:'closed'}});await c;
 check(h.node('modal-edit-student').classList.contains('hidden')&&form.student_id.value===2,'closed edit modal is not reopened by late response');
 fields(h.node('soc-ticket-edit-form'),['ticket_id','title','description','requirements','acceptance_criteria','priority','scenario_id','deadline']);fields(h.node('soc-ticket-reassign-form'),['ticket_id']);for(const id of ['soc-ticket-heading','soc-ticket-status','soc-ticket-save','soc-ticket-reassign','soc-ticket-cancel','soc-ticket-relations','soc-ticket-comments','soc-ticket-management-modal'])h.node(id);
 const first=h.window.openSocTicketModal(10),firstCalls=calls.slice(-4),second=h.window.openSocTicketModal(20),secondCalls=calls.slice(-4);
 succeed(secondCalls[0],{ticket_code:'NEW',status:'ASSIGNED',title:'new ticket',comments:[]});for(const call of secondCalls.slice(1))succeed(call,[]);await second;
 succeed(firstCalls[0],{ticket_code:'OLD',status:'ASSIGNED',title:'old ticket',comments:[]});for(const call of firstCalls.slice(1))succeed(call,[]);await first;
 check(h.node('soc-ticket-heading').textContent==='NEW'&&h.node('soc-ticket-edit-form').ticket_id.value===20,'ticket details and relation bundle commit for the same latest ticket');
 const cancel=h.window.cancelSocTicket();check(calls.at(-1).endpoint==='soc/tickets/20/cancel','ticket mutation targets currently rendered ticket after read race');succeed(calls.at(-1),{});await cancel;
 const button=new Node();button.disabled=true;const activeButton=new Node();const create=fields(new Node(),['full_name','identifier','email','cohort','department','password']);create.querySelectorAll=()=>[button,activeButton];const event={target:create,preventDefault(){}};
 const save=h.window.handleCreateStudent(event),repeat=h.window.handleCreateStudent(event);const write=calls.at(-1);await repeat;check(calls.filter(call=>call.endpoint==='soc/students'&&call.options.method==='POST').length===1,'two rapid training form submits produce one write');write.reject(new Error('offline'));await save;
 check(button.disabled&& !activeButton.disabled&&create.full_name.value==='','failure restores original policy-disabled state and form inputs');
 const existing=h.window.handleCreateStudent;h.run('assets/js/soc-training.js');check(h.window.handleCreateStudent===existing,'training script reinitialization keeps existing read/write state');
}

async function scenarioTests(){
 const h=harness(true),calls=deferredApi(h);h.node('soc-config').textContent='{}';h.node('scenario-builder-modal').classList.add('hidden');h.run('AI Operations Center (AI SOC)/js/main.js');
 const data=id=>({id,code:'SC-'+id,title:'Scenario '+id,status:'DRAFT',version:'v1',revision:id.toString(16).padStart(64,'0'),builder_metadata:{}});
 const first=h.window.openScenarioBuilderModal(1),second=h.window.openScenarioBuilderModal(2);succeed(calls[1],data(2));await second;succeed(calls[0],data(1));await first;
 check(h.node('editor-modal-title').textContent==='Edit Specification: Scenario 2','ten-step builder ignores stale scenario response');
 const pending=h.window.openScenarioBuilderModal(3);h.window.closeScenarioBuilderModal();succeed(calls.at(-1),data(3));await pending;check(h.node('scenario-builder-modal').classList.contains('hidden'),'closed pending scenario editor remains closed');
 const list1=h.window.loadScenarios(),older=calls.at(-1),list2=h.window.loadScenarios(),newer=calls.at(-1);succeed(newer,[data(20)]);await list2;succeed(older,[data(10)]);await list1;check(h.node('scenarios-grid-cards').innerHTML.includes('Scenario 20')&&!h.node('scenarios-grid-cards').innerHTML.includes('Scenario 10'),'catalog uses latest response after overlapping refreshes');
 const preview1=h.window.previewScenarioAsStudent(1),oldPreview=calls.at(-1),preview2=h.window.previewScenarioAsStudent(2),newPreview=calls.at(-1);succeed(newPreview,data(2));await preview2;succeed(oldPreview,data(1));await preview1;check(h.node('preview-student-title').textContent==='Scenario 2','student scenario preview is latest-response-wins');
 const edit=h.window.openScenarioBuilderModal(4);succeed(calls.at(-1),data(4));await edit;
 const controls=['edit-id','edit-title','edit-description','edit-difficulty','edit-department','edit-version','edit-lifecycle-status','edit-changelog'].map(id=>h.node(id));h.selectors.set('#scenario-builder-modal input[id],#scenario-builder-modal textarea[id],#scenario-builder-modal select[id]',controls);h.node('edit-title').value='Unsaved title';h.node('edit-id').value='SC-4';
 const button=new Node(),disabledButton=new Node();disabledButton.disabled=true;h.selectors.set('#scenario-builder-modal button',[button,disabledButton]);const save=h.window.saveCurrentScenario(true),again=h.window.saveCurrentScenario(true);await again;const write=calls.at(-1);check(calls.filter(call=>call.options.method==='PATCH').length===1,'builder rapid saves submit one mutation');check(JSON.parse(write.options.body).expected_revision===data(4).revision,'scenario edit sends revision from actual loaded editor record');write.resolve({success:false,error:{code:'CONFLICT',message:'Scenario changed in another editor.'}});await save;
 check(h.node('edit-title').value==='Unsaved title'&&!button.disabled&&disabledButton.disabled&&!h.node('scenario-builder-modal').classList.contains('hidden'),'failed builder save retains inputs, open state and disabled controls');
 check(h.node('toast-container').children.at(-1).textContent.includes('reload the latest scenario')&&calls.filter(call=>call.options.method==='PATCH').length===1,'scenario conflict explains reload and never automatically retries stale revision');
 const transition=h.window.triggerLifecycleTransition(20,'READY_FOR_REVIEW'),lifecycle=calls.at(-1);check(JSON.parse(lifecycle.options.body).expected_revision===data(20).revision,'catalog lifecycle mutation sends actual listed revision');lifecycle.resolve({success:false,error:{code:'CONFLICT',message:'Scenario changed.'}});await transition;
 const existing=h.window.openScenarioBuilderModal;h.run('AI Operations Center (AI SOC)/js/main.js');check(h.window.openScenarioBuilderModal===existing&&(h.docEvents.DOMContentLoaded||[]).length===1,'repeated scenario script initializes catalog only once');
}

async function workspaceTests(){
 const h=harness(),button=new Node(),disabledButton=new Node();button.textContent='Save';disabledButton.disabled=true;disabledButton.textContent='Locked';const form=new Node();form.dataset={socApi:'soc/models/1',socMethod:'PATCH'};form.fields={csrf_token:'transport-only',admin_notes:'keep my input'};form.querySelectorAll=()=>[button,disabledButton];h.selectors.set('form[data-soc-api]',[form]);const calls=deferredApi(h);h.run('assets/js/soc-workspaces.js');h.run('assets/js/soc-workspaces.js');h.ready();
 check(form.listeners.submit.length===1,'workspace forms bind once after duplicate script initialization');
 const save=form.fire('submit'),repeat=form.fire('submit');await repeat;check(calls.length===1,'workspace rapid submits share one in-flight mutation');calls[0].reject(new Error('transport rejected'));await save;
 check(!button.disabled&&button.textContent==='Save'&&disabledButton.disabled&&form.fields.admin_notes==='keep my input'&&form.dataset.saving==='false','rejected workspace transport restores controls and preserves data');
 check(!h.location.reloads&&h.toasts.at(-1).type==='error','workspace failure never reloads or claims saved');
}

async function notificationTests(){
 const h=harness(),button=h.node('vp-notif-btn'),popover=h.node('vp-notif-popover'),container=h.node('vp-notif-container'),body=new Node();container.contains=()=>true;popover.querySelector=()=>body;h.document.currentScript.src='http://localhost/nested/vostok/assets/js/app-layout.js';const requests=[];h.context.fetch=(url,options)=>{const call={url,options,...deferred()};requests.push(call);return call.promise;};h.run('assets/js/app-layout.js');h.run('assets/js/app-layout.js');h.ready();
 check(button.listeners.click.length===1,'notification popover binds one click listener');
 await button.fire('click');await button.fire('click');await button.fire('click');requests[1].resolve(response(200,{success:true,data:[{title:'new notification'}]}));await flush();requests[0].resolve(response(200,{success:true,data:[{title:'old notification'}]}));await flush();
 check(body.children[0].children[0].textContent==='new notification'&&requests[0].options.signal.aborted,'close/reopen notifications ignore earlier response');
 await button.fire('click');await button.fire('click');h.tick(15000);await flush();check(body.textContent.includes('timed out')&&!body.textContent.includes('Loading'),'notification timeout clears loading state on legacy pages without client');
 await button.fire('click');await button.fire('click');h.emit('pagehide');check(requests.at(-1).options.signal.aborted,'notification read is cancelled on page departure');
}

async function datasetTests(){
 const h=harness(),form=new Node(),button=new Node();button.textContent='Upload real dataset';form.dataset={datasetApi:'soc/datasets'};form.fields={name:'retain me',file:'selected-real-upload'};form.enctype='multipart/form-data';form.querySelector=selector=>selector==='button[type="submit"]'?button:form.status||null;form.appendChild=node=>{form.status=node;return node;};h.selectors.set('form[data-dataset-api]',[form]);const calls=deferredApi(h);h.window.RangeClient.upload=(endpoint,body)=>h.window.RangeClient.request(endpoint,{method:'POST',body});h.run('assets/js/dataset-management.js');h.run('assets/js/dataset-management.js');h.ready();
 check(form.listeners.submit.length===1,'dataset management forms initialize once');const save=form.fire('submit'),repeat=form.fire('submit');await repeat;check(calls.length===1&&button.disabled,'rapid dataset upload submits one request and disables submit');calls[0].resolve({success:false,error:{code:'UNKNOWN_OUTCOME',message:'Upload timed out. Check server state before retrying.'}});await save;
 check(!button.disabled&&form.dataset.saving==='false'&&form.status.textContent.includes('Check server state')&&!h.location.assigned,'dataset timeout recovers controls without false navigation or success');
 check(form.fields.name==='retain me'&&form.fields.file==='selected-real-upload','dataset failure preserves metadata and selected file reference');
}

async function dossierTests(){
 const h=harness(),calls=deferredApi(h);for(const id of ['modal-dossier','dossier-content','dossier-title','toast'])h.node(id);const source=fs.readFileSync(path.join(root,'AI Operations Center (AI SOC)/StudentManagement.php'),'utf8');const inline=source.match(/<script>\s*const CSRF_TOKEN[\s\S]*?<\/script>/)[0].replace(/^<script>|<\/script>$/g,'').replace(/<\?=[\s\S]*?\?>/g,'test-token');vm.runInContext(inline,h.context);
 const data=name=>({profile:{full_name:name,identifier:'ID',cohort:'<img src=x>',email:'email',status:'ACTIVE',created_at:'2026-10-31 12:00:00'},tickets:[],datasets:[],notebooks:[],submissions:[]});const first=h.context.viewDossier(1),second=h.context.viewDossier(2);succeed(calls[1],data('new student'));await second;succeed(calls[0],data('old student'));await first;
 check(h.node('dossier-title').textContent==='Dossier: new student (ID)','student dossier ignores stale student response');
 check(h.node('dossier-content').innerHTML.includes('&lt;img src=x&gt;')&&!h.node('dossier-content').innerHTML.includes('<img'),'existing recursive dossier escaping remains intact');
 const third=h.context.viewDossier(3);h.context.closeModal('modal-dossier');succeed(calls.at(-1),data('closed'));await third;check(h.node('modal-dossier').classList.contains('hidden')&&!h.node('dossier-title').textContent.includes('closed'),'closed dossier ignores late completion');
 h.context.showToast('older');h.context.showToast('newer');check([...h.timers.values()].filter(timer=>timer.ms===3000).length===1,'new local toast replaces its previous hide timer');
}

async function sidebarTests(){
 const h=harness();const sidebar=h.node('vp-sidebar'),backdrop=h.node('vp-sidebar-backdrop'),toggle=h.node('vp-sidebar-toggle'),close=h.node('vp-sidebar-close'),main=h.node('vp-main-content'),link=new Node();sidebar.querySelectorAll=selector=>selector==='.vp-sidebar-item'?[link]:[link];sidebar.querySelector=()=>link;h.run('assets/js/sidebar.js');h.run('assets/js/sidebar.js');h.ready();
 check(toggle.listeners.click.length===1,'sidebar initializes one toggle listener');await toggle.fire('click');await close.fire('click');h.tick(50);check(link.focusCount===0&&!sidebar.classList.contains('is-mobile-open'),'immediate drawer close cancels delayed hidden-element focus');
 await toggle.fire('click');h.tick(50);check(link.focusCount===1&&main.getAttribute('aria-hidden')==='true'&&backdrop.classList.contains('is-visible'),'drawer retains intended opening focus and background state');h.window.innerWidth=1366;h.emit('resize');check(!sidebar.classList.contains('is-mobile-open')&&main.getAttribute('aria-hidden')===null,'desktop resize restores drawer background accessibility');
}

async function notebookRevisionTests(){
 function editorFixture(){const h=harness(),editor=fields(h.node('notebook-editor'),['notebook_id','expected_version']),source=new Node(),type=new Node(),status=new Node(),save=new Node(),run=new Node();editor.notebook_id.value='7';editor.expected_version.value='3';source.value='print("entered code")';type.value='code';run.disabled=true;const row=new Node();row.querySelector=selector=>selector.startsWith('textarea')?source:type;editor.querySelectorAll=selector=>selector==='[data-notebook-cell]'?[row]:[save,run];editor.querySelector=()=>status;h.selectors.set('[data-notebook-version-label]',[new Node()]);h.selectors.set('[data-notebook-updated]',[new Node()]);const calls=deferredApi(h);h.window.RangeClient.patch=(endpoint,body)=>h.window.RangeClient.request(endpoint,{method:'PATCH',body:JSON.stringify(body)});h.run('ML Workbench/js/main.js');h.run('ML Workbench/js/main.js');h.ready();return {h,editor,source,status,save,run,calls};}
 const first=editorFixture(),second=editorFixture();const a=first.editor.fire('submit'),b=second.editor.fire('submit');
 check(JSON.parse(first.calls[0].options.body).expected_version===3&&JSON.parse(second.calls[0].options.body).expected_version===3,'two notebook editors send the version each actually loaded');
 succeed(first.calls[0],{id:7,version:4,status:'SAVED',updated_at:'2026-10-31 14:00:00'});await a;second.calls[0].resolve({success:false,error:{code:'CONFLICT',message:'Notebook has changed.'}});await b;
 check(first.editor.expected_version.value===4&&first.status.textContent.includes('Notebook saved'),'successful notebook save adopts only returned persisted version');
 check(second.editor.expected_version.value==='3'&&second.source.value==='print("entered code")'&&second.status.textContent.includes('Copy your changes, then reload'),'stale notebook conflict retains original version and entered source with reload guidance');
 check(second.calls.length===1&&!second.save.disabled&&second.run.disabled&&!second.h.location.reloads,'conflicting notebook save restores policy controls without retry or destructive navigation');
 check(first.editor.listeners.submit.length===1&&second.editor.listeners.submit.length===1,'notebook save transport initializes exactly once');
 const next=first.editor.fire('submit');first.source.value='print("new edit while saving")';succeed(first.calls.at(-1),{id:7,version:5,status:'SAVED'});await next;
 check(first.source.value==='print("new edit while saving")'&&first.status.textContent.includes('newer edits still need saving'),'snapshot success preserves edits typed while request was pending');
}

(async()=>{await clientTests();await trainingTests();await scenarioTests();await workspaceTests();await notificationTests();await datasetTests();await dossierTests();await sidebarTests();await notebookRevisionTests();console.log(passed+' deterministic async frontend checks passed; no HTTP/database access.');})().catch(error=>{console.error(error.stack);process.exitCode=1;});
