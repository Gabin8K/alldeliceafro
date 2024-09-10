import{l as x,v as A,x as L,y as M,m as a,o as n,k as l,w as R,c as d,n as s,i as t,z as c,u,A as r,E as g,_ as h}from"./app-87e4b527.js";import"./MazBtn-DgGnjAgh-dfd0a08f.js";import{b as w}from"./MazSelect-qw3H2BrO-4eb8767a.js";const D=x({__name:"MazBtn",props:{variant:{default:"button"},size:{default:"md"},color:{default:"primary"},type:{default:"button"},rounded:{type:Boolean},noRounded:{type:Boolean},outline:{type:Boolean},pastel:{type:Boolean},block:{type:Boolean},noUnderline:{type:Boolean},noLeading:{type:Boolean},loading:{type:Boolean},disabled:{type:Boolean},fab:{type:Boolean},icon:{default:void 0},leftIcon:{default:void 0},rightIcon:{default:void 0},noPadding:{type:Boolean},noElevation:{type:Boolean},contentClass:{default:void 0}},setup(_){const k=g(()=>h(()=>import("./MazSpinner-Pnq_8QwR-3f91d9cd.js"),["assets/MazSpinner-Pnq_8QwR-3f91d9cd.js","assets/MazSelect-qw3H2BrO-4eb8767a.js","assets/app-87e4b527.js","assets/app-243e1840.css","assets/MazSelect-qw3H2BrO-be07b972.css","assets/MazSpinner-BHGuV2dF-3735f199.css"])),f=g(()=>h(()=>import("./MazIcon-Cxrv3_OK-4800a7e9.js"),["assets/MazIcon-Cxrv3_OK-4800a7e9.js","assets/app-87e4b527.js","assets/app-243e1840.css"])),{href:B,to:I}=A(),v=L(),o=_;M(()=>{o.icon&&!o.fab&&console.error('[maz-ui](MazBtn) the prop "icon" must be used only with "fab" props')});const p=a(()=>B?"a":I?"router-link":"button"),z=a(()=>o.pastel?`--${o.color}-pastel`:o.outline?`--${o.color}-outline`:`--${o.color}`),m=a(()=>(o.loading||o.disabled)&&p.value==="button"),$=a(()=>m.value?"--cursor-default":"--cursor-pointer"),C=a(()=>`--is-${o.variant}`),i=a(()=>o.loading&&o.variant==="button"),b=a(()=>!!v["left-icon"]||o.leftIcon),y=a(()=>!!v["right-icon"]||o.rightIcon),E=a(()=>b.value||y.value),T=a(()=>o.fab&&(o.icon||!!v.icon)),P=a(()=>p.value==="button"?o.type:void 0);return(e,U)=>(n(),l(r(p.value),{disabled:m.value,class:s(["m-btn",[`--${e.size}`,z.value,$.value,C.value,{"--block":e.block,"--no-underline":e.noUnderline,"--no-leading":e.noLeading,"--fab":e.fab,"--loading":e.loading,"--disabled":m.value,"--icon":E.value,"--rounded":e.rounded,"--no-rounded":e.noRounded,"--no-padding":e.noPadding,"--no-elevation":e.noElevation}]]),type:P.value},{default:R(()=>[b.value?(n(),d("div",{key:0,class:s(["m-btn__icon-left maz-flex maz-flex-center",{"maz-invisible":i.value}])},[t(`
        @slot left-icon - The icon to display on the left of the button
      `),c(e.$slots,"left-icon",{},()=>[typeof e.leftIcon=="string"?(n(),l(u(f),{key:0,name:e.leftIcon},null,8,["name"])):e.leftIcon?(n(),l(r(e.leftIcon),{key:1})):t("v-if",!0)],!0)],2)):t("v-if",!0),T.value?(n(),d("div",{key:1,class:s(["m-btn__icon",{"maz-invisible":i.value}])},[t(`
        @slot icon - The icon to display on the fab button
      `),c(e.$slots,"icon",{},()=>[typeof e.icon=="string"?(n(),l(u(f),{key:0,name:e.icon},null,8,["name"])):e.icon?(n(),l(r(e.icon),{key:1})):t("v-if",!0)],!0)],2)):t("v-if",!0),e.$slots.default?(n(),d("span",{key:2,class:s([{"maz-invisible":i.value},e.contentClass])},[t(`
        @slot default - The content of the button
      `),c(e.$slots,"default",{},void 0,!0)],2)):t("v-if",!0),y.value?(n(),d("div",{key:3,class:s(["m-btn__icon-right",{"maz-invisible":i.value}])},[t(`
        @slot right-icon - The icon to display on the right of the button
      `),c(e.$slots,"right-icon",{},()=>[typeof e.rightIcon=="string"?(n(),l(u(f),{key:0,name:e.rightIcon},null,8,["name"])):e.rightIcon?(n(),l(r(e.rightIcon),{key:1})):t("v-if",!0)],!0)],2)):t("v-if",!0),i.value?(n(),l(u(k),{key:4,class:"m-btn-loader",size:"2em",color:e.color},null,8,["color"])):t("v-if",!0)]),_:3},8,["disabled","class","type"]))}}),j=w(D,[["__scopeId","data-v-9a42c0cb"]]);export{j as default};
