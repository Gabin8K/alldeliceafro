import{T as u,k as p,w as l,o as c,a,u as e,Z as f,b as t,d as _,n as w,e as g,Q as V}from"./app-87e4b527.js";import{_ as b}from"./GuestLayout-2bbf176f.js";import{_ as m}from"./InputError-937ebae9.js";import{_ as i,a as n}from"./TextInput-4b3ac4d0.js";import{P as v}from"./PrimaryButton-0dd8f42f.js";import"./ApplicationLogo-dfe0f8b3.js";import"./_plugin-vue_export-helper-c27b6911.js";const k=["onSubmit"],x={class:"mt-4"},y={class:"flex items-center justify-end mt-4"},T={__name:"Login",setup(h){const s=u({email:"",password:""}),d=()=>{s.post(route("admin.authenticate",V().props.currentLocale),{onFinish:()=>s.reset("password")})};return(B,o)=>(c(),p(b,null,{default:l(()=>[a(e(f),{title:"Log in"}),t("form",{onSubmit:g(d,["prevent"])},[t("div",null,[a(i,{for:"email",value:"Email"}),a(n,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":o[0]||(o[0]=r=>e(s).email=r),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(m,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),t("div",x,[a(i,{for:"password",value:"Password"}),a(n,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:e(s).password,"onUpdate:modelValue":o[1]||(o[1]=r=>e(s).password=r),required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(m,{class:"mt-2",message:e(s).errors.password},null,8,["message"])]),t("div",y,[a(v,{class:w(["ms-4",{"opacity-25":e(s).processing}]),disabled:e(s).processing},{default:l(()=>[_(" Log in ")]),_:1},8,["class","disabled"])])],40,k)]),_:1}))}};export{T as default};
