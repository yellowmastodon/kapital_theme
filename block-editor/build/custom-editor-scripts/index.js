/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./block-editor/src/custom-editor-scripts/authorTermSelector.js":
/*!**********************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/authorTermSelector.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   AuthorTermSelector: () => (/* binding */ AuthorTermSelector),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_deprecated__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/deprecated */ "@wordpress/deprecated");
/* harmony import */ var _wordpress_deprecated__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_deprecated__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_a11y__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/a11y */ "@wordpress/a11y");
/* harmony import */ var _wordpress_a11y__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_a11y__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/notices */ "@wordpress/notices");
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_notices__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _utils_terms__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./utils/terms */ "./block-editor/src/custom-editor-scripts/utils/terms.js");

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
const EMPTY_ARRAY = [];

/**
 * How the max suggestions limit was chosen:
 *  - Matches the `per_page` range set by the REST API.
 *  - Can't use "unbound" query. The `FormTokenField` needs a fixed number.
 *  - Matches default for `FormTokenField`.
 */
const MAX_TERMS_SUGGESTIONS = -1;
const DEFAULT_QUERY = {
  per_page: MAX_TERMS_SUGGESTIONS,
  _fields: 'id,name'
};

/**
 * Renders a flat term selector component.
 *
 * @param {Object}  props                         The component props.
 * @param {string}  props.slug                    The slug of the taxonomy.
 * @param {boolean} props.__nextHasNoMarginBottom Start opting into the new margin-free styles that will become the default in a future version, currently scheduled to be WordPress 7.0. (The prop can be safely removed once this happens.)
 *
 * @return {JSX.Element} The rendered flat term selector component.
 */
function AuthorTermSelector({
  slug,
  __nextHasNoMarginBottom
}) {
  const {
    hasCreateAction,
    hasAssignAction,
    terms,
    loading,
    availableTerms,
    taxonomy
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    var _post$_links, _post$_links2;
    const {
      getCurrentPost,
      getEditedPostAttribute
    } = select(_wordpress_editor__WEBPACK_IMPORTED_MODULE_10__.store);
    const {
      getTaxonomy,
      getEntityRecords,
      isResolving
    } = select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__.store);
    const _taxonomy = getTaxonomy(slug);
    const post = getCurrentPost();
    return {
      hasCreateAction: _taxonomy ? (_post$_links = post._links?.['wp:action-create-' + _taxonomy.rest_base]) !== null && _post$_links !== void 0 ? _post$_links : false : false,
      hasAssignAction: _taxonomy ? (_post$_links2 = post._links?.['wp:action-assign-' + _taxonomy.rest_base]) !== null && _post$_links2 !== void 0 ? _post$_links2 : false : false,
      terms: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : EMPTY_ARRAY,
      loading: isResolving('getEntityRecords', ['taxonomy', slug, DEFAULT_QUERY]),
      availableTerms: getEntityRecords('taxonomy', slug, DEFAULT_QUERY) || EMPTY_ARRAY,
      taxonomy: _taxonomy
    };
  }, [slug]);
  console.log(terms);

  /**
   * Update terms for post.
   *
   * @param {number[]} termIds Term ids.
   */
  const onUpdateTerms = termIds => {
    editPost({
      [taxonomy.rest_base]: termIds
    });
  };

  /**
  * Handler for checking term.
  *
  * @param {number} termId
  */
  const onChange = termId => {
    const hasTerm = terms.includes(termId);
    const newTerms = hasTerm ? terms.filter(id => id !== termId) : [...terms, termId];
    onUpdateTerms(newTerms);
  };

  /* 	const { authors } = useSelect( ( select ) => {
  		const { getEntityRecords } = select( 'core' )
  	
  		return {
  			authors: getEntityRecords( 'taxonomy', 'seria', { per_page: -1 } ),
  		}
  	} ) */

  let options = [];
  if (availableTerms) {
    options = availableTerms.map(availableTerm => {
      return {
        label: availableTerm.name,
        value: availableTerm.id
      };
    });
  }

  // display select dropdown
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.ComboboxControl, {
    options: options || []
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.withFilters)('editor.PostTaxonomyType')(AuthorTermSelector));

