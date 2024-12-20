/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./block-editor/src/block-variations/bubble-heading.js":
/*!*************************************************************!*\
  !*** ./block-editor/src/block-variations/bubble-heading.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   registerBubbleHeadingVariation: function() { return /* binding */ registerBubbleHeadingVariation; }
/* harmony export */ });
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_2__);



function registerBubbleHeadingVariation() {
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockVariation)('core/heading', {
    name: "bubble-heading",
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Bublinkový nadpis', 'kapital'),
    attributes: {
      className: 'bubble-heading'
    }
  });
}

/***/ }),

/***/ "./block-editor/src/block-variations/button.js":
/*!*****************************************************!*\
  !*** ./block-editor/src/block-variations/button.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   registerKapitalButtonVariation: function() { return /* binding */ registerKapitalButtonVariation; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/esm/typeof.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/hooks */ "@wordpress/hooks");
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__);


function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }








function registerKapitalButtonVariation() {
  function addCustomAttributes(settings, name) {
    if (settings.name !== 'core/button') {
      return settings;
    }
    //add custom attributes
    if ((0,_babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1__["default"])(settings.attributes) != undefined) {}
    if (settings.attributes) {
      settings.attributes.icon = {
        type: 'string',
        default: 'none'
      };
      settings.attributes.iconAlign = {
        type: 'string',
        default: "icon-right"
      };
    }
    return settings;
  }
  (0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_8__.addFilter)('blocks.registerBlockType', 'core/button', addCustomAttributes);
  var withInspectorControls = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_4__.createHigherOrderComponent)(function (BlockEdit) {
    return function (props) {
      var attributes = props.attributes,
        setAttributes = props.setAttributes,
        name = props.name;
      if (name !== 'core/button') {
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(BlockEdit, _objectSpread({}, props));
      }
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.Fragment, {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(BlockEdit, _objectSpread({}, props)), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.InspectorControls, {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.PanelBody, {
            title: "Ikona",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.SelectControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Ikona', 'kapital'),
              value: attributes.icon,
              onChange: function onChange(newValue) {
                setAttributes({
                  icon: newValue
                });
              },
              options: [{
                label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Žiadna", "kapital"),
                value: "none"
              }, {
                label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("→", "kapital"),
                value: "icon-arrow-right"
              }, {
                label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("↓", "kapital"),
                value: "icon-arrow-down"
              }, {
                label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("↗", "kapital"),
                value: "icon-arrow-up-right"
              }]
            }), attributes.icon !== "none" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.SelectControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Ikona', 'kapital'),
              value: attributes.iconAlign,
              onChange: function onChange(newValue) {
                setAttributes({
                  iconAlign: newValue
                });
              },
              options: [{
                label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Vpravo", "kapital"),
                value: "icon-right"
              }, {
                label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Vľavo", "kapital"),
                value: "icon-left"
              }]
            })]
          })
        })]
      });
    };
  }, 'withInspectorControl');

  /**
   * Add custom element class in save element.
   *
   * @param {Object} extraProps     Block element.
   * @param {Object} blockType      Blocks object.
   * @param {Object} attributes     Blocks attributes.
   *
   * @return {Object} extraProps Modified block element.
   */

  (0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_8__.addFilter)('editor.BlockEdit', 'core/button', withInspectorControls);

  /**
   * Add icon class to the block in the editor
   */
  var addIconClass = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_4__.createHigherOrderComponent)(function (BlockListBlock) {
    return function (props) {
      var _props$attributes = props.attributes,
        icon = _props$attributes.icon,
        iconAlign = _props$attributes.iconAlign,
        className = props.className,
        name = props.name;
      if (name !== 'core/button') {
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(BlockListBlock, _objectSpread({}, props));
      }
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(BlockListBlock, _objectSpread(_objectSpread({}, props), {}, {
        className: classnames__WEBPACK_IMPORTED_MODULE_3___default()(className, icon !== "none" ? "".concat(icon, " ").concat(iconAlign) : '')
      }));
    };
  }, 'withClientIdClassName');
  (0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_8__.addFilter)('editor.BlockListBlock', 'kapital/button-block/add-editor-class', addIconClass);
}

/***/ }),

/***/ "./block-editor/src/custom-editor-scripts/authorTermSelector.js":
/*!**********************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/authorTermSelector.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   AuthorTermSelector: function() { return /* binding */ AuthorTermSelector; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _utils_terms__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./utils/terms */ "./block-editor/src/custom-editor-scripts/utils/terms.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__);


/**
 * WordPress dependencies
 */





/**
 * Internal dependencies
 */



/**
 * Shared reference to an empty array for cases where it is important to avoid
 * returning a new array reference on every invocation.
 *
 * @type {Array<any>}
 */

var EMPTY_ARRAY = [];

/**
 * How the max suggestions limit was chosen:
 *  - Matches the `per_page` range set by the REST API.
 *  - Can't use "unbound" query. The `FormTokenField` needs a fixed number.
 *  - Matches default for `FormTokenField`.
 */
var MAX_TERMS = -1;
var DEFAULT_QUERY = {
  per_page: MAX_TERMS,
  _fields: 'id,name',
  orderby: 'name',
  order: 'asc',
  context: 'view'
};

/**
 * Renders a flat term selector component.
 *
 * @param {Object}  props                         The component props.
 * @param {string}  props.slug                    The slug of the taxonomy.
 * @param {boolean} props.__nextHasNoMarginBottom Start opting into the new margin-free styles that will become the default in a future version, currently scheduled to be WordPress 7.0. (The prop can be safely removed once this happens.)
 *
 */
