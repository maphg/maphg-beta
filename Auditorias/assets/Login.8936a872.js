import{u as h,a as v,r as l,o as c,c as d,b as e,w as u,v as p,d as g,e as m,f as b,p as w,g as y}from"./index.bb652687.js";import{_ as x,f as S}from"./_plugin-vue_export-helper.7b527798.js";const _=s=>(w("data-v-aa313631"),s=s(),y(),s),I={class:"flex flex-col items-center justify-center w-full h-screen gap-10"},U=b('<div class="" data-v-aa313631><h1 class="leading-none uppercase text-center font-semibold" data-v-aa313631>Auditor\xEDas</h1><div class="flex items-center justify-center gap-6 font-semibold" data-v-aa313631><h1 class="leading-none" data-v-aa313631>M</h1><h1 class="leading-none phg" data-v-aa313631>P</h1><h1 class="leading-none phg" data-v-aa313631>H</h1><h1 class="leading-none phg" data-v-aa313631>G</h1></div></div>',1),k={id:"form"},D={class:""},E={class:"mx-auto max-w-md px-6 py-12 border-0 rounded-xl card"},K={class:"relative z-0 w-full mb-5"},R=_(()=>e("label",{for:"password",class:"absolute duration-300 top-3 -z-1 origin-0 text-gray-500"}," Usuario ",-1)),V={class:"relative z-0 w-full mb-5"},z=["onKeyup"],C=_(()=>e("label",{for:"password",class:"absolute duration-300 top-3 -z-1 origin-0 text-gray-500"}," Enter password ",-1)),L={key:0,class:"text-center text-red-500"},M={__name:"Login",props:{icono:{type:String,required:!1,default:""}},setup(s){const f=h();v(),localStorage.setItem("usuario",0),localStorage.setItem("idDestino",0);const a=l({usuario:"",contrase\u00F1a:""}),n=l(!1),i=async()=>{if(!(!a.value.usuario.length||!a.value.contrase\u00F1a.length))try{const r={idUsuario:0,idDestino:0,apartado:"auditorias",accion:"login",fechaLogin:S(new Date,"yyyy-MM-dd KK:mm:ss"),usuario:a.value.usuario,contrase\u00F1a:a.value.contrase\u00F1a},o=await(await fetch("../api_auditorias/",{method:"POST",body:JSON.stringify(r)})).json();o.response=="SUCCESS"&&(localStorage.setItem("usuario",o.data[0].idUsuario),localStorage.setItem("idDestino",o.data[0].idDestino),f.push("/home")),o.response=="ERROR"&&(n.value=!0)}catch(r){console.log(r)}};return(r,t)=>(c(),d("div",I,[U,e("section",k,[e("div",D,[e("div",E,[e("div",K,[u(e("input",{"onUpdate:modelValue":t[0]||(t[0]=o=>a.value.usuario=o),type:"text",name:"password",placeholder:" ",class:"pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-white border-white/10"},null,512),[[p,a.value.usuario]]),R]),e("div",V,[u(e("input",{onKeyup:g(i,["enter"]),"onUpdate:modelValue":t[1]||(t[1]=o=>a.value.contrase\u00F1a=o),type:"password",name:"password",placeholder:" ",class:"pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-white border-white/10"},null,40,z),[[p,a.value.contrase\u00F1a]]),C]),e("button",{onClick:i,class:"w-full"},"Entrar"),n.value?(c(),d("p",L,"Usuario \xF3 contrae\xF1o no valido")):m("",!0)])])])]))}},B=x(M,[["__scopeId","data-v-aa313631"]]);export{B as default};