/***/ }),

/***/ "./block-editor/src/custom-editor-scripts/customTermSelector.js":
/*!**********************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/customTermSelector.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CustomTermSelector: () => (/* binding */ CustomTermSelector),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   findTerm: () => (/* binding */ findTerm),
/* harmony export */   getFilterMatcher: () => (/* binding */ getFilterMatcher),
/* harmony export */   sortBySelected: () => (/* binding */ sortBySelected)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/notices */ "@wordpress/notices");
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_notices__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_a11y__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/a11y */ "@wordpress/a11y");
/* harmony import */ var _wordpress_a11y__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_a11y__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _utils_terms__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./utils/terms */ "./block-editor/src/custom-editor-scripts/utils/terms.js");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_11__);

/**
 * WordPress dependencies
 */










/**
 * Internal dependencies
 */



/**
 * Module Constants
 */
const DEFAULT_QUERY = {
  per_page: -1,
  orderby: 'name',
  order: 'asc',
  _fields: 'id,name,parent',
  context: 'view'
};
const MIN_TERMS_COUNT_FOR_FILTER = 8;
const EMPTY_ARRAY = [];

/**
 * Sort Terms by Selected.
 *
 * @param {Object[]} termsTree Array of terms in tree format.
 * @param {number[]} terms     Selected terms.
 *
 * @return {Object[]} Sorted array of terms.
 */