function AuthorTermSelector(_ref) {
  var slug = _ref.slug,
    __nextHasNoMarginBottom = _ref.__nextHasNoMarginBottom;
  var _useDispatch = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useDispatch)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_6__.store),
    editPost = _useDispatch.editPost;
  var _useSelect = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(function (select) {
      var _post$_links, _post$_links2, _post$_links3, _post$_links4;
      var _select = select(_wordpress_editor__WEBPACK_IMPORTED_MODULE_6__.store),
        getCurrentPost = _select.getCurrentPost,
        getEditedPostAttribute = _select.getEditedPostAttribute;
      var _select2 = select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_5__.store),
        getTaxonomy = _select2.getTaxonomy,
        getEntityRecords = _select2.getEntityRecords,
        isResolving = _select2.isResolving;
      var _taxonomy = getTaxonomy(slug);
      var post = getCurrentPost();
      return {
        hasCreateAction: _taxonomy ? (_post$_links = (_post$_links2 = post._links) === null || _post$_links2 === void 0 ? void 0 : _post$_links2['wp:action-create-' + _taxonomy.rest_base]) !== null && _post$_links !== void 0 ? _post$_links : false : false,
        hasAssignAction: _taxonomy ? (_post$_links3 = (_post$_links4 = post._links) === null || _post$_links4 === void 0 ? void 0 : _post$_links4['wp:action-assign-' + _taxonomy.rest_base]) !== null && _post$_links3 !== void 0 ? _post$_links3 : false : false,
        termIds: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : EMPTY_ARRAY,
        loading: isResolving('getEntityRecords', ['taxonomy', slug, DEFAULT_QUERY]),
        availableTerms: getEntityRecords('taxonomy', slug, DEFAULT_QUERY) || EMPTY_ARRAY,
        taxonomy: _taxonomy
      };
    }, [slug]),
    termIds = _useSelect.termIds,
    availableTerms = _useSelect.availableTerms,
    taxonomy = _useSelect.taxonomy;

  //selected terms with
  var terms = availableTerms.filter(function (item) {
    return termIds.includes(item.id);
  });

  /**
   * Update terms for post.
   *
   * @param {number[]} termIds Term ids.
   */
  var onUpdateTerms = function onUpdateTerms(termIds) {
    editPost((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__["default"])({}, taxonomy.rest_base, termIds));
  };
  var authorSearchPlaceholder = 'Vyberte autorstvo.';

  /**
  * Handler for checking term.
  *
  * @param {array} termId
  */
  var _onChange = function onChange(termId) {
    var hasTerm = termIds.includes(termId);
    if (!hasTerm) {
      var newTerms = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(termIds), [termId]);
      onUpdateTerms(newTerms);
      if (newTerms.length > 0) {
        authorSearchPlaceholder = 'Vyberte ďalšie autorstvo';
      } else {
        authorSearchPlaceholder = 'Vyberte autorstvo';
      }
    }
  };
  var removeTerm = function removeTerm(termId) {
    termId = Number(termId);
    var hasTerm = termIds.includes(termId);
    if (hasTerm) {
      var newTerms = termIds.filter(function (id) {
        return id !== termId;
      });
      onUpdateTerms(newTerms);
      if (newTerms.length > 0) {
        authorSearchPlaceholder = 'Vyberte ďalšie autorstvo';
      } else {
        authorSearchPlaceholder = 'Vyberte autorstvo';
      }
    }
  };
  var options = [];
  if (availableTerms) {
    options = availableTerms.map(function (availableTerm) {
      return {
        label: availableTerm.name || '',
        value: availableTerm.id
      };
    });
  }

  // display select dropdown
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.Fragment, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.ComboboxControl, {
      options: options || [],
      onChange: function onChange(termId) {
        return _onChange(termId);
      },
      placeholder: authorSearchPlaceholder,
      value: ""
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Flex, {
      direction: "column",
      align: "start",
      gap: "2",
      style: {
        marginTop: '16px'
      },
      children: terms.length > 0 && terms.map(function (term) {
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.FlexItem, {
          style: {
            padding: '2px 2px 2px 8px',
            background: 'rgb(233, 233, 233)',
            borderRadius: '3px'
          },
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)("span", {
            style: {
              lineHeight: '24px',
              verticalAlign: 'bottom'
            },
            children: term.name
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
            value: term.id,
            size: 'small',
            icon: 'no-alt',
            iconSize: 16,
            onClick: function onClick(event) {
              return removeTerm(event.target.closest('button').value);
            }
          })]
        });
      })
    })]
  });
}
/* harmony default export */ __webpack_exports__["default"] = (AuthorTermSelector);

/***/ }),

/***/ "./block-editor/src/custom-editor-scripts/customMetaSettings.js":
/*!**********************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/customMetaSettings.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   customMetaSettings: function() { return /* binding */ customMetaSettings; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/esm/typeof.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/plugins */ "@wordpress/plugins");
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__);



function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }









