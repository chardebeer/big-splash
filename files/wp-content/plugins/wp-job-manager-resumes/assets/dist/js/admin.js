!function(e){var t={};function r(n){if(t[n])return t[n].exports;var s=t[n]={i:n,l:!1,exports:{}};return e[n].call(s.exports,s,s.exports,r),s.l=!0,s.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var s in e)r.d(n,s,function(t){return e[t]}.bind(null,s));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=2)}({2:function(e,t){jQuery(document).ready((function(e){if(e.isFunction(e.fn.select2)){var t={tags:!0};e(".settings-role-select").length>0&&e.fn.select2.amd.require(["select2/selection/search"],(function(e){e.prototype.searchRemoveChoice=function(e,t){this.trigger("unselect",{data:t}),this.$search.val(""),this.handleSearch()}}),null,!0),jQuery(".nav-tab-wrapper a").click((function(){jQuery(jQuery(this).attr("href")).find(".settings-role-select").select2(t)}))}e("input.resume_manager_add_row").click((function(){return e(this).closest("table").find("tbody").append(e(this).data("row")),!1})),e(".wc-job-manager-resumes-repeated-rows tbody").sortable({items:"tr",cursor:"move",axis:"y",handle:"td.sort-column",scrollSensitivity:40,forcePlaceholderSize:!0,helper:"clone",opacity:.65}),e("input#_resume_expires").datepicker({dateFormat:"yy-mm-dd",minDate:0}),e(".job-manager-settings-wrap").on("change","#setting-resume_manager_enable_skills",(function(){e(this).is(":checked")?e("#setting-resume_manager_max_skills").closest("tr").show():e("#setting-resume_manager_max_skills").closest("tr").hide()})).on("change","#setting-resume_manager_enable_categories",(function(){e(this).is(":checked")?e("#setting-resume_manager_enable_default_category_multiselect, #setting-resume_manager_category_filter_type").closest("tr").show():e("#setting-resume_manager_enable_default_category_multiselect, #setting-resume_manager_category_filter_type").closest("tr").hide()}));var r=jQuery("#setting-resume_manager_generate_username_from_email"),n=jQuery("#setting-resume_manager_use_standard_password_setup_email"),s=jQuery("#setting-resume_manager_registration_role");e(".job-manager-settings-wrap").on("change","#setting-resume_manager_enable_registration",(function(){e(this).is(":checked")?(r.closest("tr").show(),n.closest("tr").show(),s.closest("tr").show()):(r.closest("tr").hide(),n.closest("tr").hide(),s.closest("tr").hide())})),r.is(":checked")&&n.prop("checked",!0),r.change((function(){jQuery(this).is(":checked")?n.data("original-state",n.is(":checked")).prop("checked",!0).prop("disabled",!0):(n.prop("disabled",!1),void 0!==n.data("original-state")&&n.prop("checked",n.data("original-state")))})).change(),e("#setting-resume_manager_enable_skills, #setting-resume_manager_enable_categories, #setting-resume_manager_enable_registration").change()}))}});