function sortBySelected(termsTree, terms) {
  const treeHasSelection = termTree => {
    if (terms.indexOf(termTree.id) !== -1) {
      return true;
    }
    if (undefined === termTree.children) {
      return false;
    }
    return termTree.children.map(treeHasSelection).filter(child => child).length > 0;
  };
  const termOrChildIsSelected = (termA, termB) => {
    const termASelected = treeHasSelection(termA);
    const termBSelected = treeHasSelection(termB);
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
  const newTermTree = [...termsTree];
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
  return terms.find(term => {
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
  const matchTermsForFilter = originalTerm => {
    if ('' === filterValue) {
      return originalTerm;
    }

    // Shallow clone, because we'll be filtering the term's children and
    // don't want to modify the original term.
    const term = {
      ...originalTerm
    };

    // Map and filter the children, recursive so we deal with grandchildren
    // and any deeper levels.
    if (term.children.length > 0) {
      term.children = term.children.map(matchTermsForFilter).filter(child => child);
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
  return matchTermsForFilter;
}

/**
 * Hierarchical term selector.
 *
 * @param {Object} props      Component props.
 * @param {string} props.slug Taxonomy slug.
 * @return {Element}        Hierarchical term selector component.
 */
function CustomTermSelector({
  slug
}) {
  var _taxonomy$labels$sear, _taxonomy$name;
  const [adding, setAdding] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)(false);
  const [formName, setFormName] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)('');
  /**
   * @type {[number|'', Function]}
   */
  const [formParent, setFormParent] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)('');
  const [showForm, setShowForm] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)(false);
  const [filterValue, setFilterValue] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)('');
  const [filteredTermsTree, setFilteredTermsTree] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)([]);
  const debouncedSpeak = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_6__.useDebounce)(_wordpress_a11y__WEBPACK_IMPORTED_MODULE_8__.speak, 500);
  const {
    hasCreateAction,
    hasAssignAction,
    terms,
    loading,
    availableTerms,
    taxonomy
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_5__.useSelect)(select => {
    var _post$_links, _post$_links2;
    const {
      getCurrentPost,
      getEditedPostAttribute
    } = select(_wordpress_editor__WEBPACK_IMPORTED_MODULE_11__.store);
    const {
      getTaxonomy,
      getEntityRecords,
      isResolving
    } = select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__.store);
    const _taxonomy = getTaxonomy(slug);
    const post = getCurrentPost();
    return {
      hasCreateAction: _taxonomy ? (_post$_links = post._links?.['wp:action-create-' + _taxonomy.rest_base]) !== null && _post$_links !== void 0 ? _post$_links : false : false,
      hasAssignAction: _taxonomy ? (_post$_links2 = post._links?.['wp:action-assign-' + _taxonomy.rest_base]) !== null && _post$_links2 !== void 0 ? _post$_links2 : false : false,
      terms: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : EMPTY_ARRAY,
      loading: isResolving('getEntityRecords', ['taxonomy', slug, DEFAULT_QUERY]),
      availableTerms: getEntityRecords('taxonomy', slug, DEFAULT_QUERY) || EMPTY_ARRAY,
      taxonomy: _taxonomy
    };
  }, [slug]);
  const {
    editPost
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_5__.useDispatch)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_11__.store);
  const {
    saveEntityRecord
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_5__.useDispatch)(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__.store);
  const availableTermsTree = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useMemo)(() => sortBySelected((0,_utils_terms__WEBPACK_IMPORTED_MODULE_10__.buildTermsTree)(availableTerms), terms),
  // Remove `terms` from the dependency list to avoid reordering every time
  // checking or unchecking a term.
  [availableTerms]);
  const {
    createErrorNotice
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_5__.useDispatch)(_wordpress_notices__WEBPACK_IMPORTED_MODULE_3__.store);
  if (!hasAssignAction) {
    return null;
  }

  /**
   * Append new term.
   *
   * @param {Object} term Term object.
   * @return {Promise} A promise that resolves to save term object.
   */
  const addTerm = term => {
    return saveEntityRecord('taxonomy', slug, term, {
      throwOnError: true
    });
  };

  /**
   * Update terms for post.
   *
   * @param {number[]} termIds Term ids.
   */
  const onUpdateTerms = termIds => {
    editPost({
      [taxonomy.rest_base]: termIds
    });
  };

  /**
   * Handler for checking term.
   *
   * @param {number} termId
   */
  const onChange = termId => {
    const hasTerm = terms.includes(termId);
    const newTerms = hasTerm ? terms.filter(id => id !== termId) : [...terms, termId];
    onUpdateTerms(newTerms);
  };
  const onChangeFormName = value => {
    setFormName(value);
  };

  /**
   * Handler for changing form parent.
   *
   * @param {number|''} parentId Parent post id.
   */
  const onChangeFormParent = parentId => {
    setFormParent(parentId);
  };
  const onToggleForm = () => {
    setShowForm(!showForm);
  };
  const onAddTerm = async event => {
    var _taxonomy$labels$sing;
    event.preventDefault();
    if (formName === '' || adding) {
      return;
    }

    // Check if the term we are adding already exists.
    const existingTerm = findTerm(availableTerms, formParent, formName);
    if (existingTerm) {
      // If the term we are adding exists but is not selected select it.
      if (!terms.some(term => term === existingTerm.id)) {
        onUpdateTerms([...terms, existingTerm.id]);
      }
      setFormName('');
      setFormParent('');
      return;
    }
    setAdding(true);
    let newTerm;
    try {
      newTerm = await addTerm({
        name: formName,
        parent: formParent ? formParent : undefined
      });
    } catch (error) {
      createErrorNotice(error.message, {
        type: 'snackbar'
      });
      return;
    }
    const defaultName = slug === 'category' ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Category') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Term');
    const termAddedMessage = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.sprintf)( /* translators: %s: taxonomy name */
    (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__._x)('%s added', 'term'), (_taxonomy$labels$sing = taxonomy?.labels?.singular_name) !== null && _taxonomy$labels$sing !== void 0 ? _taxonomy$labels$sing : defaultName);
    (0,_wordpress_a11y__WEBPACK_IMPORTED_MODULE_8__.speak)(termAddedMessage, 'assertive');
    setAdding(false);
    setFormName('');
    setFormParent('');
    onUpdateTerms([...terms, newTerm.id]);
  };
  const setFilter = value => {
    const newFilteredTermsTree = availableTermsTree.map(getFilterMatcher(value)).filter(term => term);
    const getResultCount = termsTree => {
      let count = 0;
      for (let i = 0; i < termsTree.length; i++) {
        count++;
        if (undefined !== termsTree[i].children) {
          count += getResultCount(termsTree[i].children);
        }
      }
      return count;
    };
    setFilterValue(value);
    setFilteredTermsTree(newFilteredTermsTree);
    const resultCount = getResultCount(newFilteredTermsTree);
    const resultsFoundMessage = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.sprintf)( /* translators: %d: number of results */
    (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__._n)('%d result found.', '%d results found.', resultCount), resultCount);
    debouncedSpeak(resultsFoundMessage, 'assertive');
  };
  const renderTerms = renderedTerms => {
    return renderedTerms.map(term => {
      return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        key: term.id,
        className: "editor-post-taxonomies__hierarchical-terms-choice"
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.CheckboxControl, {
        __nextHasNoMarginBottom: true,
        checked: terms.indexOf(term.id) !== -1,
        onChange: () => {
          const termId = parseInt(term.id, 10);
          onChange(termId);
        },
        label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_9__.decodeEntities)(term.name)
      }), !!term.children.length && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "editor-post-taxonomies__hierarchical-terms-subchoices"
      }, renderTerms(term.children)));
    });
  };
  const labelWithFallback = (labelProperty, fallbackIsCategory, fallbackIsNotCategory) => {
    var _taxonomy$labels$labe;
    return (_taxonomy$labels$labe = taxonomy?.labels?.[labelProperty]) !== null && _taxonomy$labels$labe !== void 0 ? _taxonomy$labels$labe : slug === 'category' ? fallbackIsCategory : fallbackIsNotCategory;
  };
  const newTermButtonLabel = labelWithFallback('add_new_item', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add new category'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add new term'));
  const newTermLabel = labelWithFallback('new_item_name', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add new category'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add new term'));
  const parentSelectLabel = labelWithFallback('parent_item', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Parent Category'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Parent Term'));
  const noParentOption = `— ${parentSelectLabel} —`;
  const newTermSubmitLabel = newTermButtonLabel;
  const filterLabel = (_taxonomy$labels$sear = taxonomy?.labels?.search_items) !== null && _taxonomy$labels$sear !== void 0 ? _taxonomy$labels$sear : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search Terms');
  const groupLabel = (_taxonomy$name = taxonomy?.name) !== null && _taxonomy$name !== void 0 ? _taxonomy$name : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Terms');
  const showFilter = availableTerms.length >= MIN_TERMS_COUNT_FOR_FILTER;
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, {
    direction: "column",
    gap: "4"
  }, showFilter && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SearchControl, {
    __next40pxDefaultSize: true,
    __nextHasNoMarginBottom: true,
    label: filterLabel,
    value: filterValue,
    onChange: setFilter
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "editor-post-taxonomies__hierarchical-terms-list",
    tabIndex: "0",
    role: "group",
    "aria-label": groupLabel
  }, renderTerms('' !== filterValue ? filteredTermsTree : availableTermsTree)), !loading && hasCreateAction && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    __next40pxDefaultSize: true,
    onClick: onToggleForm,
    className: "editor-post-taxonomies__hierarchical-terms-add",
    "aria-expanded": showForm,
    variant: "link"
  }, newTermButtonLabel)), showForm && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("form", {
    onSubmit: onAddTerm
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, {
    direction: "column",
    gap: "4"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    __next40pxDefaultSize: true,
    __nextHasNoMarginBottom: true,
    className: "editor-post-taxonomies__hierarchical-terms-input",
    label: newTermLabel,
    value: formName,
    onChange: onChangeFormName,
    required: true
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    __next40pxDefaultSize: true,
    variant: "secondary",
    type: "submit",
    className: "editor-post-taxonomies__hierarchical-terms-submit"
  }, newTermSubmitLabel)))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.withFilters)('editor.PostTaxonomyType')(CustomTermSelector));