function customMetaSettings() {
  (0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_3__.registerPlugin)('kapital-post-render-panel', {
    render: function render() {
      var postType = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.useSelect)(function (select) {
        return select('core/editor').getCurrentPostType();
      }, []);
      if (postTypesWithControlledRendering.includes(postType)) {
        var _useEntityProp = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_8__.useEntityProp)('postType', postType, 'meta'),
          _useEntityProp2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_2__["default"])(_useEntityProp, 2),
          meta = _useEntityProp2[0],
          setMeta = _useEntityProp2[1];
        var custom_render_meta = meta['_kapital_post_render_settings'];
        if ((0,_babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1__["default"])(meta['_kapital_post_render_settings']) === 'object' && !Array.isArray(meta['_kapital_post_render_settings']) && meta['_kapital_post_render_settings'] !== null) {
          custom_render_meta = meta['_kapital_post_render_settings'];
        } else {
          custom_render_meta = {
            show_featured_image: true,
            show_breadcrumbs: true,
            show_title: true,
            show_author: true,
            show_categories: true,
            show_views: true,
            show_date: true,
            show_ads: true,
            show_support: true,
            show_footer: true,
            show_filters: false
          };
          //hide featured image in podcast by default
          if (postType === 'podcast') {
            custom_render_meta.show_featured_image = false;
            custom_render_meta.show_author = false;
          }
          if (postType === 'page') {
            custom_render_meta.show_featured_image = false;
            custom_render_meta.show_author = false;
            custom_render_meta.show_views = false;
            custom_render_meta.show_date = false;
            custom_render_meta.show_categories = false;
          }
        }
        var updateMetaValue = function updateMetaValue(value, prop) {
          custom_render_meta = _objectSpread({
            show_featured_image: true,
            show_breadcrumbs: true,
            show_title: true,
            show_author: true,
            show_categories: true,
            show_views: true,
            show_date: true,
            show_ads: true,
            show_support: true,
            show_footer: true
          }, custom_render_meta);
          custom_render_meta["".concat(prop)] = value;
          setMeta(_objectSpread(_objectSpread({}, meta), {}, {
            _kapital_post_render_settings: custom_render_meta
          }));
        };
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_4__.PluginDocumentSettingPanel, {
          name: "kapital-post-render-panel",
          title: "Nastavenie zobrazovania",
          className: "some-css-class",
          icon: "visibility",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Flex, {
            direction: "column",
            gap: 4,
            children: [postType === 'page' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať filtre', 'kapital'),
              checked: custom_render_meta.show_filters,
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Pri stránkach sa ako filtre zobrazia dcérske stránky.', 'kapital'),
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_filters, 'show_filters');
              }
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať ilustračný obrázok', 'kapital'),
              checked: custom_render_meta.show_featured_image,
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('V archívoch článkov je ilustračný obrázok vždy viditeľný.', 'kapital'),
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_featured_image, 'show_featured_image');
              }
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať breadcrumb navigáciu', 'kapital'),
              checked: custom_render_meta.show_breadcrumbs,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_breadcrumbs, 'show_breadcrumbs');
              }
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať názov', 'kapital'),
              checked: custom_render_meta.show_title,
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('V archívoch článkov je názov vždy viditeľný.'),
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_title, 'show_title');
              }
            }), postType !== 'page' && postType !== 'podcast' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať autorstvo', 'kapital'),
              checked: custom_render_meta.show_author,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_author, 'show_author');
              }
            }), postType !== 'page' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať kategórie článku', 'kapital'),
              checked: custom_render_meta.show_categories,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_categories, 'show_categories');
              },
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazenie čísla, série, rubriky, atď. nad názvom článku', 'kapital')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať počet zhliadnutí', 'kapital'),
              checked: custom_render_meta.show_views,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_views, 'show_views');
              }
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Zobrazovať dátum publikovania', 'kapital'),
              checked: custom_render_meta.show_date,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_date, 'show_date');
              }
            }), postType !== 'page' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Automaticky vložiť inzerciu', 'kapital'),
              checked: custom_render_meta.show_ads,
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Netýka sa manuálne vložených blokov reklamy.', 'kapital'),
              s: true,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_ads, 'show_ads');
              }
            }), postType !== 'page' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Automaticky vložiť podporu', 'kapital'),
              checked: custom_render_meta.show_support,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_support, 'show_support');
              },
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Netýka sa manuálne vložených blokov podpory.', 'kapital')
            }), postType !== 'page' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
              __nextHasNoMarginBottom: true,
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_7__.__)('Automaticky vložiť odporúčania ďalších článkov', 'kapital'),
              checked: custom_render_meta.show_footer,
              onChange: function onChange() {
                return updateMetaValue(!custom_render_meta.show_footer, 'show_footer');
              }
            })]
          })
        });
      } else {
        return;
      }
    }
  });
}
;

/***/ }),

/***/ "./block-editor/src/custom-editor-scripts/customTermSelector.js":
/*!**********************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/customTermSelector.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CustomTermSelector: function() { return /* binding */ CustomTermSelector; },
/* harmony export */   findTerm: function() { return /* binding */ findTerm; },
/* harmony export */   getFilterMatcher: function() { return /* binding */ getFilterMatcher; },
/* harmony export */   sortBySelected: function() { return /* binding */ sortBySelected; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/asyncToGenerator */ "./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/regenerator */ "@babel/runtime/regenerator");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/notices */ "@wordpress/notices");
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_notices__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _wordpress_a11y__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @wordpress/a11y */ "@wordpress/a11y");
/* harmony import */ var _wordpress_a11y__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_wordpress_a11y__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _utils_terms__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./utils/terms */ "./block-editor/src/custom-editor-scripts/utils/terms.js");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__);





