import { Head } from "@inertiajs/inertia-vue3";
import { _ as _export_sfc, L as Logo } from "./Logo.6c25af7b.mjs";
import { L as LoadingButton, T as TextInput } from "./LoadingButton.f4cc33ce.mjs";
import { resolveComponent, withCtx, createTextVNode, useSSRContext } from "vue";
import { ssrRenderComponent, ssrIncludeBooleanAttr, ssrLooseContain } from "vue/server-renderer";
import "uuid";
const _sfc_main = {
  components: {
    Head,
    LoadingButton,
    Logo,
    TextInput
  },
  data() {
    return {
      form: this.$inertia.form({
        email: "johndoe@example.com",
        password: "secret",
        remember: false
      })
    };
  },
  methods: {
    login() {
      this.form.post("/login");
    }
  }
};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  const _component_Head = resolveComponent("Head");
  const _component_logo = resolveComponent("logo");
  const _component_text_input = resolveComponent("text-input");
  const _component_loading_button = resolveComponent("loading-button");
  _push(`<!--[-->`);
  _push(ssrRenderComponent(_component_Head, { title: "Login" }, null, _parent));
  _push(`<div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800"><div class="w-full max-w-md">`);
  _push(ssrRenderComponent(_component_logo, {
    class: "block mx-auto w-full max-w-xs fill-white",
    height: "50"
  }, null, _parent));
  _push(`<form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden"><div class="px-10 py-12"><h1 class="text-center text-3xl font-bold">Welcome Back!</h1><div class="mt-6 mx-auto w-24 border-b-2"></div>`);
  _push(ssrRenderComponent(_component_text_input, {
    modelValue: $data.form.email,
    "onUpdate:modelValue": ($event) => $data.form.email = $event,
    error: $data.form.errors.email,
    class: "mt-10",
    label: "Email",
    type: "email",
    autofocus: "",
    autocapitalize: "off"
  }, null, _parent));
  _push(ssrRenderComponent(_component_text_input, {
    modelValue: $data.form.password,
    "onUpdate:modelValue": ($event) => $data.form.password = $event,
    error: $data.form.errors.password,
    class: "mt-6",
    label: "Password",
    type: "password"
  }, null, _parent));
  _push(`<label class="flex items-center mt-6 select-none" for="remember"><input id="remember"${ssrIncludeBooleanAttr(Array.isArray($data.form.remember) ? ssrLooseContain($data.form.remember, null) : $data.form.remember) ? " checked" : ""} class="mr-1" type="checkbox"><span class="text-sm">Remember Me</span></label></div><div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">`);
  _push(ssrRenderComponent(_component_loading_button, {
    loading: $data.form.processing,
    class: "btn-indigo ml-auto",
    type: "submit"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`Login`);
      } else {
        return [
          createTextVNode("Login")
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div></form></div></div><!--]-->`);
}
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Auth/Login.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const Login = /* @__PURE__ */ _export_sfc(_sfc_main, [["ssrRender", _sfc_ssrRender]]);
export {
  Login as default
};