/***/ }),

/***/ "./block-editor/src/custom-editor-scripts/utils/terms.js":
/*!***************************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/utils/terms.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   buildTermsTree: () => (/* binding */ buildTermsTree),
/* harmony export */   unescapeString: () => (/* binding */ unescapeString),
/* harmony export */   unescapeTerm: () => (/* binding */ unescapeTerm),
/* harmony export */   unescapeTerms: () => (/* binding */ unescapeTerms)
/* harmony export */ });
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_0__);
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
  const flatTermsWithParentAndChildren = flatTerms.map(term => {
    return {
      children: [],
      parent: null,
      ...term
    };
  });

  // All terms should have a `parent` because we're about to index them by it.
  if (flatTermsWithParentAndChildren.some(({
    parent
  }) => parent === null)) {
    return flatTermsWithParentAndChildren;
  }
  const termsByParent = flatTermsWithParentAndChildren.reduce((acc, term) => {
    const {
      parent
    } = term;
    if (!acc[parent]) {
      acc[parent] = [];
    }
    acc[parent].push(term);
    return acc;
  }, {});
  const fillWithChildren = terms => {
    return terms.map(term => {
      const children = termsByParent[term.id];
      return {
        ...term,
        children: children && children.length ? fillWithChildren(children) : []
      };
    });
  };
  return fillWithChildren(Object.values(termsByParent)[0] || []);
}
const unescapeString = arg => {
  return (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_0__.decodeEntities)(arg);
};