function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__["default"])(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
/** Custom term selector - besed on hierarchicalTermSelector, as it had bug, which should be fixed now */

/**
 * WordPress dependencies
 */










/**
 * Internal dependencies
 */



/**
 * Module Constants
 */

var DEFAULT_QUERY = {
  per_page: -1,
  orderby: 'name',
  order: 'asc',
  _fields: 'id,name,parent',
  context: 'view'
};
var MIN_TERMS_COUNT_FOR_FILTER = 8;
var EMPTY_ARRAY = [];

/**
 * Sort Terms by Selected.
 *
 * @param {Object[]} termsTree Array of terms in tree format.
 * @param {number[]} terms     Selected terms.
 *
 * @return {Object[]} Sorted array of terms.
 */
function sortBySelected(termsTree, terms) {
  var _treeHasSelection = function treeHasSelection(termTree) {
    if (terms.indexOf(termTree.id) !== -1) {
      return true;
    }
    if (undefined === termTree.children) {
      return false;
    }
    return termTree.children.map(_treeHasSelection).filter(function (child) {
      return child;
    }).length > 0;
  };
  var termOrChildIsSelected = function termOrChildIsSelected(termA, termB) {
    var termASelected = _treeHasSelection(termA);
    var termBSelected = _treeHasSelection(termB);
    if (termASelected === termBSelected) {
      return 0;
    }
    if (termASelected && !termBSelected) {
      return -1;
    }
    if (!termASelected && termBSelected) {
      return 1;
    }
    return 0;
  };
  var newTermTree = (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_3__["default"])(termsTree);
  newTermTree.sort(termOrChildIsSelected);
  return newTermTree;
}

/**
 * Find term by parent id or name.
 *
 * @param {Object[]}      terms  Array of Terms.
 * @param {number|string} parent id.
 * @param {string}        name   Term name.
 * @return {Object} Term object.
 */
function findTerm(terms, parent, name) {
  return terms.find(function (term) {
    return (!term.parent && !parent || parseInt(term.parent) === parseInt(parent)) && term.name.toLowerCase() === name.toLowerCase();
  });
}

/**
 * Get filter matcher function.
 *
 * @param {string} filterValue Filter value.
 * @return {(function(Object): (Object|boolean))} Matcher function.
 */
function getFilterMatcher(filterValue) {
  var _matchTermsForFilter = function matchTermsForFilter(originalTerm) {
    if ('' === filterValue) {
      return originalTerm;
    }

    // Shallow clone, because we'll be filtering the term's children and
    // don't want to modify the original term.
    var term = _objectSpread({}, originalTerm);

    // Map and filter the children, recursive so we deal with grandchildren
    // and any deeper levels.
    if (term.children.length > 0) {
      term.children = term.children.map(_matchTermsForFilter).filter(function (child) {
        return child;
      });
    }

    // If the term's name contains the filterValue, or it has children
    // (i.e. some child matched at some point in the tree) then return it.
    if (-1 !== term.name.toLowerCase().indexOf(filterValue.toLowerCase()) || term.children.length > 0) {
      return term;
    }

    // Otherwise, return false. After mapping, the list of terms will need
    // to have false values filtered out.
    return false;
  };
  return _matchTermsForFilter;
}

/**
 * Hierarchical term selector.
 *
 * @param {Object} props      Component props.
 * @param {string} props.slug Taxonomy slug.
 * @return {Element}        Hierarchical term selector component.
 */
function CustomTermSelector(_ref) {
  var _taxonomy$labels$sear, _taxonomy$labels3, _taxonomy$name;
  var slug = _ref.slug;
  var _useState = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)(false),
    _useState2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_useState, 2),
    adding = _useState2[0],
    setAdding = _useState2[1];
  var _useState3 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)(''),
    _useState4 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_useState3, 2),
    formName = _useState4[0],
    setFormName = _useState4[1];
  /**
   * @type {[number|'', Function]}
   */
  var _useState5 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)(''),
    _useState6 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_useState5, 2),
    formParent = _useState6[0],
    setFormParent = _useState6[1];
  var _useState7 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)(false),
    _useState8 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_useState7, 2),
    showForm = _useState8[0],
    setShowForm = _useState8[1];
  var _useState9 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)(''),
    _useState10 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_useState9, 2),
    filterValue = _useState10[0],
    setFilterValue = _useState10[1];
  var _useState11 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)([]),
    _useState12 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_useState11, 2),
    filteredTermsTree = _useState12[0],
    setFilteredTermsTree = _useState12[1];
  var debouncedSpeak = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_10__.useDebounce)(_wordpress_a11y__WEBPACK_IMPORTED_MODULE_12__.speak, 500);
  var _useSelect = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_9__.useSelect)(function (select) {
      var _post$_links, _post$_links2, _post$_links3, _post$_links4;
      var _select = select(_wordpress_editor__WEBPACK_IMPORTED_MODULE_15__.store),
        getCurrentPost = _select.getCurrentPost,
        getEditedPostAttribute = _select.getEditedPostAttribute;
      var _select2 = select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_11__.store),
        getTaxonomy = _select2.getTaxonomy,
        getEntityRecords = _select2.getEntityRecords,
        isResolving = _select2.isResolving;
      var _taxonomy = getTaxonomy(slug);
      var post = getCurrentPost();
      return {
        hasCreateAction: _taxonomy ? (_post$_links = (_post$_links2 = post._links) === null || _post$_links2 === void 0 ? void 0 : _post$_links2['wp:action-create-' + _taxonomy.rest_base]) !== null && _post$_links !== void 0 ? _post$_links : false : false,
        hasAssignAction: _taxonomy ? (_post$_links3 = (_post$_links4 = post._links) === null || _post$_links4 === void 0 ? void 0 : _post$_links4['wp:action-assign-' + _taxonomy.rest_base]) !== null && _post$_links3 !== void 0 ? _post$_links3 : false : false,
        terms: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : EMPTY_ARRAY,
        loading: isResolving('getEntityRecords', ['taxonomy', slug, DEFAULT_QUERY]),
        availableTerms: getEntityRecords('taxonomy', slug, DEFAULT_QUERY) || EMPTY_ARRAY,
        taxonomy: _taxonomy
      };
    }, [slug]),
    hasCreateAction = _useSelect.hasCreateAction,
    hasAssignAction = _useSelect.hasAssignAction,
    terms = _useSelect.terms,
    loading = _useSelect.loading,
    availableTerms = _useSelect.availableTerms,
    taxonomy = _useSelect.taxonomy;
  var _useDispatch = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_9__.useDispatch)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_15__.store),
    editPost = _useDispatch.editPost;
  var _useDispatch2 = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_9__.useDispatch)(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_11__.store),
    saveEntityRecord = _useDispatch2.saveEntityRecord;
  var availableTermsTree = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useMemo)(function () {
    return sortBySelected((0,_utils_terms__WEBPACK_IMPORTED_MODULE_14__.buildTermsTree)(availableTerms), terms);
  },
  // Remove `terms` from the dependency list to avoid reordering every time
  // checking or unchecking a term.
  [availableTerms]);
  var _useDispatch3 = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_9__.useDispatch)(_wordpress_notices__WEBPACK_IMPORTED_MODULE_7__.store),
    createErrorNotice = _useDispatch3.createErrorNotice;
  if (!hasAssignAction) {
    return null;
  }

  /**
   * Append new term.
   *
   * @param {Object} term Term object.
   * @return {Promise} A promise that resolves to save term object.
   */
  var addTerm = function addTerm(term) {
    return saveEntityRecord('taxonomy', slug, term, {
      throwOnError: true
    });
  };

  /**
   * Update terms for post.
   *
   * @param {number[]} termIds Term ids.
   */
  var onUpdateTerms = function onUpdateTerms(termIds) {
    editPost((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__["default"])({}, taxonomy.rest_base, termIds));
  };

  /**
   * Handler for checking term.
   *
   * @param {number} termId
   */
  var _onChange = function onChange(termId) {
    var hasTerm = terms.includes(termId);
    var newTerms = hasTerm ? terms.filter(function (id) {
      return id !== termId;
    }) : [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_3__["default"])(terms), [termId]);
    onUpdateTerms(newTerms);
  };
  var onChangeFormName = function onChangeFormName(value) {
    setFormName(value);
  };

  /**
   * Handler for changing form parent.
   *
   * @param {number|''} parentId Parent post id.
   */
  var onChangeFormParent = function onChangeFormParent(parentId) {
    setFormParent(parentId);
  };
  var onToggleForm = function onToggleForm() {
    setShowForm(!showForm);
  };
  var onAddTerm = /*#__PURE__*/function () {
    var _ref2 = (0,_babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__["default"])(/*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_4___default().mark(function _callee(event) {
      var _taxonomy$labels$sing, _taxonomy$labels;
      var existingTerm, newTerm, defaultName, termAddedMessage;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_4___default().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            event.preventDefault();
            if (!(formName === '' || adding)) {
              _context.next = 3;
              break;
            }
            return _context.abrupt("return");
          case 3:
            // Check if the term we are adding already exists.
            existingTerm = findTerm(availableTerms, formParent, formName);
            if (!existingTerm) {
              _context.next = 9;
              break;
            }
            // If the term we are adding exists but is not selected select it.
            if (!terms.some(function (term) {
              return term === existingTerm.id;
            })) {
              onUpdateTerms([].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_3__["default"])(terms), [existingTerm.id]));
            }
            setFormName('');
            setFormParent('');
            return _context.abrupt("return");
          case 9:
            setAdding(true);
            _context.prev = 10;
            _context.next = 13;
            return addTerm({
              name: formName,
              parent: formParent ? formParent : undefined
            });
          case 13:
            newTerm = _context.sent;
            _context.next = 20;
            break;
          case 16:
            _context.prev = 16;
            _context.t0 = _context["catch"](10);
            createErrorNotice(_context.t0.message, {
              type: 'snackbar'
            });
            return _context.abrupt("return");
          case 20:
            defaultName = slug === 'category' ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Category') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Term');
            termAddedMessage = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.sprintf)(/* translators: %s: taxonomy name */
            (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__._x)('%s added', 'term'), (_taxonomy$labels$sing = taxonomy === null || taxonomy === void 0 || (_taxonomy$labels = taxonomy.labels) === null || _taxonomy$labels === void 0 ? void 0 : _taxonomy$labels.singular_name) !== null && _taxonomy$labels$sing !== void 0 ? _taxonomy$labels$sing : defaultName);
            (0,_wordpress_a11y__WEBPACK_IMPORTED_MODULE_12__.speak)(termAddedMessage, 'assertive');
            setAdding(false);
            setFormName('');
            setFormParent('');
            onUpdateTerms([].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_3__["default"])(terms), [newTerm.id]));
          case 27:
          case "end":
            return _context.stop();
        }
      }, _callee, null, [[10, 16]]);
    }));
    return function onAddTerm(_x2) {
      return _ref2.apply(this, arguments);
    };
  }();
  var setFilter = function setFilter(value) {
    var newFilteredTermsTree = availableTermsTree.map(getFilterMatcher(value)).filter(function (term) {
      return term;
    });
    var _getResultCount = function getResultCount(termsTree) {
      var count = 0;
      for (var i = 0; i < termsTree.length; i++) {
        count++;
        if (undefined !== termsTree[i].children) {
          count += _getResultCount(termsTree[i].children);
        }
      }
      return count;
    };
    setFilterValue(value);
    setFilteredTermsTree(newFilteredTermsTree);
    var resultCount = _getResultCount(newFilteredTermsTree);
    var resultsFoundMessage = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.sprintf)(/* translators: %d: number of results */
    (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__._n)('%d result found.', '%d results found.', resultCount), resultCount);
    debouncedSpeak(resultsFoundMessage, 'assertive');
  };
  var _renderTerms = function renderTerms(renderedTerms) {
    return renderedTerms.map(function (term) {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsxs)("div", {
        className: "editor-post-taxonomies__hierarchical-terms-choice",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.CheckboxControl, {
          __nextHasNoMarginBottom: true,
          checked: terms.indexOf(term.id) !== -1,
          onChange: function onChange() {
            var termId = parseInt(term.id, 10);
            _onChange(termId);
          },
          label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_13__.decodeEntities)(term.name)
        }), !!term.children.length && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)("div", {
          className: "editor-post-taxonomies__hierarchical-terms-subchoices",
          children: _renderTerms(term.children)
        })]
      }, term.id);
    });
  };
  var labelWithFallback = function labelWithFallback(labelProperty, fallbackIsCategory, fallbackIsNotCategory) {
    var _taxonomy$labels$labe, _taxonomy$labels2;
    return (_taxonomy$labels$labe = taxonomy === null || taxonomy === void 0 || (_taxonomy$labels2 = taxonomy.labels) === null || _taxonomy$labels2 === void 0 ? void 0 : _taxonomy$labels2[labelProperty]) !== null && _taxonomy$labels$labe !== void 0 ? _taxonomy$labels$labe : slug === 'category' ? fallbackIsCategory : fallbackIsNotCategory;
  };
  var newTermButtonLabel = labelWithFallback('add_new_item', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Add new category'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Add new term'));
  var newTermLabel = labelWithFallback('new_item_name', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Add new category'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Add new term'));
  var parentSelectLabel = labelWithFallback('parent_item', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Parent Category'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Parent Term'));
  var noParentOption = "\u2014 ".concat(parentSelectLabel, " \u2014");
  var newTermSubmitLabel = newTermButtonLabel;
  var filterLabel = (_taxonomy$labels$sear = taxonomy === null || taxonomy === void 0 || (_taxonomy$labels3 = taxonomy.labels) === null || _taxonomy$labels3 === void 0 ? void 0 : _taxonomy$labels3.search_items) !== null && _taxonomy$labels$sear !== void 0 ? _taxonomy$labels$sear : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Search Terms');
  var groupLabel = (_taxonomy$name = taxonomy === null || taxonomy === void 0 ? void 0 : taxonomy.name) !== null && _taxonomy$name !== void 0 ? _taxonomy$name : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Terms');
  var showFilter = availableTerms.length >= MIN_TERMS_COUNT_FOR_FILTER;
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.Flex, {
    direction: "column",
    gap: "4",
    children: [showFilter && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.SearchControl, {
      __next40pxDefaultSize: true,
      __nextHasNoMarginBottom: true,
      label: filterLabel,
      value: filterValue,
      onChange: setFilter
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)("div", {
      className: "editor-post-taxonomies__hierarchical-terms-list",
      tabIndex: "0",
      role: "group",
      "aria-label": groupLabel,
      children: _renderTerms('' !== filterValue ? filteredTermsTree : availableTermsTree)
    }), !loading && hasCreateAction && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.FlexItem, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.Button, {
        __next40pxDefaultSize: true,
        onClick: onToggleForm,
        className: "editor-post-taxonomies__hierarchical-terms-add",
        "aria-expanded": showForm,
        variant: "link",
        children: newTermButtonLabel
      })
    }), showForm && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)("form", {
      onSubmit: onAddTerm,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.Flex, {
        direction: "column",
        gap: "4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.TextControl, {
          __next40pxDefaultSize: true,
          __nextHasNoMarginBottom: true,
          className: "editor-post-taxonomies__hierarchical-terms-input",
          label: newTermLabel,
          value: formName,
          onChange: onChangeFormName,
          required: true
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.FlexItem, {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_16__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.Button, {
            __next40pxDefaultSize: true,
            variant: "secondary",
            type: "submit",
            className: "editor-post-taxonomies__hierarchical-terms-submit",
            children: newTermSubmitLabel
          })
        })]
      })
    })]
  });
}
/* harmony default export */ __webpack_exports__["default"] = (CustomTermSelector);

