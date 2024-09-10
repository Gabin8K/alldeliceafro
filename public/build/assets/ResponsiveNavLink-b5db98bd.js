import{B as h,V as x,m as l,r as w,o as c,c as _,b as d,z as n,g as k,N as m,a as $,w as g,n as u,M as C,k as p,u as y,H as v}from"./app-87e4b527.js";const S={class:"relative"},E={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:String,default:"py-1 bg-white dark:bg-gray-700"}},setup(e){const t=e,a=i=>{r.value&&i.key==="Escape"&&(r.value=!1)};h(()=>document.addEventListener("keydown",a)),x(()=>document.removeEventListener("keydown",a));const s=l(()=>({48:"w-48"})[t.width.toString()]),f=l(()=>t.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":t.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top"),r=w(!1);return(i,o)=>(c(),_("div",S,[d("div",{onClick:o[0]||(o[0]=b=>r.value=!r.value)},[n(i.$slots,"trigger")]),k(d("div",{class:"fixed inset-0 z-40",onClick:o[1]||(o[1]=b=>r.value=!1)},null,512),[[m,r.value]]),$(C,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"opacity-0 scale-95","enter-to-class":"opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"opacity-100 scale-100","leave-to-class":"opacity-0 scale-95"},{default:g(()=>[k(d("div",{class:u(["absolute z-50 mt-2 rounded-md shadow-lg",[s.value,f.value]]),style:{display:"none"},onClick:o[2]||(o[2]=b=>r.value=!1)},[d("div",{class:u(["rounded-md ring-1 ring-black ring-opacity-5",e.contentClasses])},[n(i.$slots,"content")],2)],2),[[m,r.value]])]),_:3})]))}},L={__name:"DropdownLink",props:{href:{type:String,required:!0}},setup(e){return(t,a)=>(c(),p(y(v),{href:e.href,class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"},{default:g(()=>[n(t.$slots,"default")]),_:3},8,["href"]))}},N={__name:"NavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(e){const t=e,a=l(()=>t.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out");return(s,f)=>(c(),p(y(v),{href:e.href,class:u(a.value)},{default:g(()=>[n(s.$slots,"default")]),_:3},8,["href","class"]))}},z={__name:"ResponsiveNavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(e){const t=e,a=l(()=>t.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 dark:border-indigo-600 text-start text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out");return(s,f)=>(c(),p(y(v),{href:e.href,class:u(a.value)},{default:g(()=>[n(s.$slots,"default")]),_:3},8,["href","class"]))}};export{N as _,L as a,E as b,z as c};
