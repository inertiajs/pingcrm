import{_ as c}from"./Logo-231b3ca1.js";import{o as a,c as i,t as f,j as d,b as p,m as y,n as v,l as _}from"./app-7e8772f8.js";var l,h=new Uint8Array(16);function b(){if(!l&&(l=typeof crypto<"u"&&crypto.getRandomValues&&crypto.getRandomValues.bind(crypto)||typeof msCrypto<"u"&&typeof msCrypto.getRandomValues=="function"&&msCrypto.getRandomValues.bind(msCrypto),!l))throw new Error("crypto.getRandomValues() not supported. See https://github.com/uuidjs/uuid#getrandomvalues-not-supported");return l(h)}const S=/^(?:[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}|00000000-0000-0000-0000-000000000000)$/i;function V(e){return typeof e=="string"&&S.test(e)}var s=[];for(var u=0;u<256;++u)s.push((u+256).toString(16).substr(1));function x(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:0,n=(s[e[t+0]]+s[e[t+1]]+s[e[t+2]]+s[e[t+3]]+"-"+s[e[t+4]]+s[e[t+5]]+"-"+s[e[t+6]]+s[e[t+7]]+"-"+s[e[t+8]]+s[e[t+9]]+"-"+s[e[t+10]]+s[e[t+11]]+s[e[t+12]]+s[e[t+13]]+s[e[t+14]]+s[e[t+15]]).toLowerCase();if(!V(n))throw TypeError("Stringified UUID is invalid");return n}function $(e,t,n){e=e||{};var o=e.random||(e.rng||b)();if(o[6]=o[6]&15|64,o[8]=o[8]&63|128,t){n=n||0;for(var r=0;r<16;++r)t[n+r]=o[r];return t}return x(o)}const R={inheritAttrs:!1,props:{id:{type:String,default(){return`text-input-${$()}`}},type:{type:String,default:"text"},error:String,label:String,modelValue:String},emits:["update:modelValue"],methods:{focus(){this.$refs.input.focus()},select(){this.$refs.input.select()},setSelectionRange(e,t){this.$refs.input.setSelectionRange(e,t)}}},C=["for"],k=["id","type","value"],w={key:1,class:"form-error"};function B(e,t,n,o,r,m){return a(),i("div",{class:v(e.$attrs.class)},[n.label?(a(),i("label",{key:0,class:"form-label",for:n.id},f(n.label)+":",9,C)):d("",!0),p("input",y({id:n.id,ref:"input"},{...e.$attrs,class:null},{class:["form-input",{error:n.error}],type:n.type,value:n.modelValue,onInput:t[0]||(t[0]=g=>e.$emit("update:modelValue",g.target.value))}),null,16,k),n.error?(a(),i("div",w,f(n.error),1)):d("",!0)],2)}const A=c(R,[["render",B]]),E={props:{loading:Boolean}},T=["disabled"],I={key:0,class:"btn-spinner mr-2"};function L(e,t,n,o,r,m){return a(),i("button",{disabled:n.loading,class:"flex items-center"},[n.loading?(a(),i("div",I)):d("",!0),_(e.$slots,"default")],8,T)}const D=c(E,[["render",L]]);export{D as L,A as T,$ as v};