/***/ }),

/***/ "./block-editor/src/custom-editor-scripts/utils/terms.js":
/*!***************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/utils/terms.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   buildTermsTree: function() { return /* binding */ buildTermsTree; },
/* harmony export */   unescapeString: function() { return /* binding */ unescapeString; },
/* harmony export */   unescapeTerm: function() { return /* binding */ unescapeTerm; },
/* harmony export */   unescapeTerms: function() { return /* binding */ unescapeTerms; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_1__);

function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
/**
 * WordPress dependencies
 */


/**
 * Returns terms in a tree form.
 *
 * @param {Array} flatTerms Array of terms in flat format.
 *
 * @return {Array} Array of terms in tree format.
 */
function buildTermsTree(flatTerms) {
  var flatTermsWithParentAndChildren = flatTerms.map(function (term) {
    return _objectSpread({
      children: [],
      parent: undefined
    }, term);
  });

  // All terms should have a `parent` because we're about to index them by it.
  if (flatTermsWithParentAndChildren.some(function (_ref) {
    var parent = _ref.parent;
    return parent === undefined;
  })) {
    return flatTermsWithParentAndChildren;
  }
  var termsByParent = flatTermsWithParentAndChildren.reduce(function (acc, term) {
    var parent = term.parent;
    if (!acc[parent]) {
      acc[parent] = [];
    }
    acc[parent].push(term);
    return acc;
  }, {});
  var _fillWithChildren = function fillWithChildren(terms) {
    return terms.map(function (term) {
      var children = termsByParent[term.id];
      return _objectSpread(_objectSpread({}, term), {}, {
        children: children && children.length ? _fillWithChildren(children) : []
      });
    });
  };
  return _fillWithChildren(termsByParent['0'] || []);
}
var unescapeString = function unescapeString(arg) {
  return (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_1__.decodeEntities)(arg);
};

