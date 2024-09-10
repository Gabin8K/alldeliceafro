import{A as y}from"./ApplicationLogo-dfe0f8b3.js";import{a0 as _,o as a,c as s,b as t,a as k,g as b,F as g,f as L,t as r,k as o,w as n,d as l,u as i,H as c,i as d,z as x,O as $,Q as w,a1 as S}from"./app-87e4b527.js";const B={class:"bg-white py-5 px-4 shadow-lg"},C={class:"flex items-center justify-between"},M={class:"flex items-center justify-end gap-x-4"},A={class:"relative"},D=["src"],N={id:"languageSelectionMenu",class:"bg-white shadow-md absolute top-7 -left-2 rounded-lg z-10 text-gray-800 px-6 py-3 hidden"},V={class:"flex flex-col gap-3"},j=["onClick"],E={class:"flex items-center gap-2 pr-8"},F=["src"],T={__name:"AppLayout",setup(O){function p(e){$.get(route("change.locale",[w().props.currentLocale,e]),{},{onFinish:()=>S(e)})}function h(){document.getElementById("languageSelectionMenu").classList.toggle("hidden")}function f(){document.getElementById("languageSelectionMenu").classList.add("hidden")}return(e,z)=>{const v=_("click-outside");return a(),s(g,null,[t("nav",B,[t("div",C,[t("div",null,[k(y,{class:"block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"})]),t("div",M,[b((a(),s("div",A,[t("div",{onClick:h,class:"font-bold px-1 hover:cursor-pointer hover:scale-105 transform transition duration-200"},[t("img",{class:"h-4 rounded",src:e.$page.props.available_languages[e.$page.props.currentLocale].flag,alt:"flag"},null,8,D)]),t("div",N,[t("div",V,[(a(!0),s(g,null,L(Object.entries(e.$page.props.available_languages),([m,u])=>(a(),s("div",{class:"hover:cursor-pointer hover:font-bold hover:scale-105 transform transition duration-200",onClick:I=>p(m)},[t("div",E,[t("img",{class:"h-4 rounded",src:u.flag,alt:"flag"},null,8,F),t("p",null,r(u.name),1)])],8,j))),256))])])])),[[v,f]]),e.$page.props.auth.user?d("",!0):(a(),o(i(c),{key:0,href:e.route("login",e.$page.props.currentLocale),class:"font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"},{default:n(()=>[l(r(e.$t("auth.login")),1)]),_:1},8,["href"])),e.$page.props.auth.user?d("",!0):(a(),o(i(c),{key:1,href:e.route("register",e.$page.props.currentLocale),class:"font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"},{default:n(()=>[l(r(e.$t("auth.register")),1)]),_:1},8,["href"])),e.$page.props.auth.user?(a(),o(i(c),{key:2,href:e.route("dashboard",e.$page.props.currentLocale),class:"font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"},{default:n(()=>[l("Dashboard")]),_:1},8,["href"])):d("",!0)])])]),t("main",null,[x(e.$slots,"default")])],64)}}};export{T as _};
