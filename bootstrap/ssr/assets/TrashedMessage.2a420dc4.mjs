import { I as Icon } from "./Layout.6cf2845d.mjs";
import { resolveComponent, mergeProps, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderComponent, ssrRenderSlot } from "vue/server-renderer";
import { _ as _export_sfc } from "./Logo.6c25af7b.mjs";
const _sfc_main = {
  components: {
    Icon
  },
  emits: ["restore"]
};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  const _component_icon = resolveComponent("icon");
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex items-center justify-between p-4 max-w-3xl bg-yellow-400 rounded" }, _attrs))}><div class="flex items-center">`);
  _push(ssrRenderComponent(_component_icon, {
    name: "trash",
    class: "flex-shrink-0 mr-2 w-4 h-4 fill-yellow-800"
  }, null, _parent));
  _push(`<div class="text-yellow-800 text-sm font-medium">`);
  ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
  _push(`</div></div><button class="text-yellow-800 hover:underline text-sm" tabindex="-1" type="button">Restore</button></div>`);
}
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/TrashedMessage.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const TrashedMessage = /* @__PURE__ */ _export_sfc(_sfc_main, [["ssrRender", _sfc_ssrRender]]);
export {
  TrashedMessage as T
};