/**
 * Returns a term object with name unescaped.
 *
 * @param {Object} term The term object to unescape.
 *
 * @return {Object} Term object with name property unescaped.
 */
var unescapeTerm = function unescapeTerm(term) {
  return _objectSpread(_objectSpread({}, term), {}, {
    name: unescapeString(term.name)
  });
};

/**
 * Returns an array of term objects with names unescaped.
 * The unescape of each term is performed using the unescapeTerm function.
 *
 * @param {Object[]} terms Array of term objects to unescape.
 *
 * @return {Object[]} Array of term objects unescaped.
 */
var unescapeTerms = function unescapeTerms(terms) {
  return (terms !== null && terms !== void 0 ? terms : []).map(unescapeTerm);
};

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ (function(module) {

"use strict";
module.exports = window["ReactJSXRuntime"];

/***/ }),

/***/ "@babel/runtime/regenerator":
/*!*************************************!*\
  !*** external "regeneratorRuntime" ***!
  \*************************************/
/***/ (function(module) {

"use strict";
module.exports = window["regeneratorRuntime"];

/***/ }),

/***/ "@wordpress/a11y":
/*!******************************!*\
  !*** external ["wp","a11y"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["a11y"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["compose"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/editor":
/*!********************************!*\
  !*** external ["wp","editor"] ***!
  \********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["editor"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/hooks":
/*!*******************************!*\
  !*** external ["wp","hooks"] ***!
  \*******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["hooks"];

/***/ }),

