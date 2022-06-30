/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/todoManager.js ***!
  \*************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

// const { default: Echo } = require("laravel-echo")
var todoEls = document.querySelectorAll(".todo-item");

var _iterator = _createForOfIteratorHelper(todoEls),
    _step;

try {
  var _loop = function _loop() {
    var todoEl = _step.value;
    var id = todoEl.getAttribute('id');
    var title = todoEl.querySelector('.container .title *');
    var status = todoEl.querySelector('.container .status *');
    var description = todoEl.querySelector('.container .description *');
    var due = todoEl.querySelector('.container .due *');
    Echo.channel("todo.".concat(id, ".delete")).listen('TodoDeletedEvent', function (e) {
      todoEl.remove();
      console.log('remove', e);
    });
    Echo.channel("todo.".concat(id, ".update")).listen('TodoUpdatedEvent', function (e) {
      todoEl.classList.add('edited-todo-item');
      todoEl.addEventListener("click", function () {
        todoEl.classList.remove('edited-todo-item');
      }, {
        once: true
      });
      title.innerHTML = e.todo.title;
      status.innerHTML = e.todo.status;
      description.innerHTML = e.todo.description;
      due.innerHTML = e.todo.due;
    });
  };

  for (_iterator.s(); !(_step = _iterator.n()).done;) {
    _loop();
  }
} catch (err) {
  _iterator.e(err);
} finally {
  _iterator.f();
}
/******/ })()
;