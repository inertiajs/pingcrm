import { Head, Link } from "@inertiajs/inertia-vue3";
import { I as Icon, L as Layout } from "./Layout.6cf2845d.mjs";
import pickBy from "lodash/pickBy.js";
import throttle from "lodash/throttle.js";
import mapValues from "lodash/mapValues.js";
import { P as Pagination } from "./Pagination.463d71af.mjs";
import { S as SearchFilter } from "./SearchFilter.a6d1e2e6.mjs";
import { resolveComponent, withCtx, createVNode, withDirectives, vModelSelect, createTextVNode, toDisplayString, openBlock, createBlock, createCommentVNode, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderComponent, ssrRenderAttr, ssrRenderList, ssrInterpolate } from "vue/server-renderer";
import { _ as _export_sfc } from "./Logo.6c25af7b.mjs";
import "@popperjs/core";
const _sfc_main = {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter
  },
  layout: Layout,
  props: {
    filters: Object,
    organizations: Object
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed
      }
    };
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get("/organizations", pickBy(this.form), { preserveState: true });
      }, 150)
    }
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    }
  }
};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  const _component_Head = resolveComponent("Head");
  const _component_search_filter = resolveComponent("search-filter");
  const _component_Link = resolveComponent("Link");
  const _component_icon = resolveComponent("icon");
  const _component_pagination = resolveComponent("pagination");
  _push(`<div${ssrRenderAttrs(_attrs)}>`);
  _push(ssrRenderComponent(_component_Head, { title: "Organizations" }, null, _parent));
  _push(`<h1 class="mb-8 text-3xl font-bold">Organizations</h1><div class="flex items-center justify-between mb-6">`);
  _push(ssrRenderComponent(_component_search_filter, {
    modelValue: $data.form.search,
    "onUpdate:modelValue": ($event) => $data.form.search = $event,
    class: "mr-4 w-full max-w-md",
    onReset: $options.reset
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<label class="block text-gray-700"${_scopeId}>Trashed:</label><select class="form-select mt-1 w-full"${_scopeId}><option${ssrRenderAttr("value", null)}${_scopeId}></option><option value="with"${_scopeId}>With Trashed</option><option value="only"${_scopeId}>Only Trashed</option></select>`);
      } else {
        return [
          createVNode("label", { class: "block text-gray-700" }, "Trashed:"),
          withDirectives(createVNode("select", {
            "onUpdate:modelValue": ($event) => $data.form.trashed = $event,
            class: "form-select mt-1 w-full"
          }, [
            createVNode("option", { value: null }),
            createVNode("option", { value: "with" }, "With Trashed"),
            createVNode("option", { value: "only" }, "Only Trashed")
          ], 8, ["onUpdate:modelValue"]), [
            [vModelSelect, $data.form.trashed]
          ])
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(ssrRenderComponent(_component_Link, {
    class: "btn-indigo",
    href: "/organizations/create"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<span${_scopeId}>Create</span><span class="hidden md:inline"${_scopeId}>\xA0Organization</span>`);
      } else {
        return [
          createVNode("span", null, "Create"),
          createVNode("span", { class: "hidden md:inline" }, "\xA0Organization")
        ];
      }
    }),
    _: 1
  }, _parent));
  _push(`</div><div class="bg-white rounded-md shadow overflow-x-auto"><table class="w-full whitespace-nowrap"><thead><tr class="text-left font-bold"><th class="pb-4 pt-6 px-6">Name</th><th class="pb-4 pt-6 px-6">City</th><th class="pb-4 pt-6 px-6" colspan="2">Phone</th></tr></thead><tbody><!--[-->`);
  ssrRenderList($props.organizations.data, (organization) => {
    _push(`<tr class="hover:bg-gray-100 focus-within:bg-gray-100"><td class="border-t">`);
    _push(ssrRenderComponent(_component_Link, {
      class: "flex items-center px-6 py-4 focus:text-indigo-500",
      href: `/organizations/${organization.id}/edit`
    }, {
      default: withCtx((_, _push2, _parent2, _scopeId) => {
        if (_push2) {
          _push2(`${ssrInterpolate(organization.name)} `);
          if (organization.deleted_at) {
            _push2(ssrRenderComponent(_component_icon, {
              name: "trash",
              class: "flex-shrink-0 ml-2 w-3 h-3 fill-gray-400"
            }, null, _parent2, _scopeId));
          } else {
            _push2(`<!---->`);
          }
        } else {
          return [
            createTextVNode(toDisplayString(organization.name) + " ", 1),
            organization.deleted_at ? (openBlock(), createBlock(_component_icon, {
              key: 0,
              name: "trash",
              class: "flex-shrink-0 ml-2 w-3 h-3 fill-gray-400"
            })) : createCommentVNode("", true)
          ];
        }
      }),
      _: 2
    }, _parent));
    _push(`</td><td class="border-t">`);
    _push(ssrRenderComponent(_component_Link, {
      class: "flex items-center px-6 py-4",
      href: `/organizations/${organization.id}/edit`,
      tabindex: "-1"
    }, {
      default: withCtx((_, _push2, _parent2, _scopeId) => {
        if (_push2) {
          _push2(`${ssrInterpolate(organization.city)}`);
        } else {
          return [
            createTextVNode(toDisplayString(organization.city), 1)
          ];
        }
      }),
      _: 2
    }, _parent));
    _push(`</td><td class="border-t">`);
    _push(ssrRenderComponent(_component_Link, {
      class: "flex items-center px-6 py-4",
      href: `/organizations/${organization.id}/edit`,
      tabindex: "-1"
    }, {
      default: withCtx((_, _push2, _parent2, _scopeId) => {
        if (_push2) {
          _push2(`${ssrInterpolate(organization.phone)}`);
        } else {
          return [
            createTextVNode(toDisplayString(organization.phone), 1)
          ];
        }
      }),
      _: 2
    }, _parent));
    _push(`</td><td class="w-px border-t">`);
    _push(ssrRenderComponent(_component_Link, {
      class: "flex items-center px-4",
      href: `/organizations/${organization.id}/edit`,
      tabindex: "-1"
    }, {
      default: withCtx((_, _push2, _parent2, _scopeId) => {
        if (_push2) {
          _push2(ssrRenderComponent(_component_icon, {
            name: "cheveron-right",
            class: "block w-6 h-6 fill-gray-400"
          }, null, _parent2, _scopeId));
        } else {
          return [
            createVNode(_component_icon, {
              name: "cheveron-right",
              class: "block w-6 h-6 fill-gray-400"
            })
          ];
        }
      }),
      _: 2
    }, _parent));
    _push(`</td></tr>`);
  });
  _push(`<!--]-->`);
  if ($props.organizations.data.length === 0) {
    _push(`<tr><td class="px-6 py-4 border-t" colspan="4">No organizations found.</td></tr>`);
  } else {
    _push(`<!---->`);
  }
  _push(`</tbody></table></div>`);
  _push(ssrRenderComponent(_component_pagination, {
    class: "mt-6",
    links: $props.organizations.links
  }, null, _parent));
  _push(`</div>`);
}
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Organizations/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const Index = /* @__PURE__ */ _export_sfc(_sfc_main, [["ssrRender", _sfc_ssrRender]]);
export {
  Index as default
};