/***/ "@wordpress/html-entities":
/*!**************************************!*\
  !*** external ["wp","htmlEntities"] ***!
  \**************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["htmlEntities"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/notices":
/*!*********************************!*\
  !*** external ["wp","notices"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["notices"];

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["plugins"];

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = '';

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (arg) {
				classes = appendClass(classes, parseValue(arg));
			}
		}

		return classes;
	}

	function parseValue (arg) {
		if (typeof arg === 'string' || typeof arg === 'number') {
			return arg;
		}

		if (typeof arg !== 'object') {
			return '';
		}

		if (Array.isArray(arg)) {
			return classNames.apply(null, arg);
		}

		if (arg.toString !== Object.prototype.toString && !arg.toString.toString().includes('[native code]')) {
			return arg.toString();
		}

		var classes = '';

		for (var key in arg) {
			if (hasOwn.call(arg, key) && arg[key]) {
				classes = appendClass(classes, key);
			}
		}

		return classes;
	}

	function appendClass (value, newClass) {
		if (!newClass) {
			return value;
		}
	
		if (value) {
			return value + ' ' + newClass;
		}
	
		return value + newClass;
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayLikeToArray; }
/* harmony export */ });
function _arrayLikeToArray(r, a) {
  (null == a || a > r.length) && (a = r.length);
  for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e];
  return n;
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayWithHoles; }
/* harmony export */ });
function _arrayWithHoles(r) {
  if (Array.isArray(r)) return r;
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayWithoutHoles; }
/* harmony export */ });
/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");

function _arrayWithoutHoles(r) {
  if (Array.isArray(r)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r);
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _asyncToGenerator; }
/* harmony export */ });
function asyncGeneratorStep(n, t, e, r, o, a, c) {
  try {
    var i = n[a](c),
      u = i.value;
  } catch (n) {
    return void e(n);
  }
  i.done ? t(u) : Promise.resolve(u).then(r, o);
}
function _asyncToGenerator(n) {
  return function () {
    var t = this,
      e = arguments;
    return new Promise(function (r, o) {
      var a = n.apply(t, e);
      function _next(n) {
        asyncGeneratorStep(a, r, o, _next, _throw, "next", n);
      }
      function _throw(n) {
        asyncGeneratorStep(a, r, o, _next, _throw, "throw", n);
      }
      _next(void 0);
    });
  };
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
/* harmony import */ var _toPropertyKey_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./toPropertyKey.js */ "./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js");

function _defineProperty(e, r, t) {
  return (r = (0,_toPropertyKey_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r)) in e ? Object.defineProperty(e, r, {
    value: t,
    enumerable: !0,
    configurable: !0,
    writable: !0
  }) : e[r] = t, e;
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/iterableToArray.js":
/*!********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/iterableToArray.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _iterableToArray; }
/* harmony export */ });
function _iterableToArray(r) {
  if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r);
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js ***!
  \*************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _iterableToArrayLimit; }
/* harmony export */ });
function _iterableToArrayLimit(r, l) {
  var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"];
  if (null != t) {
    var e,
      n,
      i,
      u,
      a = [],
      f = !0,
      o = !1;
    try {
      if (i = (t = t.call(r)).next, 0 === l) {
        if (Object(t) !== t) return;
        f = !1;
      } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0);
    } catch (r) {
      o = !0, n = r;
    } finally {
      try {
        if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return;
      } finally {
        if (o) throw n;
      }
    }
    return a;
  }
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js":
/*!********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _nonIterableRest; }
/* harmony export */ });
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _nonIterableSpread; }
/* harmony export */ });
function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/slicedToArray.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _slicedToArray; }
/* harmony export */ });
/* harmony import */ var _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithHoles.js */ "./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js");
/* harmony import */ var _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArrayLimit.js */ "./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js");
/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
/* harmony import */ var _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableRest.js */ "./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js");




