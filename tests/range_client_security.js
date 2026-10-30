/* Pure mocked-client regression. No browser, network, database, or user artifacts touched. */
'use strict';
const fs=require('node:fs');
const vm=require('node:vm');
const path=require('node:path');
let passed=0;
function check(value,label){if(!value)throw new Error('FAIL '+label);passed++;process.stdout.write('PASS '+label+'\n');}
const elements=new Map();
class Element {
    constructor(tag){this.tagName=tag;this.children=[];this.className='';this.textContent='';this.content='';this.id='';this.classList={add(){},remove(){}};}
    appendChild(child){this.children.push(child);if(child.id)elements.set(child.id,child);return child;}
    append(...children){children.forEach(c=>this.appendChild(c));}
    remove(){}
    set innerHTML(_){throw new Error('Unsafe innerHTML used by client toast');}
}
const meta=new Element('meta');meta.content='session-token';
const body=new Element('body');
const document={currentScript:{src:'http://127.0.0.1/nested/mount/vostokpribor_AI/assets/js/range-client.js'},body,getElementById:id=>elements.get(id)||null,querySelector:q=>q==='meta[name="csrf-token"]'?meta:null,createElement:tag=>new Element(tag)};
const location={href:'http://127.0.0.1/nested/mount/vostokpribor_AI/AI%20Operations%20Center%20(AI%20SOC)/ModelManagement.php',origin:'http://127.0.0.1',pathname:'/nested/mount/vostokpribor_AI/AI%20Operations%20Center%20(AI%20SOC)/ModelManagement.php'};
const queue=[];const calls=[];const context={document,location,URL,URLSearchParams,console:{error(){}},requestAnimationFrame:fn=>fn(),setTimeout:()=>1,clearTimeout(){},window:{},fetch:async(url,options)=>{calls.push({url,options});const value=queue.shift();if(value instanceof Error)throw value;return value;}};
vm.createContext(context);vm.runInContext(fs.readFileSync(path.join(__dirname,'../assets/js/range-client.js'),'utf8'),context);
const client=context.window.RangeClient;
function response(status,data,invalidJSON=false){return {status,ok:status>=200&&status<300,json:async()=>{if(invalidJSON)throw new Error('not JSON');return data;}};}
(async()=>{
 check(client.baseUrl==='/nested/mount/vostokpribor_AI/api/v1','nested application prefix derived from local script URL');
 queue.push(response(500,{success:true,data:{pretend:'saved'}}));
 let result=await client.post('soc/models/1',{admin_label:'test'});
 check(result.success===false,'HTTP500 success:true body cannot claim persisted success');
 queue.push(response(500,null,true));result=await client.get('soc/models');
 check(result.success===false,'non-JSON HTTP500 is normalized failure');
 queue.push(response(200,null,true));result=await client.get('soc/models');
 check(result.success===false&&result.error.code==='INVALID_RESPONSE','non-JSON HTTP200 cannot become invented success');
 queue.push(response(200,{unrelated:true}));result=await client.get('soc/models');
 check(result.success===false,'invalid JSON API envelope cannot become success');
 queue.push(response(422,{success:false,error:{code:'VALIDATION_ERROR',message:'Invalid field'}}));result=await client.post('soc/models/1',{});
 check(result.success===false&&result.error.code==='VALIDATION_ERROR','structured API failure retains useful error');
 const callsBefore=calls.length;
 result=await client.request('https://untrusted.example/api',{method:'POST',body:'{}'});
 check(result.success===false&&result.error.code==='INVALID_ORIGIN'&&calls.length===callsBefore,'cross-origin API URL refused before fetch/token transmission');
 result=await client.request('https://[',{method:'POST'});
 check(result.success===false&&result.error.code==='INVALID_URL','invalid API URL returns normalized failure instead of throwing');
 const hostile='<img src=x onerror="globalThis.stolen=true">';
 client.showToast(hostile,'error');
 const container=elements.get('range-toast-container');const toast=container.children.at(-1);
 check(toast.children[1].textContent===hostile&&toast.children.length===2,'untrusted toast text is literal textContent, not HTML');
 check(context.stolen===undefined,'toast does not execute untrusted HTML');
 queue.push(response(200,{success:true,data:{csrf_token:'rotated-token'}}));result=await client.post('auth/change-password',{current_password:'not-real',new_password:'not-real'});
 check(result.success===true&&client.csrfToken==='rotated-token'&&meta.content==='rotated-token','successful server token rotation updates client and meta');
 const call=calls.at(-1);
 check(call.url==='http://127.0.0.1/nested/mount/vostokpribor_AI/api/v1/auth/change-password'||call.url==='/nested/mount/vostokpribor_AI/api/v1/auth/change-password','request targets correct nested application API');
 check(call.options.credentials==='same-origin'&&call.options.headers['X-CSRF-TOKEN']==='session-token'&&call.options.headers['Content-Type']==='application/json','mutating request sends session credentials and current CSRF JSON headers');
 queue.push(response(401,{success:false}));result=await client.get('soc/models');
 check(result.success===false&&result.error.code==='UNAUTHORIZED','expired session response remains failure');
 queue.push(response(403,{success:false,error:{message:hostile}}));result=await client.get('soc/models');
 check(result.success===false&&result.error.message===hostile,'403 backend error is useful but remains safe text');
 queue.push(new Error('offline'));result=await client.get('soc/models');
 check(result.success===false&&result.error.code==='NETWORK_ERROR','network rejection cannot claim success');

 // Regression: HTML CSRF injection must not become an unknown administrative JSON field.
 let submit;let reloads=0;let prevented=false;let captured;
 const formButton={disabled:false,textContent:'Save administrative annotations'};
 const form={dataset:{socApi:'soc/models/17',socMethod:'PATCH'},querySelector:()=>formButton,addEventListener:(event,listener)=>{if(event==='submit')submit=listener;}};
 const toastCalls=[];
 const transportClient={request:async(endpoint,options)=>{captured={endpoint,options,disabledWhileRequest:formButton.disabled};return {success:true,message:'Actually saved'};},showToast:(message,type)=>toastCalls.push({message,type})};
 class StubFormData{constructor(){}entries(){return [['csrf_token','injected-form-token'],['admin_label','Persisted label'],['admin_notes','Real notes']][Symbol.iterator]();}}
 const uiContext={document:{addEventListener:(event,listener)=>{if(event==='DOMContentLoaded')listener();},querySelectorAll:()=>[form]},window:{RangeClient:transportClient},FormData:StubFormData,location:{reload:()=>{reloads++;}}};
 vm.createContext(uiContext);vm.runInContext(fs.readFileSync(path.join(__dirname,'../assets/js/soc-workspaces.js'),'utf8'),uiContext);
 await submit({preventDefault:()=>{prevented=true;}});
 const submitted=JSON.parse(captured.options.body);
 check(prevented&&captured.endpoint==='soc/models/17'&&captured.options.method==='PATCH','SOC annotation form uses intended API PATCH transport');
 check(!Object.prototype.hasOwnProperty.call(submitted,'csrf_token'),'injected HTML csrf_token is excluded from strict JSON field whitelist');
 check(submitted.admin_label==='Persisted label'&&submitted.admin_notes==='Real notes','transport preserves actual annotation inputs');
 check(captured.disabledWhileRequest===true,'SOC form disables submit while backend request is outstanding');
 check(reloads===1&&toastCalls[0].message==='Actually saved','SOC form reloads only after actual backend success');
 formButton.disabled=false;formButton.textContent='Save administrative annotations';
 transportClient.request=async()=>({success:false,error:{message:'Backend rejected annotations'}});
 await submit({preventDefault(){}});
 check(reloads===1&&formButton.disabled===false&&formButton.textContent==='Save administrative annotations','API failure preserves page and restores enabled submit');
 check(toastCalls.at(-1).message==='Backend rejected annotations'&&toastCalls.at(-1).type==='error','API failure reports truthful backend error instead of success');
 process.stdout.write(passed+' mocked RangeClient security checks passed; no network/database accessed.\n');
})().catch(error=>{console.error(error.message);process.exitCode=1;});
