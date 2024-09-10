import{Z as C}from"./MazTextarea-b76d04fa.js";import{r as c,T as $,c as w,a as t,u as o,w as n,F as k,o as F,Z as O,b as a,d as f,e as P,h as M,Q as N,O as D}from"./app-87e4b527.js";import{_ as T}from"./AuthenticatedLayout-cd5bbb9d.js";import{_ as U}from"./TableTanstack-92db18e5.js";import j from"./EditDeleteButton-56e8ac2e.js";import{R as E}from"./MazDialog-fdEu8dqH-79fc69b2.js";import{O as g}from"./MazBtn-DgGnjAgh-dfd0a08f.js";import{y as I}from"./MazInput-TEx7J5N7-e9b11969.js";import{v as A,p as B,a as K}from"./filepond-plugin-image-preview.esm-ee57de24.js";import{_ as d}from"./InputError-937ebae9.js";import"./ApplicationLogo-dfe0f8b3.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ResponsiveNavLink-b5db98bd.js";const R=a("h2",{class:"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"},"Shops",-1),Z={class:"py-12"},L={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},X={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:relative"},q={class:"ms-4 sm:ms-6 lg:ms-8 mt-5 sm:absolute sm:top-0.5"},z={class:"pb-6"},G=["onSubmit"],v=1,ie={__name:"Index",props:{shops:{type:Object}},setup(_){const m=c(!1),p=c(!1),s=$({name:"",description_en:"",description_fr:"",description_de:"",images:[]}),b=A(K,B),h=[{accessorKey:"name",header:"Name"},{accessorKey:"edit",header:"Actions",cell:({row:r})=>M(j,{id:r.original.id}),enableSorting:!1}],x=()=>{s.post(route("admin.shops.store",N().props.currentLocale),{preserveScroll:!0,preserveState:r=>Object.keys(r.props.errors).length})};function V(){s.reset(),s.clearErrors(),p.value=!1}function S(r){return s.images.push(r),r}function y(r,e,i){s.images=s.images.filter(l=>l!==r),D.delete("/en/delete-tmp/"+r),e()}function u(r){p.value=r}return(r,e)=>{const i=C;return F(),w(k,null,[t(o(O),{title:"Shops"}),t(T,null,{header:n(()=>[R]),default:n(()=>[a("div",Z,[a("div",L,[a("div",X,[a("div",q,[t(o(g),{onClick:e[0]||(e[0]=l=>m.value=!0),outline:""},{default:n(()=>[f(" Create shop ")]),_:1})]),a("div",z,[t(U,{data:_.shops,columns:h},null,8,["data"])])])])]),t(o(E),{modelValue:m.value,"onUpdate:modelValue":e[8]||(e[8]=l=>m.value=l),title:"Create shop",width:"800px",maxHeight:"80vh",scrollable:"",onClose:e[9]||(e[9]=l=>V())},{default:n(()=>[a("form",{onSubmit:P(x,["prevent"]),class:"space-y-6"},[a("div",null,[t(o(I),{modelValue:o(s).name,"onUpdate:modelValue":e[1]||(e[1]=l=>o(s).name=l),label:"Name",required:""},null,8,["modelValue"]),t(d,{class:"mt-1",message:o(s).errors.name},null,8,["message"])]),a("div",null,[t(i,{modelValue:o(s).description_en,"onUpdate:modelValue":e[2]||(e[2]=l=>o(s).description_en=l),label:"Description (en)"},null,8,["modelValue"]),t(d,{class:"mt-1",message:o(s).errors.description_en},null,8,["message"])]),a("div",null,[t(i,{modelValue:o(s).description_fr,"onUpdate:modelValue":e[3]||(e[3]=l=>o(s).description_fr=l),label:"Description (fr)"},null,8,["modelValue"]),t(d,{class:"mt-1",message:o(s).errors.description_fr},null,8,["message"])]),a("div",null,[t(i,{modelValue:o(s).description_de,"onUpdate:modelValue":e[4]||(e[4]=l=>o(s).description_de=l),label:"Description (de)"},null,8,["modelValue"]),t(d,{class:"mt-1",message:o(s).errors.description_de},null,8,["message"])]),t(o(b),{name:"image",ref:"pond","label-idle":"Drop images here... Max: "+v,class:"cursor-pointer","allow-multiple":!0,maxFiles:v,required:!0,"accepted-file-types":"image/jpeg, image/png, image/jpg",onInitfile:e[5]||(e[5]=l=>u(!0)),onProcessfilestart:e[6]||(e[6]=l=>u(!0)),onProcessfiles:e[7]||(e[7]=l=>u(!1)),server:{url:"",process:{url:"/en/upload-tmp",method:"POST",onload:S},revert:y,headers:{"X-CSRF-TOKEN":r.$page.props.csrf_token}}},null,8,["label-idle","server"]),t(o(g),{type:"submit",disabled:o(s).processing||p.value||!o(s).isDirty,block:""},{default:n(()=>[f(" Save ")]),_:1},8,["disabled"])],40,G)]),_:1},8,["modelValue"])]),_:1})],64)}}};export{ie as default};