function _slicedToArray(r, e) {
  return (0,_arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r) || (0,_iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__["default"])(r, e) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(r, e) || (0,_nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _toConsumableArray; }
/* harmony export */ });
/* harmony import */ var _arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithoutHoles.js */ "./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js");
/* harmony import */ var _iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArray.js */ "./node_modules/@babel/runtime/helpers/esm/iterableToArray.js");
/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
/* harmony import */ var _nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableSpread.js */ "./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js");




function _toConsumableArray(r) {
  return (0,_arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r) || (0,_iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__["default"])(r) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(r) || (0,_nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toPrimitive.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toPrimitive.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ toPrimitive; }
/* harmony export */ });
/* harmony import */ var _typeof_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/esm/typeof.js");

function toPrimitive(t, r) {
  if ("object" != (0,_typeof_js__WEBPACK_IMPORTED_MODULE_0__["default"])(t) || !t) return t;
  var e = t[Symbol.toPrimitive];
  if (void 0 !== e) {
    var i = e.call(t, r || "default");
    if ("object" != (0,_typeof_js__WEBPACK_IMPORTED_MODULE_0__["default"])(i)) return i;
    throw new TypeError("@@toPrimitive must return a primitive value.");
  }
  return ("string" === r ? String : Number)(t);
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ toPropertyKey; }
/* harmony export */ });
/* harmony import */ var _typeof_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/esm/typeof.js");
/* harmony import */ var _toPrimitive_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./toPrimitive.js */ "./node_modules/@babel/runtime/helpers/esm/toPrimitive.js");


function toPropertyKey(t) {
  var i = (0,_toPrimitive_js__WEBPACK_IMPORTED_MODULE_1__["default"])(t, "string");
  return "symbol" == (0,_typeof_js__WEBPACK_IMPORTED_MODULE_0__["default"])(i) ? i : i + "";
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/typeof.js":
/*!***********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/typeof.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _typeof; }
/* harmony export */ });
function _typeof(o) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
    return typeof o;
  } : function (o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  }, _typeof(o);
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _unsupportedIterableToArray; }
/* harmony export */ });
/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");

function _unsupportedIterableToArray(r, a) {
  if (r) {
    if ("string" == typeof r) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r, a);
    var t = {}.toString.call(r).slice(8, -1);
    return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r, a) : void 0;
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
!function() {
"use strict";
/*!*********************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/index.js ***!
  \*********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _customTermSelector__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./customTermSelector */ "./block-editor/src/custom-editor-scripts/customTermSelector.js");
/* harmony import */ var _authorTermSelector__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./authorTermSelector */ "./block-editor/src/custom-editor-scripts/authorTermSelector.js");
/* harmony import */ var _customMetaSettings__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./customMetaSettings */ "./block-editor/src/custom-editor-scripts/customMetaSettings.js");
/* harmony import */ var _block_variations_button__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../block-variations/button */ "./block-editor/src/block-variations/button.js");
/* harmony import */ var _block_variations_bubble_heading__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../block-variations/bubble-heading */ "./block-editor/src/block-variations/bubble-heading.js");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/hooks */ "@wordpress/hooks");
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_7__);

function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
/* jslint esnext: true */
/* global wp */

/**
 * Internal dependencies
 */







//import {registerFormats } from './richTextCustomFormats';

//registerFormats();
(0,_block_variations_button__WEBPACK_IMPORTED_MODULE_4__.registerKapitalButtonVariation)();
(0,_customMetaSettings__WEBPACK_IMPORTED_MODULE_3__.customMetaSettings)();
(0,_block_variations_bubble_heading__WEBPACK_IMPORTED_MODULE_5__.registerBubbleHeadingVariation)();

// Based on the example here: https://github.com/WordPress/gutenberg/tree/master/packages/editor/src/components/post-taxonomies#custom-taxonomy-selector
(function () {
  var el = wp.element.createElement;

  // It's up to you on how to make this dynamic..
  //const flatTerms = [ 'podcast-seria', 'redakcia-tag', 'jazyk', 'seria', 'cislo', 'partner' ];
  var flatTerms = ['podcast-seria', 'redakcia-tag', 'jazyk', 'partner', 'cislo', 'seria', 'zaner'];
  var authorTerm = ['autorstvo'];
  function modifySelector(OriginalComponent) {
    return function (props) {
      // props.slug is the taxonomy (slug)
      if (flatTerms.indexOf(props.slug) >= 0) {
        return el(_customTermSelector__WEBPACK_IMPORTED_MODULE_1__.CustomTermSelector, props);
      } else if (authorTerm.indexOf(props.slug) >= 0) {
        return el(_authorTermSelector__WEBPACK_IMPORTED_MODULE_2__.AuthorTermSelector, props);
      }
      return el(OriginalComponent, props);
    };
  }
  wp.hooks.addFilter('editor.PostTaxonomyType', 'kapital/custom-term-selector',
  // you should change this
  modifySelector);
})(); // end closure




// This filter adds alignment support to core/paragraph if not already present
var wideAlignBlocks = ['core/paragraph', 'core/heading', 'core/list'];
var addWideAlignmentSupport = function addWideAlignmentSupport(settings) {
  if (wideAlignBlocks.includes(settings.name)) {
    settings.supports = _objectSpread(_objectSpread({}, settings.supports), {}, {
      align: ["wide", "full"]
    });
  }
  return settings;
};

// Apply the filter to the core/paragraph block
(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_7__.addFilter)('blocks.registerBlockType', 'kapital/more-blocks-align-support', addWideAlignmentSupport);
}();
/******/ })()
;
//# sourceMappingURL=index.js.map