/**
 * Returns a term object with name unescaped.
 *
 * @param {Object} term The term object to unescape.
 *
 * @return {Object} Term object with name property unescaped.
 */
const unescapeTerm = term => {
  return {
    ...term,
    name: unescapeString(term.name)
  };
};

/**
 * Returns an array of term objects with names unescaped.
 * The unescape of each term is performed using the unescapeTerm function.
 *
 * @param {Object[]} terms Array of term objects to unescape.
 *
 * @return {Object[]} Array of term objects unescaped.
 */
const unescapeTerms = terms => {
  return (terms !== null && terms !== void 0 ? terms : []).map(unescapeTerm);
};

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/a11y":
/*!******************************!*\
  !*** external ["wp","a11y"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["a11y"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["compose"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/deprecated":
/*!************************************!*\
  !*** external ["wp","deprecated"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["deprecated"];

/***/ }),

/***/ "@wordpress/editor":
/*!********************************!*\
  !*** external ["wp","editor"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["editor"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/html-entities":
/*!**************************************!*\
  !*** external ["wp","htmlEntities"] ***!
  \**************************************/
/***/ ((module) => {

module.exports = window["wp"]["htmlEntities"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/notices":
/*!*********************************!*\
  !*** external ["wp","notices"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["notices"];

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
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!*********************************************************!*\
  !*** ./block-editor/src/custom-editor-scripts/index.js ***!
  \*********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _customTermSelector__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./customTermSelector */ "./block-editor/src/custom-editor-scripts/customTermSelector.js");
/* harmony import */ var _authorTermSelector__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./authorTermSelector */ "./block-editor/src/custom-editor-scripts/authorTermSelector.js");
/* jslint esnext: true */
/* global wp */

/**
 * Internal dependencies
 */



// Based on the example here: https://github.com/WordPress/gutenberg/tree/master/packages/editor/src/components/post-taxonomies#custom-taxonomy-selector
(function () {
  const el = wp.element.createElement;

  // It's up to you on how to make this dynamic..
  //const flatTerms = [ 'podcast-seria', 'redakcia-tag', 'jazyk', 'seria', 'cislo', 'partner' ];
  const flatTerms = ['podcast-seria', 'redakcia-tag', 'jazyk', 'partner', 'cislo'];
  const authorTerm = ['seria'];
  function modifySelector(OriginalComponent) {
    return function (props) {
      // props.slug is the taxonomy (slug)
      if (flatTerms.indexOf(props.slug) >= 0) {
        return el(_customTermSelector__WEBPACK_IMPORTED_MODULE_0__.CustomTermSelector, props);
      } else if (authorTerm.indexOf(props.slug) >= 0) {
        return el(_authorTermSelector__WEBPACK_IMPORTED_MODULE_1__.AuthorTermSelector, props);
      }
      return el(OriginalComponent, props);
    };
  }
  wp.hooks.addFilter('editor.PostTaxonomyType', 'kapital/custom-term-selector',
  // you should change this
  modifySelector);
})(); // end closure
/******/ })()
;
//# sourceMappingURL=index.js.map