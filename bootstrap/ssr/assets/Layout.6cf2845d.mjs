import { Link } from "@inertiajs/inertia-vue3";
import { mergeProps, useSSRContext, resolveComponent, withCtx, createVNode, openBlock, createBlock, toDisplayString, createTextVNode } from "vue";
import { ssrRenderAttrs, ssrRenderSlot, ssrRenderTeleport, ssrRenderStyle, ssrRenderComponent, ssrRenderClass, ssrInterpolate } from "vue/server-renderer";
import { _ as _export_sfc, L as Logo } from "./Logo.6c25af7b.mjs";
import { createPopper } from "@popperjs/core";
const _sfc_main$4 = {
  props: {
    name: String
  }
};
function _sfc_ssrRender$4(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  if ($props.name === "cheveron-down") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20"
    }, _attrs))}><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg>`);
  } else if ($props.name === "cheveron-right") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20"
    }, _attrs))}><polygon points="12.95 10.707 13.657 10 8 4.343 6.586 5.757 10.828 10 6.586 14.243 8 15.657 12.95 10.707"></polygon></svg>`);
  } else if ($props.name === "dashboard") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20"
    }, _attrs))}><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"></path></svg>`);
  } else if ($props.name === "office") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      width: "100",
      height: "100",
      viewBox: "0 0 100 100"
    }, _attrs))}><path fill-rule="evenodd" d="M7 0h86v100H57.108V88.418H42.892V100H7V0zm9 64h11v15H16V64zm57 0h11v15H73V64zm-19 0h11v15H54V64zm-19 0h11v15H35V64zM16 37h11v15H16V37zm57 0h11v15H73V37zm-19 0h11v15H54V37zm-19 0h11v15H35V37zM16 11h11v15H16V11zm57 0h11v15H73V11zm-19 0h11v15H54V11zm-19 0h11v15H35V11z"></path></svg>`);
  } else if ($props.name === "printer") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20"
    }, _attrs))}><path d="M4 16H0V6h20v10h-4v4H4v-4zm2-4v6h8v-6H6zM4 0h12v5H4V0zM2 8v2h2V8H2zm4 0v2h2V8H6z"></path></svg>`);
  } else if ($props.name === "trash") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20"
    }, _attrs))}><path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"></path></svg>`);
  } else if ($props.name === "users") {
    _push(`<svg${ssrRenderAttrs(mergeProps({
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20"
    }, _attrs))}><path d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z"></path></svg>`);
  } else {
    _push(`<!---->`);
  }
}
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/Icon.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const Icon = /* @__PURE__ */ _export_sfc(_sfc_main$4, [["ssrRender", _sfc_ssrRender$4]]);
const _sfc_main$3 = {
  props: {
    placement: {
      type: String,
      default: "bottom-end"
    },
    autoClose: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      show: false
    };
  },
  watch: {
    show(show) {
      if (show) {
        this.$nextTick(() => {
          this.popper = createPopper(this.$el, this.$refs.dropdown, {
            placement: this.placement,
            modifiers: [
              {
                name: "preventOverflow",
                options: {
                  altBoundary: true
                }
              }
            ]
          });
        });
      } else if (this.popper) {
        setTimeout(() => this.popper.destroy(), 100);
      }
    }
  },
  mounted() {
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        this.show = false;
      }
    });
  }
};
function _sfc_ssrRender$3(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<button${ssrRenderAttrs(mergeProps({ type: "button" }, _attrs))}>`);
  ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
  if ($data.show) {
    ssrRenderTeleport(_push, (_push2) => {
      _push2(`<div><div style="${ssrRenderStyle({ "position": "fixed", "top": "0", "right": "0", "left": "0", "bottom": "0", "z-index": "99998", "background": "black", "opacity": "0.2" })}"></div><div style="${ssrRenderStyle({ "position": "absolute", "z-index": "99999" })}">`);
      ssrRenderSlot(_ctx.$slots, "dropdown", {}, null, _push2, _parent);
      _push2(`</div></div>`);
    }, "#dropdown", false, _parent);
  } else {
    _push(`<!---->`);
  }
  _push(`</button>`);
}
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/Dropdown.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const Dropdown = /* @__PURE__ */ _export_sfc(_sfc_main$3, [["ssrRender", _sfc_ssrRender$3]]);
const _sfc_main$2 = {
  components: {
    Icon,
    Link
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1);
      if (urls[0] === "") {
        return currentUrl === "";
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length;
    }
  }
};
function _sfc_ssrRender$2(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  const _component_Link = resolveComponent("Link");
  const _component_icon = resolveComponent("icon");
  _push(`<div${ssrRenderAttrs(_attrs)}><div class="mb-4">`);
  _push(ssrRenderComponent(_component_Link, {
    class: "group flex items-center py-3",
    href: "/"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(ssrRenderComponent(_component_icon, {
          name: "dashboard",
          class: ["mr-2 w-4 h-4", $options.isUrl("") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
        }, null, _parent2, _scopeId));
        _push2(`<div class="${ssrRenderClass($options.isUrl("") ? "text-white" : "text-indigo-300 group-hover:text-white")}"${_scopeId}>Dashboard</div>`);
      } else {
        return [
          createVNode(_component_icon, {
            name: "dashboard",
            class: ["mr-2 w-4 h-4", $options.isUrl("") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
          }, null, 8, ["class"]),
          createVNode("div", {
            class: $options.isUrl("") ? "text-white" : "text-indigo-300 group-hover:text-white"
          }, "Dashboard", 2)
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div><div class="mb-4">`);
  _push(ssrRenderComponent(_component_Link, {
    class: "group flex items-center py-3",
    href: "/organizations"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(ssrRenderComponent(_component_icon, {
          name: "office",
          class: ["mr-2 w-4 h-4", $options.isUrl("organizations") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
        }, null, _parent2, _scopeId));
        _push2(`<div class="${ssrRenderClass($options.isUrl("organizations") ? "text-white" : "text-indigo-300 group-hover:text-white")}"${_scopeId}>Organizations</div>`);
      } else {
        return [
          createVNode(_component_icon, {
            name: "office",
            class: ["mr-2 w-4 h-4", $options.isUrl("organizations") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
          }, null, 8, ["class"]),
          createVNode("div", {
            class: $options.isUrl("organizations") ? "text-white" : "text-indigo-300 group-hover:text-white"
          }, "Organizations", 2)
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div><div class="mb-4">`);
  _push(ssrRenderComponent(_component_Link, {
    class: "group flex items-center py-3",
    href: "/contacts"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(ssrRenderComponent(_component_icon, {
          name: "users",
          class: ["mr-2 w-4 h-4", $options.isUrl("contacts") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
        }, null, _parent2, _scopeId));
        _push2(`<div class="${ssrRenderClass($options.isUrl("contacts") ? "text-white" : "text-indigo-300 group-hover:text-white")}"${_scopeId}>Contacts</div>`);
      } else {
        return [
          createVNode(_component_icon, {
            name: "users",
            class: ["mr-2 w-4 h-4", $options.isUrl("contacts") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
          }, null, 8, ["class"]),
          createVNode("div", {
            class: $options.isUrl("contacts") ? "text-white" : "text-indigo-300 group-hover:text-white"
          }, "Contacts", 2)
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div><div class="mb-4">`);
  _push(ssrRenderComponent(_component_Link, {
    class: "group flex items-center py-3",
    href: "/reports"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(ssrRenderComponent(_component_icon, {
          name: "printer",
          class: ["mr-2 w-4 h-4", $options.isUrl("reports") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
        }, null, _parent2, _scopeId));
        _push2(`<div class="${ssrRenderClass($options.isUrl("reports") ? "text-white" : "text-indigo-300 group-hover:text-white")}"${_scopeId}>Reports</div>`);
      } else {
        return [
          createVNode(_component_icon, {
            name: "printer",
            class: ["mr-2 w-4 h-4", $options.isUrl("reports") ? "fill-white" : "fill-indigo-400 group-hover:fill-white"]
          }, null, 8, ["class"]),
          createVNode("div", {
            class: $options.isUrl("reports") ? "text-white" : "text-indigo-300 group-hover:text-white"
          }, "Reports", 2)
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div></div>`);
}
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/MainMenu.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const MainMenu = /* @__PURE__ */ _export_sfc(_sfc_main$2, [["ssrRender", _sfc_ssrRender$2]]);
const _sfc_main$1 = {
  data() {
    return {
      show: true
    };
  },
  watch: {
    "$page.props.flash": {
      handler() {
        this.show = true;
      },
      deep: true
    }
  }
};
function _sfc_ssrRender$1(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<div${ssrRenderAttrs(_attrs)}>`);
  if (_ctx.$page.props.flash.success && $data.show) {
    _push(`<div class="flex items-center justify-between mb-8 max-w-3xl bg-green-500 rounded"><div class="flex items-center"><svg class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><polygon points="0 11 2 9 7 14 18 3 20 5 7 18"></polygon></svg><div class="py-4 text-white text-sm font-medium">${ssrInterpolate(_ctx.$page.props.flash.success)}</div></div><button type="button" class="group mr-2 p-2"><svg class="block w-2 h-2 fill-green-800 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908"><path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"></path></svg></button></div>`);
  } else {
    _push(`<!---->`);
  }
  if ((_ctx.$page.props.flash.error || Object.keys(_ctx.$page.props.errors).length > 0) && $data.show) {
    _push(`<div class="flex items-center justify-between mb-8 max-w-3xl bg-red-500 rounded"><div class="flex items-center"><svg class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"></path></svg>`);
    if (_ctx.$page.props.flash.error) {
      _push(`<div class="py-4 text-white text-sm font-medium">${ssrInterpolate(_ctx.$page.props.flash.error)}</div>`);
    } else {
      _push(`<div class="py-4 text-white text-sm font-medium">`);
      if (Object.keys(_ctx.$page.props.errors).length === 1) {
        _push(`<span>There is one form error.</span>`);
      } else {
        _push(`<span>There are ${ssrInterpolate(Object.keys(_ctx.$page.props.errors).length)} form errors.</span>`);
      }
      _push(`</div>`);
    }
    _push(`</div><button type="button" class="group mr-2 p-2"><svg class="block w-2 h-2 fill-red-800 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908"><path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"></path></svg></button></div>`);
  } else {
    _push(`<!---->`);
  }
  _push(`</div>`);
}
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/FlashMessages.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const FlashMessages = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["ssrRender", _sfc_ssrRender$1]]);
const _sfc_main = {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
    Link,
    Logo,
    MainMenu
  },
  props: {
    auth: Object
  }
};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  const _component_Link = resolveComponent("Link");
  const _component_logo = resolveComponent("logo");
  const _component_dropdown = resolveComponent("dropdown");
  const _component_main_menu = resolveComponent("main-menu");
  const _component_icon = resolveComponent("icon");
  const _component_flash_messages = resolveComponent("flash-messages");
  _push(`<div${ssrRenderAttrs(_attrs)}><div id="dropdown"></div><div class="md:flex md:flex-col"><div class="md:flex md:flex-col md:h-screen"><div class="md:flex md:flex-shrink-0"><div class="flex items-center justify-between px-6 py-4 bg-indigo-900 md:flex-shrink-0 md:justify-center md:w-56">`);
  _push(ssrRenderComponent(_component_Link, {
    class: "mt-1",
    href: "/"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(ssrRenderComponent(_component_logo, {
          class: "fill-white",
          width: "120",
          height: "28"
        }, null, _parent2, _scopeId));
      } else {
        return [
          createVNode(_component_logo, {
            class: "fill-white",
            width: "120",
            height: "28"
          })
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(ssrRenderComponent(_component_dropdown, {
    class: "md:hidden",
    placement: "bottom-end"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"${_scopeId}><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"${_scopeId}></path></svg>`);
      } else {
        return [
          (openBlock(), createBlock("svg", {
            class: "w-6 h-6 fill-white",
            xmlns: "http://www.w3.org/2000/svg",
            viewBox: "0 0 20 20"
          }, [
            createVNode("path", { d: "M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" })
          ]))
        ];
      }
    }),
    dropdown: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<div class="mt-2 px-8 py-4 bg-indigo-800 rounded shadow-lg"${_scopeId}>`);
        _push2(ssrRenderComponent(_component_main_menu, null, null, _parent2, _scopeId));
        _push2(`</div>`);
      } else {
        return [
          createVNode("div", { class: "mt-2 px-8 py-4 bg-indigo-800 rounded shadow-lg" }, [
            createVNode(_component_main_menu)
          ])
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div><div class="md:text-md flex items-center justify-between p-4 w-full text-sm bg-white border-b md:px-12 md:py-0"><div class="mr-4 mt-1">${ssrInterpolate($props.auth.user.account.name)}</div>`);
  _push(ssrRenderComponent(_component_dropdown, {
    class: "mt-1",
    placement: "bottom-end"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<div class="group flex items-center cursor-pointer select-none"${_scopeId}><div class="mr-1 text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 whitespace-nowrap"${_scopeId}><span${_scopeId}>${ssrInterpolate($props.auth.user.first_name)}</span><span class="hidden md:inline"${_scopeId}>\xA0${ssrInterpolate($props.auth.user.last_name)}</span></div>`);
        _push2(ssrRenderComponent(_component_icon, {
          class: "w-5 h-5 fill-gray-700 group-hover:fill-indigo-600 focus:fill-indigo-600",
          name: "cheveron-down"
        }, null, _parent2, _scopeId));
        _push2(`</div>`);
      } else {
        return [
          createVNode("div", { class: "group flex items-center cursor-pointer select-none" }, [
            createVNode("div", { class: "mr-1 text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 whitespace-nowrap" }, [
              createVNode("span", null, toDisplayString($props.auth.user.first_name), 1),
              createVNode("span", { class: "hidden md:inline" }, "\xA0" + toDisplayString($props.auth.user.last_name), 1)
            ]),
            createVNode(_component_icon, {
              class: "w-5 h-5 fill-gray-700 group-hover:fill-indigo-600 focus:fill-indigo-600",
              name: "cheveron-down"
            })
          ])
        ];
      }
    }),
    dropdown: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<div class="mt-2 py-2 text-sm bg-white rounded shadow-xl"${_scopeId}>`);
        _push2(ssrRenderComponent(_component_Link, {
          class: "block px-6 py-2 hover:text-white hover:bg-indigo-500",
          href: `/users/${$props.auth.user.id}/edit`
        }, {
          default: withCtx((_2, _push3, _parent3, _scopeId2) => {
            if (_push3) {
              _push3(`My Profile`);
            } else {
              return [
                createTextVNode("My Profile")
              ];
            }
          }),
          _: 1
        }, _parent2, _scopeId));
        _push2(ssrRenderComponent(_component_Link, {
          class: "block px-6 py-2 hover:text-white hover:bg-indigo-500",
          href: "/users"
        }, {
          default: withCtx((_2, _push3, _parent3, _scopeId2) => {
            if (_push3) {
              _push3(`Manage Users`);
            } else {
              return [
                createTextVNode("Manage Users")
              ];
            }
          }),
          _: 1
        }, _parent2, _scopeId));
        _push2(ssrRenderComponent(_component_Link, {
          class: "block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500",
          href: "/logout",
          method: "delete",
          as: "button"
        }, {
          default: withCtx((_2, _push3, _parent3, _scopeId2) => {
            if (_push3) {
              _push3(`Logout`);
            } else {
              return [
                createTextVNode("Logout")
              ];
            }
          }),
          _: 1
        }, _parent2, _scopeId));
        _push2(`</div>`);
      } else {
        return [
          createVNode("div", { class: "mt-2 py-2 text-sm bg-white rounded shadow-xl" }, [
            createVNode(_component_Link, {
              class: "block px-6 py-2 hover:text-white hover:bg-indigo-500",
              href: `/users/${$props.auth.user.id}/edit`
            }, {
              default: withCtx(() => [
                createTextVNode("My Profile")
              ]),
              _: 1
            }, 8, ["href"]),
            createVNode(_component_Link, {
              class: "block px-6 py-2 hover:text-white hover:bg-indigo-500",
              href: "/users"
            }, {
              default: withCtx(() => [
                createTextVNode("Manage Users")
              ]),
              _: 1
            }),
            createVNode(_component_Link, {
              class: "block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500",
              href: "/logout",
              method: "delete",
              as: "button"
            }, {
              default: withCtx(() => [
                createTextVNode("Logout")
              ]),
              _: 1
            })
          ])
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div></div><div class="md:flex md:flex-grow md:overflow-hidden">`);
  _push(ssrRenderComponent(_component_main_menu, { class: "hidden flex-shrink-0 p-12 w-56 bg-indigo-800 overflow-y-auto md:block" }, null, _parent));
  _push(`<div class="px-4 py-8 md:flex-1 md:p-12 md:overflow-y-auto" scroll-region>`);
  _push(ssrRenderComponent(_component_flash_messages, null, null, _parent));
  ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
  _push(`</div></div></div></div></div>`);
}
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/Layout.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const Layout = /* @__PURE__ */ _export_sfc(_sfc_main, [["ssrRender", _sfc_ssrRender]]);
export {
  Dropdown as D,
  Icon as I,
  Layout as L
};
