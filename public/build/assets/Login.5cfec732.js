import{_}from"./_plugin-vue_export-helper.cdc0426e.js";import{o as i,c as n,d as s,k as b,H as g,r as h,a as v,b as w,w as x,e as y,f as l,v as d,t as c,g as m,F as k,h as A}from"./app.944737dd.js";const j={},N={class:"vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center"},O={class:"container"},V={class:"row justify-content-center form-bg-image",style:{background:"url('/assets/images/signin.svg')"}},$={class:"col-12 d-flex align-items-center justify-content-center"};function H(o,e,a,t,p,u){return i(),n("section",N,[s("div",O,[s("div",V,[s("div",$,[b(o.$slots,"default")])])])])}const I=_(j,[["render",H]]),L={layout:I,components:{Head:g},props:{errors:Object,session:Object},setup(){const o=h({email:"",password:""});return{form:o,submit:()=>{A.Inertia.post("/login",{email:o.email,password:o.password})}}}},S=s("title",null,"Login Administrator - Aplikasi Ujian Online",-1),B={class:"bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500"},C=s("div",{class:"text-center text-md-center mb-4 mt-md-0"},[s("h3",null,"ADMINISTRATOR")],-1),D={class:"form-group mb-4"},E=s("label",{for:"email"},"Email Address",-1),M={class:"input-group"},R=s("span",{class:"input-group-text",id:"basic-addon1"},[s("i",{class:"fa fa-envelope"})],-1),T={key:0,class:"alert alert-danger mt-2"},U={class:"form-group"},F={class:"form-group mb-4"},P=s("label",{for:"password"},"Password",-1),G={class:"input-group"},q=s("span",{class:"input-group-text",id:"basic-addon2"},[s("i",{class:"fa fa-lock"})],-1),z={key:0,class:"alert alert-danger mt-2"},J=s("div",{class:"d-flex justify-content-between align-items-top mb-4"},[s("div",{class:"form-check"},[s("input",{class:"form-check-input",type:"checkbox",value:"",id:"remember"}),s("label",{class:"form-check-label mb-0",for:"remember"}," Remember me ")])],-1),K=s("div",{class:"d-grid"},[s("button",{type:"submit",class:"btn btn-gray-800"},"LOGIN")],-1);function Q(o,e,a,t,p,u){const f=v("Head");return i(),n(k,null,[w(f,null,{default:x(()=>[S]),_:1}),s("div",B,[C,s("form",{onSubmit:e[2]||(e[2]=y((...r)=>t.submit&&t.submit(...r),["prevent"])),class:"mt-4"},[s("div",D,[E,s("div",M,[R,l(s("input",{type:"email",class:"form-control","onUpdate:modelValue":e[0]||(e[0]=r=>t.form.email=r),placeholder:"Email Address"},null,512),[[d,t.form.email]])]),a.errors.email?(i(),n("div",T,c(a.errors.email),1)):m("",!0)]),s("div",U,[s("div",F,[P,s("div",G,[q,l(s("input",{type:"password",placeholder:"Password",class:"form-control","onUpdate:modelValue":e[1]||(e[1]=r=>t.form.password=r)},null,512),[[d,t.form.password]])]),a.errors.password?(i(),n("div",z,c(a.errors.password),1)):m("",!0)]),J]),K],32)])],64)}const Y=_(L,[["render",Q]]);export{Y as default};
