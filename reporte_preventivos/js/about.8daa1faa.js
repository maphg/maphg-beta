(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["about"],{1255:function(t,e,n){t.exports=n.p+"img/incidencias.4a9446e6.svg"},"1dde":function(t,e,n){var r=n("d039"),c=n("b622"),o=n("2d00"),a=c("species");t.exports=function(t){return o>=51||!r((function(){var e=[],n=e.constructor={};return n[a]=function(){return{foo:1}},1!==e[t](Boolean).foo}))}},"65f0":function(t,e,n){var r=n("861d"),c=n("e8b5"),o=n("b622"),a=o("species");t.exports=function(t,e){var n;return c(t)&&(n=t.constructor,"function"!=typeof n||n!==Array&&!c(n.prototype)?r(n)&&(n=n[a],null===n&&(n=void 0)):n=void 0),new(void 0===n?Array:n)(0===e?0:e)}},"6c42":function(t,e,n){t.exports=n.p+"img/mupen.853c2187.svg"},"7fcf":function(t,e,n){t.exports=n.p+"img/sol.01768870.svg"},8418:function(t,e,n){"use strict";var r=n("c04e"),c=n("9bf2"),o=n("5c6c");t.exports=function(t,e,n){var a=r(e);a in t?c.f(t,a,o(0,n)):t[a]=n}},"8ca3":function(t,e,n){},"96cf":function(t,e,n){var r=function(t){"use strict";var e,n=Object.prototype,r=n.hasOwnProperty,c="function"===typeof Symbol?Symbol:{},o=c.iterator||"@@iterator",a=c.asyncIterator||"@@asyncIterator",i=c.toStringTag||"@@toStringTag";function s(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{s({},"")}catch(F){s=function(t,e,n){return t[e]=n}}function l(t,e,n,r){var c=e&&e.prototype instanceof p?e:p,o=Object.create(c.prototype),a=new D(r||[]);return o._invoke=E(t,n,a),o}function f(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(F){return{type:"throw",arg:F}}}t.wrap=l;var u="suspendedStart",d="suspendedYield",b="executing",h="completed",g={};function p(){}function j(){}function m(){}var v={};v[o]=function(){return this};var O=Object.getPrototypeOf,x=O&&O(O(P([])));x&&x!==n&&r.call(x,o)&&(v=x);var y=m.prototype=p.prototype=Object.create(v);function w(t){["next","throw","return"].forEach((function(e){s(t,e,(function(t){return this._invoke(e,t)}))}))}function k(t,e){function n(c,o,a,i){var s=f(t[c],t,o);if("throw"!==s.type){var l=s.arg,u=l.value;return u&&"object"===typeof u&&r.call(u,"__await")?e.resolve(u.__await).then((function(t){n("next",t,a,i)}),(function(t){n("throw",t,a,i)})):e.resolve(u).then((function(t){l.value=t,a(l)}),(function(t){return n("throw",t,a,i)}))}i(s.arg)}var c;function o(t,r){function o(){return new e((function(e,c){n(t,r,e,c)}))}return c=c?c.then(o,o):o()}this._invoke=o}function E(t,e,n){var r=u;return function(c,o){if(r===b)throw new Error("Generator is already running");if(r===h){if("throw"===c)throw o;return R()}n.method=c,n.arg=o;while(1){var a=n.delegate;if(a){var i=L(a,n);if(i){if(i===g)continue;return i}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(r===u)throw r=h,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r=b;var s=f(t,e,n);if("normal"===s.type){if(r=n.done?h:d,s.arg===g)continue;return{value:s.arg,done:n.done}}"throw"===s.type&&(r=h,n.method="throw",n.arg=s.arg)}}}function L(t,n){var r=t.iterator[n.method];if(r===e){if(n.delegate=null,"throw"===n.method){if(t.iterator["return"]&&(n.method="return",n.arg=e,L(t,n),"throw"===n.method))return g;n.method="throw",n.arg=new TypeError("The iterator does not provide a 'throw' method")}return g}var c=f(r,t.iterator,n.arg);if("throw"===c.type)return n.method="throw",n.arg=c.arg,n.delegate=null,g;var o=c.arg;return o?o.done?(n[t.resultName]=o.value,n.next=t.nextLoc,"return"!==n.method&&(n.method="next",n.arg=e),n.delegate=null,g):o:(n.method="throw",n.arg=new TypeError("iterator result is not an object"),n.delegate=null,g)}function S(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function _(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function D(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(S,this),this.reset(!0)}function P(t){if(t){var n=t[o];if(n)return n.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var c=-1,a=function n(){while(++c<t.length)if(r.call(t,c))return n.value=t[c],n.done=!1,n;return n.value=e,n.done=!0,n};return a.next=a}}return{next:R}}function R(){return{value:e,done:!0}}return j.prototype=y.constructor=m,m.constructor=j,j.displayName=s(m,i,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===j||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,s(t,i,"GeneratorFunction")),t.prototype=Object.create(y),t},t.awrap=function(t){return{__await:t}},w(k.prototype),k.prototype[a]=function(){return this},t.AsyncIterator=k,t.async=function(e,n,r,c,o){void 0===o&&(o=Promise);var a=new k(l(e,n,r,c),o);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},w(y),s(y,i,"Generator"),y[o]=function(){return this},y.toString=function(){return"[object Generator]"},t.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){while(e.length){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},t.values=P,D.prototype={constructor:D,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(_),!t)for(var n in this)"t"===n.charAt(0)&&r.call(this,n)&&!isNaN(+n.slice(1))&&(this[n]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var n=this;function c(r,c){return i.type="throw",i.arg=t,n.next=r,c&&(n.method="next",n.arg=e),!!c}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],i=a.completion;if("root"===a.tryLoc)return c("end");if(a.tryLoc<=this.prev){var s=r.call(a,"catchLoc"),l=r.call(a,"finallyLoc");if(s&&l){if(this.prev<a.catchLoc)return c(a.catchLoc,!0);if(this.prev<a.finallyLoc)return c(a.finallyLoc)}else if(s){if(this.prev<a.catchLoc)return c(a.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return c(a.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var c=this.tryEntries[n];if(c.tryLoc<=this.prev&&r.call(c,"finallyLoc")&&this.prev<c.finallyLoc){var o=c;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,g):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),g},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),_(n),g}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var c=r.arg;_(n)}return c}}throw new Error("illegal catch attempt")},delegateYield:function(t,n,r){return this.delegate={iterator:P(t),resultName:n,nextLoc:r},"next"===this.method&&(this.arg=e),g}},t}(t.exports);try{regeneratorRuntime=r}catch(c){Function("r","regeneratorRuntime = r")(r)}},"99af":function(t,e,n){"use strict";var r=n("23e7"),c=n("d039"),o=n("e8b5"),a=n("861d"),i=n("7b0b"),s=n("50c4"),l=n("8418"),f=n("65f0"),u=n("1dde"),d=n("b622"),b=n("2d00"),h=d("isConcatSpreadable"),g=9007199254740991,p="Maximum allowed index exceeded",j=b>=51||!c((function(){var t=[];return t[h]=!1,t.concat()[0]!==t})),m=u("concat"),v=function(t){if(!a(t))return!1;var e=t[h];return void 0!==e?!!e:o(t)},O=!j||!m;r({target:"Array",proto:!0,forced:O},{concat:function(t){var e,n,r,c,o,a=i(this),u=f(a,0),d=0;for(e=-1,r=arguments.length;e<r;e++)if(o=-1===e?a:arguments[e],v(o)){if(c=s(o.length),d+c>g)throw TypeError(p);for(n=0;n<c;n++,d++)n in o&&l(u,d,o[n])}else{if(d>=g)throw TypeError(p);l(u,d++,o)}return u.length=d,u}})},bd34:function(t,e,n){"use strict";n.r(e);var r=n("7a23"),c=n("1255"),o=n.n(c),a=n("c4cc"),i=n.n(a),s=n("7fcf"),l=n.n(s),f=n("6c42"),u=n.n(f),d=n("fda0"),b=n.n(d),h=Object(r["C"])("data-v-51b643db");Object(r["r"])("data-v-51b643db");var g={class:"w-full flex flex-col"},p={class:"w-full"},j=Object(r["f"])("h1",{class:"font-semibold text-sm"},"Resumen",-1),m=Object(r["f"])("h1",{class:"font-semibold text-lg uppercase"},"Preventivos",-1),v={class:"flex items-center justify-center mt-4"},O=Object(r["f"])("h1",null,"De:",-1),x=Object(r["f"])("h1",null,"a",-1),y={class:"text-3xl flex justify-center pt-4 pb-3 uppercase"},w=Object(r["f"])("hr",{class:"border-gray-300 mb-4"},null,-1),k={class:"grid grid-cols-3 md:grid-cols-5 gap-0 w-full md:w-2/6 mx-auto justify-items-stretch py-4 rounded"},E={class:"grid grid-cols-1 gap-0 pb-2 justify-items-center"},L=Object(r["f"])("img",{src:o.a,class:"w-6 mb-1",alt:""},null,-1),S={class:"text-2xl leading-none font-semibold"},_=Object(r["f"])("h1",{class:"text-xs leading-none"},"Creadas",-1),D={class:"grid grid-cols-1 gap-0 pb-2 justify-items-center"},P=Object(r["f"])("img",{src:i.a,class:"w-6 mb-1",alt:""},null,-1),R={class:"text-2xl leading-none font-semibold"},F=Object(r["f"])("h1",{class:"text-xs leading-none"},"En proceso",-1),I={class:"grid grid-cols-1 gap-0 pb-2 justify-items-center"},A=Object(r["f"])("img",{src:l.a,class:"w-6 mb-1",alt:""},null,-1),G={class:"text-2xl leading-none font-semibold"},N=Object(r["f"])("h1",{class:"text-xs leading-none"},"Solucionadas",-1),C=Object(r["f"])("div",{class:"md:hidden"},null,-1),T={class:"grid grid-cols-1 gap-0 justify-items-center"},H=Object(r["f"])("img",{src:u.a,class:"w-6 mb-1",alt:""},null,-1),U={class:"text-2xl leading-none font-semibold"},Y=Object(r["f"])("span",{class:"font-normal text-xs leading-none"},"H",-1),B=Object(r["f"])("h1",{class:"text-xs leading-none"},"µ En proceso",-1),M={class:"grid grid-cols-1 gap-0 justify-items-center"},X=Object(r["f"])("img",{src:b.a,class:"w-6 mb-1",alt:""},null,-1),z={class:"text-2xl leading-none font-semibold"},J=Object(r["f"])("span",{class:"font-normal text-xs leading-none"},"H",-1),V=Object(r["f"])("h1",{class:"text-xs leading-none"},"µ Solucionadas",-1),q={class:"grid grid-cols-1 md:grid-cols-5 gap-0 justify-items-center"},K={class:"w-full py-4 grid grid-cols-1 mt-4 md:mt-0 gap-0 justify-items-center"},Q=Object(r["f"])("h1",{class:"mb-2 font-semibold"},"Ranking creadas",-1),W={class:"leading-none font-semibold w-5"},Z={class:"leading-none font-semibold w-8"},$=Object(r["f"])("img",{src:o.a,class:"w-4 mb-1",alt:""},null,-1),tt={class:"leading-none font-semibold w-12"},et={class:"w-full py-4 grid grid-cols-1 mt-4 md:mt-0 gap-0 justify-items-center"},nt=Object(r["f"])("h1",{class:"mb-2 font-semibold"},"Ranking solucionadas",-1),rt={class:"leading-none font-semibold w-5"},ct={class:"leading-none font-semibold w-8"},ot=Object(r["f"])("img",{src:l.a,class:"w-4 mb-1",alt:""},null,-1),at={class:"leading-none font-semibold w-12"},it={class:"w-full py-4 grid grid-cols-1 mt-4 md:mt-0 gap-0 justify-items-center"},st=Object(r["f"])("h1",{class:"mb-2 font-semibold"},"Ranking µ tiempo solución",-1),lt={class:"leading-none font-semibold w-5"},ft={class:"leading-none font-semibold w-8"},ut=Object(r["f"])("img",{src:b.a,class:"w-4 mb-1",alt:""},null,-1),dt={class:"leading-none font-semibold w-16"},bt=Object(r["f"])("span",{class:"font-normal text-xs leading-none"},"H",-1),ht={class:"w-full grid grid-cols-1 md:grid-cols-4 gap-3 mt-4"},gt={class:"flex w-full"},pt={class:"truncate"},jt={class:"w-full h-full flex items-end justify-start flex-wrap"},mt={class:"w-1/5 flex flex-col justify-start items-center"},vt=Object(r["f"])("img",{src:o.a,class:"h-6 mb-1",alt:""},null,-1),Ot={class:"text-xs leading-none font-semibold"},xt=Object(r["f"])("h1",{class:"text-xxs leading-none"},"Creadas",-1),yt={class:"w-1/5 flex flex-col justify-start items-center"},wt=Object(r["f"])("img",{src:i.a,class:"h-6 mb-1",alt:""},null,-1),kt={class:"text-xs leading-none font-semibold"},Et=Object(r["f"])("h1",{class:"text-xxs leading-none"},"En proceso",-1),Lt={class:"w-1/5 flex flex-col justify-start items-center"},St=Object(r["f"])("img",{src:l.a,class:"h-6 mb-1",alt:""},null,-1),_t={class:"text-xs leading-none font-semibold"},Dt=Object(r["f"])("h1",{class:"text-xxs leading-none"},"Solucionadas",-1),Pt={class:"w-1/5 flex flex-col justify-start items-center"},Rt=Object(r["f"])("img",{src:u.a,class:"h-6 mb-1",alt:""},null,-1),Ft={class:"text-xs leading-none font-semibold"},It=Object(r["f"])("span",{class:"font-normal text-xs leading-none"},"H",-1),At=Object(r["f"])("h1",{class:"text-xxs leading-none"},"µ En proceso",-1),Gt={class:"w-1/5 flex flex-col justify-start items-center"},Nt=Object(r["f"])("img",{src:b.a,class:"h-6 mb-1",alt:""},null,-1),Ct={class:"text-xs leading-none font-semibold"},Tt=Object(r["f"])("span",{class:"font-normal text-xs leading-none"},"H",-1),Ht=Object(r["f"])("h1",{class:"text-xxs leading-none"},"µ Sol.",-1),Ut={class:"flex flex-col w-full"},Yt=Object(r["f"])("hr",{class:"border-gray-300 mb-4"},null,-1),Bt={class:"w-full"};Object(r["p"])();var Mt=h((function(t,e,n,c,o,a){var i=Object(r["v"])("line-chart");return Object(r["o"])(),Object(r["d"])("div",g,[Object(r["f"])("div",p,[j,m,Object(r["f"])("div",v,[O,Object(r["B"])(Object(r["f"])("input",{type:"date",class:"mx-2 bg-white p-2 rounded-md","onUpdate:modelValue":e[1]||(e[1]=function(t){return c.fechaInicio=t}),onChange:e[2]||(e[2]=function(t){c.fetchDatos(),c.ranking()})},null,544),[[r["z"],c.fechaInicio]]),x,Object(r["B"])(Object(r["f"])("input",{type:"date",class:"mx-2 bg-white p-2 rounded-md","onUpdate:modelValue":e[3]||(e[3]=function(t){return c.fechaFin=t}),onChange:e[4]||(e[4]=function(t){c.fetchDatos(),c.ranking()})},null,544),[[r["z"],c.fechaFin]])])]),(Object(r["o"])(!0),Object(r["d"])(r["a"],null,Object(r["u"])(c.arrayData,(function(t,e){return Object(r["o"])(),Object(r["d"])("div",{key:e,class:"flex flex-col w-full"},[Object(r["f"])("div",y,[Object(r["f"])("h1",null,Object(r["x"])(t.ubicacion),1)]),w,Object(r["f"])("div",k,[Object(r["f"])("div",E,[L,Object(r["f"])("h1",S,Object(r["x"])(t.creadas),1),_]),Object(r["f"])("div",D,[P,Object(r["f"])("h1",R,Object(r["x"])(t.enProceso),1),F]),Object(r["f"])("div",I,[A,Object(r["f"])("h1",G,Object(r["x"])(t.solucionadas),1),N]),C,Object(r["f"])("div",T,[H,Object(r["f"])("h1",U,[Object(r["e"])(Object(r["x"])(t.mediaEnProceso)+" ",1),Y]),B]),Object(r["f"])("div",M,[X,Object(r["f"])("h1",z,[Object(r["e"])(Object(r["x"])(t.mediaSolucionados)+" ",1),J]),V])]),Object(r["f"])("div",q,[Object(r["f"])(i,{class:"md:col-span-2",colors:["#fc8181","#f6e05e","#68d391"],download:!0,data:t.grafica},null,8,["data"]),Object(r["f"])("div",K,[Q,(Object(r["o"])(!0),Object(r["d"])(r["a"],null,Object(r["u"])(c.arrayRanking["creadosX"],(function(e,n){return Object(r["o"])(),Object(r["d"])("div",{key:n,class:["grid grid-cols-4 gap-0 justify-items-center ranking my-auto",[e.destino==t.destino?"destinoactual":""]]},[Object(r["f"])("h1",W,Object(r["x"])(n+1),1),Object(r["f"])("h1",Z,Object(r["x"])(e.destino),1),$,Object(r["f"])("h2",tt,Object(r["x"])(e.valor),1)],2)})),128))]),Object(r["f"])("div",et,[nt,(Object(r["o"])(!0),Object(r["d"])(r["a"],null,Object(r["u"])(c.arrayRanking["solucionadosX"],(function(e,n){return Object(r["o"])(),Object(r["d"])("div",{key:n,class:["grid grid-cols-4 gap-0 justify-items-center ranking my-auto",[e.destino==t.destino?"destinoactual":""]]},[Object(r["f"])("h1",rt,Object(r["x"])(n+1),1),Object(r["f"])("h1",ct,Object(r["x"])(e.destino),1),ot,Object(r["f"])("h2",at,Object(r["x"])(e.valor),1)],2)})),128))]),Object(r["f"])("div",it,[st,(Object(r["o"])(!0),Object(r["d"])(r["a"],null,Object(r["u"])(c.arrayRanking["mediaSolucionadosX"],(function(e,n){return Object(r["o"])(),Object(r["d"])("div",{key:n,class:["grid grid-cols-4 gap-0 justify-items-center ranking my-auto",[e.destino==t.destino?"destinoactual":""]]},[Object(r["f"])("h1",lt,Object(r["x"])(n+1),1),Object(r["f"])("h1",ft,Object(r["x"])(e.destino),1),ut,Object(r["f"])("h2",dt,[Object(r["e"])(Object(r["x"])(e.valor)+" ",1),bt])],2)})),128))])]),Object(r["f"])("div",ht,[(Object(r["o"])(!0),Object(r["d"])(r["a"],null,Object(r["u"])(t.secciones,(function(t,e){return Object(r["o"])(),Object(r["d"])("div",{class:"w-full bg-white shadow-sm rounded p-2 flex flex-col items-center justify-center",key:e},[Object(r["f"])("div",gt,[Object(r["f"])("div",{class:["w-10 h-10 rounded flex items-center justify-center flex-none",[t.seccion.toLowerCase()]]},[Object(r["f"])("h1",pt,Object(r["x"])(t.seccion),1)],2),Object(r["f"])("div",jt,[Object(r["f"])("div",mt,[vt,Object(r["f"])("h1",Ot,Object(r["x"])(t.creadas),1),xt]),Object(r["f"])("div",yt,[wt,Object(r["f"])("h1",kt,Object(r["x"])(t.enProceso),1),Et]),Object(r["f"])("div",Lt,[St,Object(r["f"])("h1",_t,Object(r["x"])(t.solucionadas),1),Dt]),Object(r["f"])("div",Pt,[Rt,Object(r["f"])("h1",Ft,[Object(r["e"])(Object(r["x"])(t.mediaEnProceso)+" ",1),It]),At]),Object(r["f"])("div",Gt,[Nt,Object(r["f"])("h1",Ct,[Object(r["e"])(Object(r["x"])(t.mediaSolucionados)+" ",1),Tt]),Ht])])]),Object(r["f"])("div",Ut,[Yt,Object(r["f"])("div",Bt,[Object(r["f"])(i,{height:"200px",colors:["#fc8181","#f6e05e","#68d391"],download:!0,data:t.grafica},null,8,["data"])])])])})),128))])])})),128))])}));n("d3b7");function Xt(t,e,n,r,c,o,a){try{var i=t[o](a),s=i.value}catch(l){return void n(l)}i.done?e(s):Promise.resolve(s).then(r,c)}function zt(t){return function(){var e=this,n=arguments;return new Promise((function(r,c){var o=t.apply(e,n);function a(t){Xt(o,r,c,a,i,"next",t)}function i(t){Xt(o,r,c,a,i,"throw",t)}a(void 0)}))}}n("96cf"),n("99af");var Jt={name:"Preventivos",setup:function(){var t=new Date,e=t.getMonth()+1,n=t.getDate(),c=t.getFullYear();n<10&&(n="0"+n),e<10&&(e="0"+e);var o=Object(r["t"])(c+"-"+e+"-"+n);t.setDate(t.getDate()-7);e=t.getMonth()+1,n=t.getDate(),c=t.getFullYear();n<10&&(n="0"+n),e<10&&(e="0"+e);var a=Object(r["t"])(c+"-"+e+"-"+n),i=Object(r["t"])([]),s=Object(r["t"])([]),l=Object(r["t"])([]),f=Object(r["t"])(localStorage.getItem("idDestino")),u=Object(r["t"])(localStorage.getItem("usuario")),d=function(){var t=zt(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.log(a.value,o.value),t.prev=1,t.next=4,fetch("../apis/reportes.php?action=rankingPreventivos&idDestino=".concat(f.value,"&idUsuario=").concat(u.value,"&fechaInicio=").concat(a.value,"&fechaFin=").concat(o.value));case 4:return e=t.sent,t.next=7,e.json();case 7:l.value=t.sent,t.next=13;break;case 10:t.prev=10,t.t0=t["catch"](1),console.log(t.t0);case 13:case"end":return t.stop()}}),t,null,[[1,10]])})));return function(){return t.apply(this,arguments)}}();d();var b=function(){var t=zt(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,fetch("../apis/reportes.php?action=preventivos&idDestino=".concat(f.value,"&idUsuario=").concat(u.value,"&fechaInicio=").concat(a.value,"&fechaFin=").concat(o.value));case 3:return e=t.sent,t.next=6,e.json();case 6:i.value=t.sent,t.next=12;break;case 9:t.prev=9,t.t0=t["catch"](0),console.log(t.t0);case 12:case"end":return t.stop()}}),t,null,[[0,9]])})));return function(){return t.apply(this,arguments)}}();return b(),{arrayData:i,arraySecciones:s,arrayRanking:l,fechaInicio:a,fechaFin:o,ranking:d,fetchDatos:b,idDestino:f}}};n("ecab");Jt.render=Mt,Jt.__scopeId="data-v-51b643db";e["default"]=Jt},c4cc:function(t,e,n){t.exports=n.p+"img/pen.120b5a40.svg"},e8b5:function(t,e,n){var r=n("c6b6");t.exports=Array.isArray||function(t){return"Array"==r(t)}},ecab:function(t,e,n){"use strict";n("8ca3")},fda0:function(t,e,n){t.exports=n.p+"img/musol.70c27ec4.svg"}}]);
//# sourceMappingURL=about.8daa1faa.js.map