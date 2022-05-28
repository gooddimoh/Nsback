/* Flickity PACKAGED v2.2.1 */
!function (e, i) {
    "function" == typeof define && define.amd ? define("jquery-bridget/jquery-bridget", ["jquery"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("jquery")) : e.jQueryBridget = i(e, e.jQuery)
}(window, function (t, e) {
    "use strict";
    var i = Array.prototype.slice, n = t.console, d = void 0 === n ? function () {
    } : function (t) {
        n.error(t)
    };

    function s(h, s, c) {
        (c = c || e || t.jQuery) && (s.prototype.option || (s.prototype.option = function (t) {
            c.isPlainObject(t) && (this.options = c.extend(!0, this.options, t))
        }), c.fn[h] = function (t) {
            return "string" == typeof t ? function (t, o, r) {
                var a, l = "$()." + h + '("' + o + '")';
                return t.each(function (t, e) {
                    var i = c.data(e, h);
                    if (i) {
                        var n = i[o];
                        if (n && "_" != o.charAt(0)) {
                            var s = n.apply(i, r);
                            a = void 0 === a ? s : a
                        } else d(l + " is not a valid method")
                    } else d(h + " not initialized. Cannot call methods, i.e. " + l)
                }), void 0 !== a ? a : t
            }(this, t, i.call(arguments, 1)) : (function (t, n) {
                t.each(function (t, e) {
                    var i = c.data(e, h);
                    i ? (i.option(n), i._init()) : (i = new s(e, n), c.data(e, h, i))
                })
            }(this, t), this)
        }, o(c))
    }

    function o(t) {
        !t || t && t.bridget || (t.bridget = s)
    }

    return o(e || t.jQuery), s
}), function (t, e) {
    "function" == typeof define && define.amd ? define("ev-emitter/ev-emitter", e) : "object" == typeof module && module.exports ? module.exports = e() : t.EvEmitter = e()
}("undefined" != typeof window ? window : this, function () {
    function t() {
    }

    var e = t.prototype;
    return e.on = function (t, e) {
        if (t && e) {
            var i = this._events = this._events || {}, n = i[t] = i[t] || [];
            return -1 == n.indexOf(e) && n.push(e), this
        }
    }, e.once = function (t, e) {
        if (t && e) {
            this.on(t, e);
            var i = this._onceEvents = this._onceEvents || {};
            return (i[t] = i[t] || {})[e] = !0, this
        }
    }, e.off = function (t, e) {
        var i = this._events && this._events[t];
        if (i && i.length) {
            var n = i.indexOf(e);
            return -1 != n && i.splice(n, 1), this
        }
    }, e.emitEvent = function (t, e) {
        var i = this._events && this._events[t];
        if (i && i.length) {
            i = i.slice(0), e = e || [];
            for (var n = this._onceEvents && this._onceEvents[t], s = 0; s < i.length; s++) {
                var o = i[s];
                n && n[o] && (this.off(t, o), delete n[o]), o.apply(this, e)
            }
            return this
        }
    }, e.allOff = function () {
        delete this._events, delete this._onceEvents
    }, t
}), function (t, e) {
    "function" == typeof define && define.amd ? define("get-size/get-size", e) : "object" == typeof module && module.exports ? module.exports = e() : t.getSize = e()
}(window, function () {
    "use strict";

    function m(t) {
        var e = parseFloat(t);
        return -1 == t.indexOf("%") && !isNaN(e) && e
    }

    var i = "undefined" == typeof console ? function () {
        } : function (t) {
            console.error(t)
        },
        y = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"],
        b = y.length;

    function E(t) {
        var e = getComputedStyle(t);
        return e || i("Style returned " + e + ". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"), e
    }

    var S, C = !1;

    function x(t) {
        if (function () {
            if (!C) {
                C = !0;
                var t = document.createElement("div");
                t.style.width = "200px", t.style.padding = "1px 2px 3px 4px", t.style.borderStyle = "solid", t.style.borderWidth = "1px 2px 3px 4px", t.style.boxSizing = "border-box";
                var e = document.body || document.documentElement;
                e.appendChild(t);
                var i = E(t);
                S = 200 == Math.round(m(i.width)), x.isBoxSizeOuter = S, e.removeChild(t)
            }
        }(), "string" == typeof t && (t = document.querySelector(t)), t && "object" == typeof t && t.nodeType) {
            var e = E(t);
            if ("none" == e.display) return function () {
                for (var t = {
                    width: 0,
                    height: 0,
                    innerWidth: 0,
                    innerHeight: 0,
                    outerWidth: 0,
                    outerHeight: 0
                }, e = 0; e < b; e++) {
                    t[y[e]] = 0
                }
                return t
            }();
            var i = {};
            i.width = t.offsetWidth, i.height = t.offsetHeight;
            for (var n = i.isBorderBox = "border-box" == e.boxSizing, s = 0; s < b; s++) {
                var o = y[s], r = e[o], a = parseFloat(r);
                i[o] = isNaN(a) ? 0 : a
            }
            var l = i.paddingLeft + i.paddingRight, h = i.paddingTop + i.paddingBottom,
                c = i.marginLeft + i.marginRight, d = i.marginTop + i.marginBottom,
                u = i.borderLeftWidth + i.borderRightWidth, f = i.borderTopWidth + i.borderBottomWidth, p = n && S,
                g = m(e.width);
            !1 !== g && (i.width = g + (p ? 0 : l + u));
            var v = m(e.height);
            return !1 !== v && (i.height = v + (p ? 0 : h + f)), i.innerWidth = i.width - (l + u), i.innerHeight = i.height - (h + f), i.outerWidth = i.width + c, i.outerHeight = i.height + d, i
        }
    }

    return x
}), function (t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define("desandro-matches-selector/matches-selector", e) : "object" == typeof module && module.exports ? module.exports = e() : t.matchesSelector = e()
}(window, function () {
    "use strict";
    var i = function () {
        var t = window.Element.prototype;
        if (t.matches) return "matches";
        if (t.matchesSelector) return "matchesSelector";
        for (var e = ["webkit", "moz", "ms", "o"], i = 0; i < e.length; i++) {
            var n = e[i] + "MatchesSelector";
            if (t[n]) return n
        }
    }();
    return function (t, e) {
        return t[i](e)
    }
}), function (e, i) {
    "function" == typeof define && define.amd ? define("fizzy-ui-utils/utils", ["desandro-matches-selector/matches-selector"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("desandro-matches-selector")) : e.fizzyUIUtils = i(e, e.matchesSelector)
}(window, function (h, o) {
    var c = {
        extend: function (t, e) {
            for (var i in e) t[i] = e[i];
            return t
        }, modulo: function (t, e) {
            return (t % e + e) % e
        }
    }, e = Array.prototype.slice;
    c.makeArray = function (t) {
        return Array.isArray(t) ? t : null == t ? [] : "object" == typeof t && "number" == typeof t.length ? e.call(t) : [t]
    }, c.removeFrom = function (t, e) {
        var i = t.indexOf(e);
        -1 != i && t.splice(i, 1)
    }, c.getParent = function (t, e) {
        for (; t.parentNode && t != document.body;) if (t = t.parentNode, o(t, e)) return t
    }, c.getQueryElement = function (t) {
        return "string" == typeof t ? document.querySelector(t) : t
    }, c.handleEvent = function (t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }, c.filterFindElements = function (t, n) {
        t = c.makeArray(t);
        var s = [];
        return t.forEach(function (t) {
            if (t instanceof HTMLElement) if (n) {
                o(t, n) && s.push(t);
                for (var e = t.querySelectorAll(n), i = 0; i < e.length; i++) s.push(e[i])
            } else s.push(t)
        }), s
    }, c.debounceMethod = function (t, e, n) {
        n = n || 100;
        var s = t.prototype[e], o = e + "Timeout";
        t.prototype[e] = function () {
            var t = this[o];
            clearTimeout(t);
            var e = arguments, i = this;
            this[o] = setTimeout(function () {
                s.apply(i, e), delete i[o]
            }, n)
        }
    }, c.docReady = function (t) {
        var e = document.readyState;
        "complete" == e || "interactive" == e ? setTimeout(t) : document.addEventListener("DOMContentLoaded", t)
    }, c.toDashed = function (t) {
        return t.replace(/(.)([A-Z])/g, function (t, e, i) {
            return e + "-" + i
        }).toLowerCase()
    };
    var d = h.console;
    return c.htmlInit = function (a, l) {
        c.docReady(function () {
            var t = c.toDashed(l), s = "data-" + t, e = document.querySelectorAll("[" + s + "]"),
                i = document.querySelectorAll(".js-" + t), n = c.makeArray(e).concat(c.makeArray(i)),
                o = s + "-options", r = h.jQuery;
            n.forEach(function (e) {
                var t, i = e.getAttribute(s) || e.getAttribute(o);
                try {
                    t = i && JSON.parse(i)
                } catch (t) {
                    return void (d && d.error("Error parsing " + s + " on " + e.className + ": " + t))
                }
                var n = new a(e, t);
                r && r.data(e, l, n)
            })
        })
    }, c
}), function (e, i) {
    "function" == typeof define && define.amd ? define("flickity/js/cell", ["get-size/get-size"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("get-size")) : (e.Flickity = e.Flickity || {}, e.Flickity.Cell = i(e, e.getSize))
}(window, function (t, e) {
    function i(t, e) {
        this.element = t, this.parent = e, this.create()
    }

    var n = i.prototype;
    return n.create = function () {
        this.element.style.position = "absolute", this.element.setAttribute("aria-hidden", "true"), this.x = 0, this.shift = 0
    }, n.destroy = function () {
        this.unselect(), this.element.style.position = "";
        var t = this.parent.originSide;
        this.element.style[t] = ""
    }, n.getSize = function () {
        this.size = e(this.element)
    }, n.setPosition = function (t) {
        this.x = t, this.updateTarget(), this.renderPosition(t)
    }, n.updateTarget = n.setDefaultTarget = function () {
        var t = "left" == this.parent.originSide ? "marginLeft" : "marginRight";
        this.target = this.x + this.size[t] + this.size.width * this.parent.cellAlign
    }, n.renderPosition = function (t) {
        var e = this.parent.originSide;
        this.element.style[e] = this.parent.getPositionValue(t)
    }, n.select = function () {
        this.element.classList.add("is-selected"), this.element.removeAttribute("aria-hidden")
    }, n.unselect = function () {
        this.element.classList.remove("is-selected"), this.element.setAttribute("aria-hidden", "true")
    }, n.wrapShift = function (t) {
        this.shift = t, this.renderPosition(this.x + this.parent.slideableWidth * t)
    }, n.remove = function () {
        this.element.parentNode.removeChild(this.element)
    }, i
}), function (t, e) {
    "function" == typeof define && define.amd ? define("flickity/js/slide", e) : "object" == typeof module && module.exports ? module.exports = e() : (t.Flickity = t.Flickity || {}, t.Flickity.Slide = e())
}(window, function () {
    "use strict";

    function t(t) {
        this.parent = t, this.isOriginLeft = "left" == t.originSide, this.cells = [], this.outerWidth = 0, this.height = 0
    }

    var e = t.prototype;
    return e.addCell = function (t) {
        if (this.cells.push(t), this.outerWidth += t.size.outerWidth, this.height = Math.max(t.size.outerHeight, this.height), 1 == this.cells.length) {
            this.x = t.x;
            var e = this.isOriginLeft ? "marginLeft" : "marginRight";
            this.firstMargin = t.size[e]
        }
    }, e.updateTarget = function () {
        var t = this.isOriginLeft ? "marginRight" : "marginLeft", e = this.getLastCell(), i = e ? e.size[t] : 0,
            n = this.outerWidth - (this.firstMargin + i);
        this.target = this.x + this.firstMargin + n * this.parent.cellAlign
    }, e.getLastCell = function () {
        return this.cells[this.cells.length - 1]
    }, e.select = function () {
        this.cells.forEach(function (t) {
            t.select()
        })
    }, e.unselect = function () {
        this.cells.forEach(function (t) {
            t.unselect()
        })
    }, e.getCellElements = function () {
        return this.cells.map(function (t) {
            return t.element
        })
    }, t
}), function (e, i) {
    "function" == typeof define && define.amd ? define("flickity/js/animate", ["fizzy-ui-utils/utils"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("fizzy-ui-utils")) : (e.Flickity = e.Flickity || {}, e.Flickity.animatePrototype = i(e, e.fizzyUIUtils))
}(window, function (t, e) {
    var i = {
        startAnimation: function () {
            this.isAnimating || (this.isAnimating = !0, this.restingFrames = 0, this.animate())
        }, animate: function () {
            this.applyDragForce(), this.applySelectedAttraction();
            var t = this.x;
            if (this.integratePhysics(), this.positionSlider(), this.settle(t), this.isAnimating) {
                var e = this;
                requestAnimationFrame(function () {
                    e.animate()
                })
            }
        }, positionSlider: function () {
            var t = this.x;
            this.options.wrapAround && 1 < this.cells.length && (t = e.modulo(t, this.slideableWidth), t -= this.slideableWidth, this.shiftWrapCells(t)), this.setTranslateX(t, this.isAnimating), this.dispatchScrollEvent()
        }, setTranslateX: function (t, e) {
            t += this.cursorPosition, t = this.options.rightToLeft ? -t : t;
            var i = this.getPositionValue(t);
            this.slider.style.transform = e ? "translate3d(" + i + ",0,0)" : "translateX(" + i + ")"
        }, dispatchScrollEvent: function () {
            var t = this.slides[0];
            if (t) {
                var e = -this.x - t.target, i = e / this.slidesWidth;
                this.dispatchEvent("scroll", null, [i, e])
            }
        }, positionSliderAtSelected: function () {
            this.cells.length && (this.x = -this.selectedSlide.target, this.velocity = 0, this.positionSlider())
        }, getPositionValue: function (t) {
            return this.options.percentPosition ? .01 * Math.round(t / this.size.innerWidth * 1e4) + "%" : Math.round(t) + "px"
        }, settle: function (t) {
            this.isPointerDown || Math.round(100 * this.x) != Math.round(100 * t) || this.restingFrames++, 2 < this.restingFrames && (this.isAnimating = !1, delete this.isFreeScrolling, this.positionSlider(), this.dispatchEvent("settle", null, [this.selectedIndex]))
        }, shiftWrapCells: function (t) {
            var e = this.cursorPosition + t;
            this._shiftCells(this.beforeShiftCells, e, -1);
            var i = this.size.innerWidth - (t + this.slideableWidth + this.cursorPosition);
            this._shiftCells(this.afterShiftCells, i, 1)
        }, _shiftCells: function (t, e, i) {
            for (var n = 0; n < t.length; n++) {
                var s = t[n], o = 0 < e ? i : 0;
                s.wrapShift(o), e -= s.size.outerWidth
            }
        }, _unshiftCells: function (t) {
            if (t && t.length) for (var e = 0; e < t.length; e++) t[e].wrapShift(0)
        }, integratePhysics: function () {
            this.x += this.velocity, this.velocity *= this.getFrictionFactor()
        }, applyForce: function (t) {
            this.velocity += t
        }, getFrictionFactor: function () {
            return 1 - this.options[this.isFreeScrolling ? "freeScrollFriction" : "friction"]
        }, getRestingPosition: function () {
            return this.x + this.velocity / (1 - this.getFrictionFactor())
        }, applyDragForce: function () {
            if (this.isDraggable && this.isPointerDown) {
                var t = this.dragX - this.x - this.velocity;
                this.applyForce(t)
            }
        }, applySelectedAttraction: function () {
            if (!(this.isDraggable && this.isPointerDown) && !this.isFreeScrolling && this.slides.length) {
                var t = (-1 * this.selectedSlide.target - this.x) * this.options.selectedAttraction;
                this.applyForce(t)
            }
        }
    };
    return i
}), function (r, a) {
    if ("function" == typeof define && define.amd) define("flickity/js/flickity", ["ev-emitter/ev-emitter", "get-size/get-size", "fizzy-ui-utils/utils", "./cell", "./slide", "./animate"], function (t, e, i, n, s, o) {
        return a(r, t, e, i, n, s, o)
    }); else if ("object" == typeof module && module.exports) module.exports = a(r, require("ev-emitter"), require("get-size"), require("fizzy-ui-utils"), require("./cell"), require("./slide"), require("./animate")); else {
        var t = r.Flickity;
        r.Flickity = a(r, r.EvEmitter, r.getSize, r.fizzyUIUtils, t.Cell, t.Slide, t.animatePrototype)
    }
}(window, function (n, t, e, a, i, r, s) {
    var l = n.jQuery, o = n.getComputedStyle, h = n.console;

    function c(t, e) {
        for (t = a.makeArray(t); t.length;) e.appendChild(t.shift())
    }

    var d = 0, u = {};

    function f(t, e) {
        var i = a.getQueryElement(t);
        if (i) {
            if (this.element = i, this.element.flickityGUID) {
                var n = u[this.element.flickityGUID];
                return n.option(e), n
            }
            l && (this.$element = l(this.element)), this.options = a.extend({}, this.constructor.defaults), this.option(e), this._create()
        } else h && h.error("Bad element for Flickity: " + (i || t))
    }

    f.defaults = {
        accessibility: !0,
        cellAlign: "center",
        freeScrollFriction: .075,
        friction: .28,
        namespaceJQueryEvents: !0,
        percentPosition: !0,
        resize: !0,
        selectedAttraction: .025,
        setGallerySize: !0
    }, f.createMethods = [];
    var p = f.prototype;
    a.extend(p, t.prototype), p._create = function () {
        var t = this.guid = ++d;
        for (var e in this.element.flickityGUID = t, (u[t] = this).selectedIndex = 0, this.restingFrames = 0, this.x = 0, this.velocity = 0, this.originSide = this.options.rightToLeft ? "right" : "left", this.viewport = document.createElement("div"), this.viewport.className = "flickity-viewport", this._createSlider(), (this.options.resize || this.options.watchCSS) && n.addEventListener("resize", this), this.options.on) {
            var i = this.options.on[e];
            this.on(e, i)
        }
        f.createMethods.forEach(function (t) {
            this[t]()
        }, this), this.options.watchCSS ? this.watchCSS() : this.activate()
    }, p.option = function (t) {
        a.extend(this.options, t)
    }, p.activate = function () {
        this.isActive || (this.isActive = !0, this.element.classList.add("flickity-enabled"), this.options.rightToLeft && this.element.classList.add("flickity-rtl"), this.getSize(), c(this._filterFindCellElements(this.element.children), this.slider), this.viewport.appendChild(this.slider), this.element.appendChild(this.viewport), this.reloadCells(), this.options.accessibility && (this.element.tabIndex = 0, this.element.addEventListener("keydown", this)), this.emitEvent("activate"), this.selectInitialIndex(), this.isInitActivated = !0, this.dispatchEvent("ready"))
    }, p._createSlider = function () {
        var t = document.createElement("div");
        t.className = "flickity-slider", t.style[this.originSide] = 0, this.slider = t
    }, p._filterFindCellElements = function (t) {
        return a.filterFindElements(t, this.options.cellSelector)
    }, p.reloadCells = function () {
        this.cells = this._makeCells(this.slider.children), this.positionCells(), this._getWrapShiftCells(), this.setGallerySize()
    }, p._makeCells = function (t) {
        return this._filterFindCellElements(t).map(function (t) {
            return new i(t, this)
        }, this)
    }, p.getLastCell = function () {
        return this.cells[this.cells.length - 1]
    }, p.getLastSlide = function () {
        return this.slides[this.slides.length - 1]
    }, p.positionCells = function () {
        this._sizeCells(this.cells), this._positionCells(0)
    }, p._positionCells = function (t) {
        t = t || 0, this.maxCellHeight = t && this.maxCellHeight || 0;
        var e = 0;
        if (0 < t) {
            var i = this.cells[t - 1];
            e = i.x + i.size.outerWidth
        }
        for (var n = this.cells.length, s = t; s < n; s++) {
            var o = this.cells[s];
            o.setPosition(e), e += o.size.outerWidth, this.maxCellHeight = Math.max(o.size.outerHeight, this.maxCellHeight)
        }
        this.slideableWidth = e, this.updateSlides(), this._containSlides(), this.slidesWidth = n ? this.getLastSlide().target - this.slides[0].target : 0
    }, p._sizeCells = function (t) {
        t.forEach(function (t) {
            t.getSize()
        })
    }, p.updateSlides = function () {
        if (this.slides = [], this.cells.length) {
            var n = new r(this);
            this.slides.push(n);
            var s = "left" == this.originSide ? "marginRight" : "marginLeft", o = this._getCanCellFit();
            this.cells.forEach(function (t, e) {
                if (n.cells.length) {
                    var i = n.outerWidth - n.firstMargin + (t.size.outerWidth - t.size[s]);
                    o.call(this, e, i) || (n.updateTarget(), n = new r(this), this.slides.push(n)), n.addCell(t)
                } else n.addCell(t)
            }, this), n.updateTarget(), this.updateSelectedSlide()
        }
    }, p._getCanCellFit = function () {
        var t = this.options.groupCells;
        if (!t) return function () {
            return !1
        };
        if ("number" == typeof t) {
            var e = parseInt(t, 10);
            return function (t) {
                return t % e != 0
            }
        }
        var i = "string" == typeof t && t.match(/^(\d+)%$/), n = i ? parseInt(i[1], 10) / 100 : 1;
        return function (t, e) {
            return e <= (this.size.innerWidth + 1) * n
        }
    }, p._init = p.reposition = function () {
        this.positionCells(), this.positionSliderAtSelected()
    }, p.getSize = function () {
        this.size = e(this.element), this.setCellAlign(), this.cursorPosition = this.size.innerWidth * this.cellAlign
    };
    var g = {center: {left: .5, right: .5}, left: {left: 0, right: 1}, right: {right: 0, left: 1}};
    return p.setCellAlign = function () {
        var t = g[this.options.cellAlign];
        this.cellAlign = t ? t[this.originSide] : this.options.cellAlign
    }, p.setGallerySize = function () {
        if (this.options.setGallerySize) {
            var t = this.options.adaptiveHeight && this.selectedSlide ? this.selectedSlide.height : this.maxCellHeight;
            this.viewport.style.height = t + "px"
        }
    }, p._getWrapShiftCells = function () {
        if (this.options.wrapAround) {
            this._unshiftCells(this.beforeShiftCells), this._unshiftCells(this.afterShiftCells);
            var t = this.cursorPosition, e = this.cells.length - 1;
            this.beforeShiftCells = this._getGapCells(t, e, -1), t = this.size.innerWidth - this.cursorPosition, this.afterShiftCells = this._getGapCells(t, 0, 1)
        }
    }, p._getGapCells = function (t, e, i) {
        for (var n = []; 0 < t;) {
            var s = this.cells[e];
            if (!s) break;
            n.push(s), e += i, t -= s.size.outerWidth
        }
        return n
    }, p._containSlides = function () {
        if (this.options.contain && !this.options.wrapAround && this.cells.length) {
            var t = this.options.rightToLeft, e = t ? "marginRight" : "marginLeft",
                i = t ? "marginLeft" : "marginRight", n = this.slideableWidth - this.getLastCell().size[i],
                s = n < this.size.innerWidth, o = this.cursorPosition + this.cells[0].size[e],
                r = n - this.size.innerWidth * (1 - this.cellAlign);
            this.slides.forEach(function (t) {
                s ? t.target = n * this.cellAlign : (t.target = Math.max(t.target, o), t.target = Math.min(t.target, r))
            }, this)
        }
    }, p.dispatchEvent = function (t, e, i) {
        var n = e ? [e].concat(i) : i;
        if (this.emitEvent(t, n), l && this.$element) {
            var s = t += this.options.namespaceJQueryEvents ? ".flickity" : "";
            if (e) {
                var o = l.Event(e);
                o.type = t, s = o
            }
            this.$element.trigger(s, i)
        }
    }, p.select = function (t, e, i) {
        if (this.isActive && (t = parseInt(t, 10), this._wrapSelect(t), (this.options.wrapAround || e) && (t = a.modulo(t, this.slides.length)), this.slides[t])) {
            var n = this.selectedIndex;
            this.selectedIndex = t, this.updateSelectedSlide(), i ? this.positionSliderAtSelected() : this.startAnimation(), this.options.adaptiveHeight && this.setGallerySize(), this.dispatchEvent("select", null, [t]), t != n && this.dispatchEvent("change", null, [t]), this.dispatchEvent("cellSelect")
        }
    }, p._wrapSelect = function (t) {
        var e = this.slides.length;
        if (!(this.options.wrapAround && 1 < e)) return t;
        var i = a.modulo(t, e), n = Math.abs(i - this.selectedIndex), s = Math.abs(i + e - this.selectedIndex),
            o = Math.abs(i - e - this.selectedIndex);
        !this.isDragSelect && s < n ? t += e : !this.isDragSelect && o < n && (t -= e), t < 0 ? this.x -= this.slideableWidth : e <= t && (this.x += this.slideableWidth)
    }, p.previous = function (t, e) {
        this.select(this.selectedIndex - 1, t, e)
    }, p.next = function (t, e) {
        this.select(this.selectedIndex + 1, t, e)
    }, p.updateSelectedSlide = function () {
        var t = this.slides[this.selectedIndex];
        t && (this.unselectSelectedSlide(), (this.selectedSlide = t).select(), this.selectedCells = t.cells, this.selectedElements = t.getCellElements(), this.selectedCell = t.cells[0], this.selectedElement = this.selectedElements[0])
    }, p.unselectSelectedSlide = function () {
        this.selectedSlide && this.selectedSlide.unselect()
    }, p.selectInitialIndex = function () {
        var t = this.options.initialIndex;
        if (this.isInitActivated) this.select(this.selectedIndex, !1, !0); else {
            if (t && "string" == typeof t) if (this.queryCell(t)) return void this.selectCell(t, !1, !0);
            var e = 0;
            t && this.slides[t] && (e = t), this.select(e, !1, !0)
        }
    }, p.selectCell = function (t, e, i) {
        var n = this.queryCell(t);
        if (n) {
            var s = this.getCellSlideIndex(n);
            this.select(s, e, i)
        }
    }, p.getCellSlideIndex = function (t) {
        for (var e = 0; e < this.slides.length; e++) {
            if (-1 != this.slides[e].cells.indexOf(t)) return e
        }
    }, p.getCell = function (t) {
        for (var e = 0; e < this.cells.length; e++) {
            var i = this.cells[e];
            if (i.element == t) return i
        }
    }, p.getCells = function (t) {
        t = a.makeArray(t);
        var i = [];
        return t.forEach(function (t) {
            var e = this.getCell(t);
            e && i.push(e)
        }, this), i
    }, p.getCellElements = function () {
        return this.cells.map(function (t) {
            return t.element
        })
    }, p.getParentCell = function (t) {
        var e = this.getCell(t);
        return e || (t = a.getParent(t, ".flickity-slider > *"), this.getCell(t))
    }, p.getAdjacentCellElements = function (t, e) {
        if (!t) return this.selectedSlide.getCellElements();
        e = void 0 === e ? this.selectedIndex : e;
        var i = this.slides.length;
        if (i <= 1 + 2 * t) return this.getCellElements();
        for (var n = [], s = e - t; s <= e + t; s++) {
            var o = this.options.wrapAround ? a.modulo(s, i) : s, r = this.slides[o];
            r && (n = n.concat(r.getCellElements()))
        }
        return n
    }, p.queryCell = function (t) {
        if ("number" == typeof t) return this.cells[t];
        if ("string" == typeof t) {
            if (t.match(/^[#\.]?[\d\/]/)) return;
            t = this.element.querySelector(t)
        }
        return this.getCell(t)
    }, p.uiChange = function () {
        this.emitEvent("uiChange")
    }, p.childUIPointerDown = function (t) {
        "touchstart" != t.type && t.preventDefault(), this.focus()
    }, p.onresize = function () {
        this.watchCSS(), this.resize()
    }, a.debounceMethod(f, "onresize", 150), p.resize = function () {
        if (this.isActive) {
            this.getSize(), this.options.wrapAround && (this.x = a.modulo(this.x, this.slideableWidth)), this.positionCells(), this._getWrapShiftCells(), this.setGallerySize(), this.emitEvent("resize");
            var t = this.selectedElements && this.selectedElements[0];
            this.selectCell(t, !1, !0)
        }
    }, p.watchCSS = function () {
        this.options.watchCSS && (-1 != o(this.element, ":after").content.indexOf("flickity") ? this.activate() : this.deactivate())
    }, p.onkeydown = function (t) {
        var e = document.activeElement && document.activeElement != this.element;
        if (this.options.accessibility && !e) {
            var i = f.keyboardHandlers[t.keyCode];
            i && i.call(this)
        }
    }, f.keyboardHandlers = {
        37: function () {
            var t = this.options.rightToLeft ? "next" : "previous";
            this.uiChange(), this[t]()
        }, 39: function () {
            var t = this.options.rightToLeft ? "previous" : "next";
            this.uiChange(), this[t]()
        }
    }, p.focus = function () {
        var t = n.pageYOffset;
        this.element.focus({preventScroll: !0}), n.pageYOffset != t && n.scrollTo(n.pageXOffset, t)
    }, p.deactivate = function () {
        this.isActive && (this.element.classList.remove("flickity-enabled"), this.element.classList.remove("flickity-rtl"), this.unselectSelectedSlide(), this.cells.forEach(function (t) {
            t.destroy()
        }), this.element.removeChild(this.viewport), c(this.slider.children, this.element), this.options.accessibility && (this.element.removeAttribute("tabIndex"), this.element.removeEventListener("keydown", this)), this.isActive = !1, this.emitEvent("deactivate"))
    }, p.destroy = function () {
        this.deactivate(), n.removeEventListener("resize", this), this.allOff(), this.emitEvent("destroy"), l && this.$element && l.removeData(this.element, "flickity"), delete this.element.flickityGUID, delete u[this.guid]
    }, a.extend(p, s), f.data = function (t) {
        var e = (t = a.getQueryElement(t)) && t.flickityGUID;
        return e && u[e]
    }, a.htmlInit(f, "flickity"), l && l.bridget && l.bridget("flickity", f), f.setJQuery = function (t) {
        l = t
    }, f.Cell = i, f.Slide = r, f
}), function (e, i) {
    "function" == typeof define && define.amd ? define("unipointer/unipointer", ["ev-emitter/ev-emitter"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("ev-emitter")) : e.Unipointer = i(e, e.EvEmitter)
}(window, function (s, t) {
    function e() {
    }

    var i = e.prototype = Object.create(t.prototype);
    i.bindStartEvent = function (t) {
        this._bindStartEvent(t, !0)
    }, i.unbindStartEvent = function (t) {
        this._bindStartEvent(t, !1)
    }, i._bindStartEvent = function (t, e) {
        var i = (e = void 0 === e || e) ? "addEventListener" : "removeEventListener", n = "mousedown";
        s.PointerEvent ? n = "pointerdown" : "ontouchstart" in s && (n = "touchstart"), t[i](n, this)
    }, i.handleEvent = function (t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }, i.getTouch = function (t) {
        for (var e = 0; e < t.length; e++) {
            var i = t[e];
            if (i.identifier == this.pointerIdentifier) return i
        }
    }, i.onmousedown = function (t) {
        var e = t.button;
        e && 0 !== e && 1 !== e || this._pointerDown(t, t)
    }, i.ontouchstart = function (t) {
        this._pointerDown(t, t.changedTouches[0])
    }, i.onpointerdown = function (t) {
        this._pointerDown(t, t)
    }, i._pointerDown = function (t, e) {
        t.button || this.isPointerDown || (this.isPointerDown = !0, this.pointerIdentifier = void 0 !== e.pointerId ? e.pointerId : e.identifier, this.pointerDown(t, e))
    }, i.pointerDown = function (t, e) {
        this._bindPostStartEvents(t), this.emitEvent("pointerDown", [t, e])
    };
    var n = {
        mousedown: ["mousemove", "mouseup"],
        touchstart: ["touchmove", "touchend", "touchcancel"],
        pointerdown: ["pointermove", "pointerup", "pointercancel"]
    };
    return i._bindPostStartEvents = function (t) {
        if (t) {
            var e = n[t.type];
            e.forEach(function (t) {
                s.addEventListener(t, this)
            }, this), this._boundPointerEvents = e
        }
    }, i._unbindPostStartEvents = function () {
        this._boundPointerEvents && (this._boundPointerEvents.forEach(function (t) {
            s.removeEventListener(t, this)
        }, this), delete this._boundPointerEvents)
    }, i.onmousemove = function (t) {
        this._pointerMove(t, t)
    }, i.onpointermove = function (t) {
        t.pointerId == this.pointerIdentifier && this._pointerMove(t, t)
    }, i.ontouchmove = function (t) {
        var e = this.getTouch(t.changedTouches);
        e && this._pointerMove(t, e)
    }, i._pointerMove = function (t, e) {
        this.pointerMove(t, e)
    }, i.pointerMove = function (t, e) {
        this.emitEvent("pointerMove", [t, e])
    }, i.onmouseup = function (t) {
        this._pointerUp(t, t)
    }, i.onpointerup = function (t) {
        t.pointerId == this.pointerIdentifier && this._pointerUp(t, t)
    }, i.ontouchend = function (t) {
        var e = this.getTouch(t.changedTouches);
        e && this._pointerUp(t, e)
    }, i._pointerUp = function (t, e) {
        this._pointerDone(), this.pointerUp(t, e)
    }, i.pointerUp = function (t, e) {
        this.emitEvent("pointerUp", [t, e])
    }, i._pointerDone = function () {
        this._pointerReset(), this._unbindPostStartEvents(), this.pointerDone()
    }, i._pointerReset = function () {
        this.isPointerDown = !1, delete this.pointerIdentifier
    }, i.pointerDone = function () {
    }, i.onpointercancel = function (t) {
        t.pointerId == this.pointerIdentifier && this._pointerCancel(t, t)
    }, i.ontouchcancel = function (t) {
        var e = this.getTouch(t.changedTouches);
        e && this._pointerCancel(t, e)
    }, i._pointerCancel = function (t, e) {
        this._pointerDone(), this.pointerCancel(t, e)
    }, i.pointerCancel = function (t, e) {
        this.emitEvent("pointerCancel", [t, e])
    }, e.getPointerPoint = function (t) {
        return {x: t.pageX, y: t.pageY}
    }, e
}), function (e, i) {
    "function" == typeof define && define.amd ? define("unidragger/unidragger", ["unipointer/unipointer"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("unipointer")) : e.Unidragger = i(e, e.Unipointer)
}(window, function (o, t) {
    function e() {
    }

    var i = e.prototype = Object.create(t.prototype);
    i.bindHandles = function () {
        this._bindHandles(!0)
    }, i.unbindHandles = function () {
        this._bindHandles(!1)
    }, i._bindHandles = function (t) {
        for (var e = (t = void 0 === t || t) ? "addEventListener" : "removeEventListener", i = t ? this._touchActionValue : "", n = 0; n < this.handles.length; n++) {
            var s = this.handles[n];
            this._bindStartEvent(s, t), s[e]("click", this), o.PointerEvent && (s.style.touchAction = i)
        }
    }, i._touchActionValue = "none", i.pointerDown = function (t, e) {
        this.okayPointerDown(t) && (this.pointerDownPointer = e, t.preventDefault(), this.pointerDownBlur(), this._bindPostStartEvents(t), this.emitEvent("pointerDown", [t, e]))
    };
    var s = {TEXTAREA: !0, INPUT: !0, SELECT: !0, OPTION: !0},
        r = {radio: !0, checkbox: !0, button: !0, submit: !0, image: !0, file: !0};
    return i.okayPointerDown = function (t) {
        var e = s[t.target.nodeName], i = r[t.target.type], n = !e || i;
        return n || this._pointerReset(), n
    }, i.pointerDownBlur = function () {
        var t = document.activeElement;
        t && t.blur && t != document.body && t.blur()
    }, i.pointerMove = function (t, e) {
        var i = this._dragPointerMove(t, e);
        this.emitEvent("pointerMove", [t, e, i]), this._dragMove(t, e, i)
    }, i._dragPointerMove = function (t, e) {
        var i = {x: e.pageX - this.pointerDownPointer.pageX, y: e.pageY - this.pointerDownPointer.pageY};
        return !this.isDragging && this.hasDragStarted(i) && this._dragStart(t, e), i
    }, i.hasDragStarted = function (t) {
        return 3 < Math.abs(t.x) || 3 < Math.abs(t.y)
    }, i.pointerUp = function (t, e) {
        this.emitEvent("pointerUp", [t, e]), this._dragPointerUp(t, e)
    }, i._dragPointerUp = function (t, e) {
        this.isDragging ? this._dragEnd(t, e) : this._staticClick(t, e)
    }, i._dragStart = function (t, e) {
        this.isDragging = !0, this.isPreventingClicks = !0, this.dragStart(t, e)
    }, i.dragStart = function (t, e) {
        this.emitEvent("dragStart", [t, e])
    }, i._dragMove = function (t, e, i) {
        this.isDragging && this.dragMove(t, e, i)
    }, i.dragMove = function (t, e, i) {
        t.preventDefault(), this.emitEvent("dragMove", [t, e, i])
    }, i._dragEnd = function (t, e) {
        this.isDragging = !1, setTimeout(function () {
            delete this.isPreventingClicks
        }.bind(this)), this.dragEnd(t, e)
    }, i.dragEnd = function (t, e) {
        this.emitEvent("dragEnd", [t, e])
    }, i.onclick = function (t) {
        this.isPreventingClicks && t.preventDefault()
    }, i._staticClick = function (t, e) {
        this.isIgnoringMouseUp && "mouseup" == t.type || (this.staticClick(t, e), "mouseup" != t.type && (this.isIgnoringMouseUp = !0, setTimeout(function () {
            delete this.isIgnoringMouseUp
        }.bind(this), 400)))
    }, i.staticClick = function (t, e) {
        this.emitEvent("staticClick", [t, e])
    }, e.getPointerPoint = t.getPointerPoint, e
}), function (n, s) {
    "function" == typeof define && define.amd ? define("flickity/js/drag", ["./flickity", "unidragger/unidragger", "fizzy-ui-utils/utils"], function (t, e, i) {
        return s(n, t, e, i)
    }) : "object" == typeof module && module.exports ? module.exports = s(n, require("./flickity"), require("unidragger"), require("fizzy-ui-utils")) : n.Flickity = s(n, n.Flickity, n.Unidragger, n.fizzyUIUtils)
}(window, function (i, t, e, a) {
    a.extend(t.defaults, {draggable: ">1", dragThreshold: 3}), t.createMethods.push("_createDrag");
    var n = t.prototype;
    a.extend(n, e.prototype), n._touchActionValue = "pan-y";
    var s = "createTouch" in document, o = !1;
    n._createDrag = function () {
        this.on("activate", this.onActivateDrag), this.on("uiChange", this._uiChangeDrag), this.on("deactivate", this.onDeactivateDrag), this.on("cellChange", this.updateDraggable), s && !o && (i.addEventListener("touchmove", function () {
        }), o = !0)
    }, n.onActivateDrag = function () {
        this.handles = [this.viewport], this.bindHandles(), this.updateDraggable()
    }, n.onDeactivateDrag = function () {
        this.unbindHandles(), this.element.classList.remove("is-draggable")
    }, n.updateDraggable = function () {
        ">1" == this.options.draggable ? this.isDraggable = 1 < this.slides.length : this.isDraggable = this.options.draggable, this.isDraggable ? this.element.classList.add("is-draggable") : this.element.classList.remove("is-draggable")
    }, n.bindDrag = function () {
        this.options.draggable = !0, this.updateDraggable()
    }, n.unbindDrag = function () {
        this.options.draggable = !1, this.updateDraggable()
    }, n._uiChangeDrag = function () {
        delete this.isFreeScrolling
    }, n.pointerDown = function (t, e) {
        this.isDraggable ? this.okayPointerDown(t) && (this._pointerDownPreventDefault(t), this.pointerDownFocus(t), document.activeElement != this.element && this.pointerDownBlur(), this.dragX = this.x, this.viewport.classList.add("is-pointer-down"), this.pointerDownScroll = l(), i.addEventListener("scroll", this), this._pointerDownDefault(t, e)) : this._pointerDownDefault(t, e)
    }, n._pointerDownDefault = function (t, e) {
        this.pointerDownPointer = {
            pageX: e.pageX,
            pageY: e.pageY
        }, this._bindPostStartEvents(t), this.dispatchEvent("pointerDown", t, [e])
    };
    var r = {INPUT: !0, TEXTAREA: !0, SELECT: !0};

    function l() {
        return {x: i.pageXOffset, y: i.pageYOffset}
    }

    return n.pointerDownFocus = function (t) {
        r[t.target.nodeName] || this.focus()
    }, n._pointerDownPreventDefault = function (t) {
        var e = "touchstart" == t.type, i = "touch" == t.pointerType, n = r[t.target.nodeName];
        e || i || n || t.preventDefault()
    }, n.hasDragStarted = function (t) {
        return Math.abs(t.x) > this.options.dragThreshold
    }, n.pointerUp = function (t, e) {
        delete this.isTouchScrolling, this.viewport.classList.remove("is-pointer-down"), this.dispatchEvent("pointerUp", t, [e]), this._dragPointerUp(t, e)
    }, n.pointerDone = function () {
        i.removeEventListener("scroll", this), delete this.pointerDownScroll
    }, n.dragStart = function (t, e) {
        this.isDraggable && (this.dragStartPosition = this.x, this.startAnimation(), i.removeEventListener("scroll", this), this.dispatchEvent("dragStart", t, [e]))
    }, n.pointerMove = function (t, e) {
        var i = this._dragPointerMove(t, e);
        this.dispatchEvent("pointerMove", t, [e, i]), this._dragMove(t, e, i)
    }, n.dragMove = function (t, e, i) {
        if (this.isDraggable) {
            t.preventDefault(), this.previousDragX = this.dragX;
            var n = this.options.rightToLeft ? -1 : 1;
            this.options.wrapAround && (i.x = i.x % this.slideableWidth);
            var s = this.dragStartPosition + i.x * n;
            if (!this.options.wrapAround && this.slides.length) {
                var o = Math.max(-this.slides[0].target, this.dragStartPosition);
                s = o < s ? .5 * (s + o) : s;
                var r = Math.min(-this.getLastSlide().target, this.dragStartPosition);
                s = s < r ? .5 * (s + r) : s
            }
            this.dragX = s, this.dragMoveTime = new Date, this.dispatchEvent("dragMove", t, [e, i])
        }
    }, n.dragEnd = function (t, e) {
        if (this.isDraggable) {
            this.options.freeScroll && (this.isFreeScrolling = !0);
            var i = this.dragEndRestingSelect();
            if (this.options.freeScroll && !this.options.wrapAround) {
                var n = this.getRestingPosition();
                this.isFreeScrolling = -n > this.slides[0].target && -n < this.getLastSlide().target
            } else this.options.freeScroll || i != this.selectedIndex || (i += this.dragEndBoostSelect());
            delete this.previousDragX, this.isDragSelect = this.options.wrapAround, this.select(i), delete this.isDragSelect, this.dispatchEvent("dragEnd", t, [e])
        }
    }, n.dragEndRestingSelect = function () {
        var t = this.getRestingPosition(), e = Math.abs(this.getSlideDistance(-t, this.selectedIndex)),
            i = this._getClosestResting(t, e, 1), n = this._getClosestResting(t, e, -1);
        return i.distance < n.distance ? i.index : n.index
    }, n._getClosestResting = function (t, e, i) {
        for (var n = this.selectedIndex, s = 1 / 0, o = this.options.contain && !this.options.wrapAround ? function (t, e) {
            return t <= e
        } : function (t, e) {
            return t < e
        }; o(e, s) && (n += i, s = e, null !== (e = this.getSlideDistance(-t, n)));) e = Math.abs(e);
        return {distance: s, index: n - i}
    }, n.getSlideDistance = function (t, e) {
        var i = this.slides.length, n = this.options.wrapAround && 1 < i, s = n ? a.modulo(e, i) : e,
            o = this.slides[s];
        if (!o) return null;
        var r = n ? this.slideableWidth * Math.floor(e / i) : 0;
        return t - (o.target + r)
    }, n.dragEndBoostSelect = function () {
        if (void 0 === this.previousDragX || !this.dragMoveTime || 100 < new Date - this.dragMoveTime) return 0;
        var t = this.getSlideDistance(-this.dragX, this.selectedIndex), e = this.previousDragX - this.dragX;
        return 0 < t && 0 < e ? 1 : t < 0 && e < 0 ? -1 : 0
    }, n.staticClick = function (t, e) {
        var i = this.getParentCell(t.target), n = i && i.element, s = i && this.cells.indexOf(i);
        this.dispatchEvent("staticClick", t, [e, n, s])
    }, n.onscroll = function () {
        var t = l(), e = this.pointerDownScroll.x - t.x, i = this.pointerDownScroll.y - t.y;
        (3 < Math.abs(e) || 3 < Math.abs(i)) && this._pointerDone()
    }, t
}), function (n, s) {
    "function" == typeof define && define.amd ? define("flickity/js/prev-next-button", ["./flickity", "unipointer/unipointer", "fizzy-ui-utils/utils"], function (t, e, i) {
        return s(n, t, e, i)
    }) : "object" == typeof module && module.exports ? module.exports = s(n, require("./flickity"), require("unipointer"), require("fizzy-ui-utils")) : s(n, n.Flickity, n.Unipointer, n.fizzyUIUtils)
}(window, function (t, e, i, n) {
    "use strict";
    var s = "http://www.w3.org/2000/svg";

    function o(t, e) {
        this.direction = t, this.parent = e, this._create()
    }

    (o.prototype = Object.create(i.prototype))._create = function () {
        this.isEnabled = !0, this.isPrevious = -1 == this.direction;
        var t = this.parent.options.rightToLeft ? 1 : -1;
        this.isLeft = this.direction == t;
        var e = this.element = document.createElement("button");
        e.className = "flickity-button flickity-prev-next-button", e.className += this.isPrevious ? " previous" : " next", e.setAttribute("type", "button"), this.disable(), e.setAttribute("aria-label", this.isPrevious ? "Previous" : "Next");
        var i = this.createSVG();
        e.appendChild(i), this.parent.on("select", this.update.bind(this)), this.on("pointerDown", this.parent.childUIPointerDown.bind(this.parent))
    }, o.prototype.activate = function () {
        this.bindStartEvent(this.element), this.element.addEventListener("click", this), this.parent.element.appendChild(this.element)
    }, o.prototype.deactivate = function () {
        this.parent.element.removeChild(this.element), this.unbindStartEvent(this.element), this.element.removeEventListener("click", this)
    }, o.prototype.createSVG = function () {
        var t = document.createElementNS(s, "svg");
        t.setAttribute("class", "flickity-button-icon"), t.setAttribute("viewBox", "0 0 100 100");
        var e = document.createElementNS(s, "path"), i = function (t) {
            return "string" != typeof t ? "M " + t.x0 + ",50 L " + t.x1 + "," + (t.y1 + 50) + " L " + t.x2 + "," + (t.y2 + 50) + " L " + t.x3 + ",50  L " + t.x2 + "," + (50 - t.y2) + " L " + t.x1 + "," + (50 - t.y1) + " Z" : t
        }(this.parent.options.arrowShape);
        return e.setAttribute("d", i), e.setAttribute("class", "arrow"), this.isLeft || e.setAttribute("transform", "translate(100, 100) rotate(180) "), t.appendChild(e), t
    }, o.prototype.handleEvent = n.handleEvent, o.prototype.onclick = function () {
        if (this.isEnabled) {
            this.parent.uiChange();
            var t = this.isPrevious ? "previous" : "next";
            this.parent[t]()
        }
    }, o.prototype.enable = function () {
        this.isEnabled || (this.element.disabled = !1, this.isEnabled = !0)
    }, o.prototype.disable = function () {
        this.isEnabled && (this.element.disabled = !0, this.isEnabled = !1)
    }, o.prototype.update = function () {
        var t = this.parent.slides;
        if (this.parent.options.wrapAround && 1 < t.length) this.enable(); else {
            var e = t.length ? t.length - 1 : 0, i = this.isPrevious ? 0 : e;
            this[this.parent.selectedIndex == i ? "disable" : "enable"]()
        }
    }, o.prototype.destroy = function () {
        this.deactivate(), this.allOff()
    }, n.extend(e.defaults, {
        prevNextButtons: !0,
        arrowShape: {x0: 10, x1: 60, y1: 50, x2: 70, y2: 40, x3: 30}
    }), e.createMethods.push("_createPrevNextButtons");
    var r = e.prototype;
    return r._createPrevNextButtons = function () {
        this.options.prevNextButtons && (this.prevButton = new o(-1, this), this.nextButton = new o(1, this), this.on("activate", this.activatePrevNextButtons))
    }, r.activatePrevNextButtons = function () {
        this.prevButton.activate(), this.nextButton.activate(), this.on("deactivate", this.deactivatePrevNextButtons)
    }, r.deactivatePrevNextButtons = function () {
        this.prevButton.deactivate(), this.nextButton.deactivate(), this.off("deactivate", this.deactivatePrevNextButtons)
    }, e.PrevNextButton = o, e
}), function (n, s) {
    "function" == typeof define && define.amd ? define("flickity/js/page-dots", ["./flickity", "unipointer/unipointer", "fizzy-ui-utils/utils"], function (t, e, i) {
        return s(n, t, e, i)
    }) : "object" == typeof module && module.exports ? module.exports = s(n, require("./flickity"), require("unipointer"), require("fizzy-ui-utils")) : s(n, n.Flickity, n.Unipointer, n.fizzyUIUtils)
}(window, function (t, e, i, n) {
    function s(t) {
        this.parent = t, this._create()
    }

    (s.prototype = Object.create(i.prototype))._create = function () {
        this.holder = document.createElement("ol"), this.holder.className = "flickity-page-dots", this.dots = [], this.handleClick = this.onClick.bind(this), this.on("pointerDown", this.parent.childUIPointerDown.bind(this.parent))
    }, s.prototype.activate = function () {
        this.setDots(), this.holder.addEventListener("click", this.handleClick), this.bindStartEvent(this.holder), this.parent.element.appendChild(this.holder)
    }, s.prototype.deactivate = function () {
        this.holder.removeEventListener("click", this.handleClick), this.unbindStartEvent(this.holder), this.parent.element.removeChild(this.holder)
    }, s.prototype.setDots = function () {
        var t = this.parent.slides.length - this.dots.length;
        0 < t ? this.addDots(t) : t < 0 && this.removeDots(-t)
    }, s.prototype.addDots = function (t) {
        for (var e = document.createDocumentFragment(), i = [], n = this.dots.length, s = n + t, o = n; o < s; o++) {
            var r = document.createElement("li");
            r.className = "dot", r.setAttribute("aria-label", "Page dot " + (o + 1)), e.appendChild(r), i.push(r)
        }
        this.holder.appendChild(e), this.dots = this.dots.concat(i)
    }, s.prototype.removeDots = function (t) {
        this.dots.splice(this.dots.length - t, t).forEach(function (t) {
            this.holder.removeChild(t)
        }, this)
    }, s.prototype.updateSelected = function () {
        this.selectedDot && (this.selectedDot.className = "dot", this.selectedDot.removeAttribute("aria-current")), this.dots.length && (this.selectedDot = this.dots[this.parent.selectedIndex], this.selectedDot.className = "dot is-selected", this.selectedDot.setAttribute("aria-current", "step"))
    }, s.prototype.onTap = s.prototype.onClick = function (t) {
        var e = t.target;
        if ("LI" == e.nodeName) {
            this.parent.uiChange();
            var i = this.dots.indexOf(e);
            this.parent.select(i)
        }
    }, s.prototype.destroy = function () {
        this.deactivate(), this.allOff()
    }, e.PageDots = s, n.extend(e.defaults, {pageDots: !0}), e.createMethods.push("_createPageDots");
    var o = e.prototype;
    return o._createPageDots = function () {
        this.options.pageDots && (this.pageDots = new s(this), this.on("activate", this.activatePageDots), this.on("select", this.updateSelectedPageDots), this.on("cellChange", this.updatePageDots), this.on("resize", this.updatePageDots), this.on("deactivate", this.deactivatePageDots))
    }, o.activatePageDots = function () {
        this.pageDots.activate()
    }, o.updateSelectedPageDots = function () {
        this.pageDots.updateSelected()
    }, o.updatePageDots = function () {
        this.pageDots.setDots()
    }, o.deactivatePageDots = function () {
        this.pageDots.deactivate()
    }, e.PageDots = s, e
}), function (t, n) {
    "function" == typeof define && define.amd ? define("flickity/js/player", ["ev-emitter/ev-emitter", "fizzy-ui-utils/utils", "./flickity"], function (t, e, i) {
        return n(t, e, i)
    }) : "object" == typeof module && module.exports ? module.exports = n(require("ev-emitter"), require("fizzy-ui-utils"), require("./flickity")) : n(t.EvEmitter, t.fizzyUIUtils, t.Flickity)
}(window, function (t, e, i) {
    function n(t) {
        this.parent = t, this.state = "stopped", this.onVisibilityChange = this.visibilityChange.bind(this), this.onVisibilityPlay = this.visibilityPlay.bind(this)
    }

    (n.prototype = Object.create(t.prototype)).play = function () {
        "playing" != this.state && (document.hidden ? document.addEventListener("visibilitychange", this.onVisibilityPlay) : (this.state = "playing", document.addEventListener("visibilitychange", this.onVisibilityChange), this.tick()))
    }, n.prototype.tick = function () {
        if ("playing" == this.state) {
            var t = this.parent.options.autoPlay;
            t = "number" == typeof t ? t : 3e3;
            var e = this;
            this.clear(), this.timeout = setTimeout(function () {
                e.parent.next(!0), e.tick()
            }, t)
        }
    }, n.prototype.stop = function () {
        this.state = "stopped", this.clear(), document.removeEventListener("visibilitychange", this.onVisibilityChange)
    }, n.prototype.clear = function () {
        clearTimeout(this.timeout)
    }, n.prototype.pause = function () {
        "playing" == this.state && (this.state = "paused", this.clear())
    }, n.prototype.unpause = function () {
        "paused" == this.state && this.play()
    }, n.prototype.visibilityChange = function () {
        this[document.hidden ? "pause" : "unpause"]()
    }, n.prototype.visibilityPlay = function () {
        this.play(), document.removeEventListener("visibilitychange", this.onVisibilityPlay)
    }, e.extend(i.defaults, {pauseAutoPlayOnHover: !0}), i.createMethods.push("_createPlayer");
    var s = i.prototype;
    return s._createPlayer = function () {
        this.player = new n(this), this.on("activate", this.activatePlayer), this.on("uiChange", this.stopPlayer), this.on("pointerDown", this.stopPlayer), this.on("deactivate", this.deactivatePlayer)
    }, s.activatePlayer = function () {
        this.options.autoPlay && (this.player.play(), this.element.addEventListener("mouseenter", this))
    }, s.playPlayer = function () {
        this.player.play()
    }, s.stopPlayer = function () {
        this.player.stop()
    }, s.pausePlayer = function () {
        this.player.pause()
    }, s.unpausePlayer = function () {
        this.player.unpause()
    }, s.deactivatePlayer = function () {
        this.player.stop(), this.element.removeEventListener("mouseenter", this)
    }, s.onmouseenter = function () {
        this.options.pauseAutoPlayOnHover && (this.player.pause(), this.element.addEventListener("mouseleave", this))
    }, s.onmouseleave = function () {
        this.player.unpause(), this.element.removeEventListener("mouseleave", this)
    }, i.Player = n, i
}), function (i, n) {
    "function" == typeof define && define.amd ? define("flickity/js/add-remove-cell", ["./flickity", "fizzy-ui-utils/utils"], function (t, e) {
        return n(i, t, e)
    }) : "object" == typeof module && module.exports ? module.exports = n(i, require("./flickity"), require("fizzy-ui-utils")) : n(i, i.Flickity, i.fizzyUIUtils)
}(window, function (t, e, n) {
    var i = e.prototype;
    return i.insert = function (t, e) {
        var i = this._makeCells(t);
        if (i && i.length) {
            var n = this.cells.length;
            e = void 0 === e ? n : e;
            var s = function (t) {
                var e = document.createDocumentFragment();
                return t.forEach(function (t) {
                    e.appendChild(t.element)
                }), e
            }(i), o = e == n;
            if (o) this.slider.appendChild(s); else {
                var r = this.cells[e].element;
                this.slider.insertBefore(s, r)
            }
            if (0 === e) this.cells = i.concat(this.cells); else if (o) this.cells = this.cells.concat(i); else {
                var a = this.cells.splice(e, n - e);
                this.cells = this.cells.concat(i).concat(a)
            }
            this._sizeCells(i), this.cellChange(e, !0)
        }
    }, i.append = function (t) {
        this.insert(t, this.cells.length)
    }, i.prepend = function (t) {
        this.insert(t, 0)
    }, i.remove = function (t) {
        var e = this.getCells(t);
        if (e && e.length) {
            var i = this.cells.length - 1;
            e.forEach(function (t) {
                t.remove();
                var e = this.cells.indexOf(t);
                i = Math.min(e, i), n.removeFrom(this.cells, t)
            }, this), this.cellChange(i, !0)
        }
    }, i.cellSizeChange = function (t) {
        var e = this.getCell(t);
        if (e) {
            e.getSize();
            var i = this.cells.indexOf(e);
            this.cellChange(i)
        }
    }, i.cellChange = function (t, e) {
        var i = this.selectedElement;
        this._positionCells(t), this._getWrapShiftCells(), this.setGallerySize();
        var n = this.getCell(i);
        n && (this.selectedIndex = this.getCellSlideIndex(n)), this.selectedIndex = Math.min(this.slides.length - 1, this.selectedIndex), this.emitEvent("cellChange", [t]), this.select(this.selectedIndex), e && this.positionSliderAtSelected()
    }, e
}), function (i, n) {
    "function" == typeof define && define.amd ? define("flickity/js/lazyload", ["./flickity", "fizzy-ui-utils/utils"], function (t, e) {
        return n(i, t, e)
    }) : "object" == typeof module && module.exports ? module.exports = n(i, require("./flickity"), require("fizzy-ui-utils")) : n(i, i.Flickity, i.fizzyUIUtils)
}(window, function (t, e, o) {
    "use strict";
    e.createMethods.push("_createLazyload");
    var i = e.prototype;

    function s(t, e) {
        this.img = t, this.flickity = e, this.load()
    }

    return i._createLazyload = function () {
        this.on("select", this.lazyLoad)
    }, i.lazyLoad = function () {
        var t = this.options.lazyLoad;
        if (t) {
            var e = "number" == typeof t ? t : 0, i = this.getAdjacentCellElements(e), n = [];
            i.forEach(function (t) {
                var e = function (t) {
                    if ("IMG" == t.nodeName) {
                        var e = t.getAttribute("data-flickity-lazyload"),
                            i = t.getAttribute("data-flickity-lazyload-src"),
                            n = t.getAttribute("data-flickity-lazyload-srcset");
                        if (e || i || n) return [t]
                    }
                    var s = t.querySelectorAll("img[data-flickity-lazyload], img[data-flickity-lazyload-src], img[data-flickity-lazyload-srcset]");
                    return o.makeArray(s)
                }(t);
                n = n.concat(e)
            }), n.forEach(function (t) {
                new s(t, this)
            }, this)
        }
    }, s.prototype.handleEvent = o.handleEvent, s.prototype.load = function () {
        this.img.addEventListener("load", this), this.img.addEventListener("error", this);
        var t = this.img.getAttribute("data-flickity-lazyload") || this.img.getAttribute("data-flickity-lazyload-src"),
            e = this.img.getAttribute("data-flickity-lazyload-srcset");
        this.img.src = t, e && this.img.setAttribute("srcset", e), this.img.removeAttribute("data-flickity-lazyload"), this.img.removeAttribute("data-flickity-lazyload-src"), this.img.removeAttribute("data-flickity-lazyload-srcset")
    }, s.prototype.onload = function (t) {
        this.complete(t, "flickity-lazyloaded")
    }, s.prototype.onerror = function (t) {
        this.complete(t, "flickity-lazyerror")
    }, s.prototype.complete = function (t, e) {
        this.img.removeEventListener("load", this), this.img.removeEventListener("error", this);
        var i = this.flickity.getParentCell(this.img), n = i && i.element;
        this.flickity.cellSizeChange(n), this.img.classList.add(e), this.flickity.dispatchEvent("lazyLoad", t, n)
    }, e.LazyLoader = s, e
}), function (t, e) {
    "function" == typeof define && define.amd ? define("flickity/js/index", ["./flickity", "./drag", "./prev-next-button", "./page-dots", "./player", "./add-remove-cell", "./lazyload"], e) : "object" == typeof module && module.exports && (module.exports = e(require("./flickity"), require("./drag"), require("./prev-next-button"), require("./page-dots"), require("./player"), require("./add-remove-cell"), require("./lazyload")))
}(window, function (t) {
    return t
}), function (t, e) {
    "function" == typeof define && define.amd ? define("flickity-as-nav-for/as-nav-for", ["flickity/js/index", "fizzy-ui-utils/utils"], e) : "object" == typeof module && module.exports ? module.exports = e(require("flickity"), require("fizzy-ui-utils")) : t.Flickity = e(t.Flickity, t.fizzyUIUtils)
}(window, function (n, s) {
    n.createMethods.push("_createAsNavFor");
    var t = n.prototype;
    return t._createAsNavFor = function () {
        this.on("activate", this.activateAsNavFor), this.on("deactivate", this.deactivateAsNavFor), this.on("destroy", this.destroyAsNavFor);
        var t = this.options.asNavFor;
        if (t) {
            var e = this;
            setTimeout(function () {
                e.setNavCompanion(t)
            })
        }
    }, t.setNavCompanion = function (t) {
        t = s.getQueryElement(t);
        var e = n.data(t);
        if (e && e != this) {
            this.navCompanion = e;
            var i = this;
            this.onNavCompanionSelect = function () {
                i.navCompanionSelect()
            }, e.on("select", this.onNavCompanionSelect), this.on("staticClick", this.onNavStaticClick), this.navCompanionSelect(!0)
        }
    }, t.navCompanionSelect = function (t) {
        var e = this.navCompanion && this.navCompanion.selectedCells;
        if (e) {
            var i = e[0], n = this.navCompanion.cells.indexOf(i), s = n + e.length - 1,
                o = Math.floor(function (t, e, i) {
                    return (e - t) * i + t
                }(n, s, this.navCompanion.cellAlign));
            if (this.selectCell(o, !1, t), this.removeNavSelectedElements(), !(o >= this.cells.length)) {
                var r = this.cells.slice(n, 1 + s);
                this.navSelectedElements = r.map(function (t) {
                    return t.element
                }), this.changeNavSelectedClass("add")
            }
        }
    }, t.changeNavSelectedClass = function (e) {
        this.navSelectedElements.forEach(function (t) {
            t.classList[e]("is-nav-selected")
        })
    }, t.activateAsNavFor = function () {
        this.navCompanionSelect(!0)
    }, t.removeNavSelectedElements = function () {
        this.navSelectedElements && (this.changeNavSelectedClass("remove"), delete this.navSelectedElements)
    }, t.onNavStaticClick = function (t, e, i, n) {
        "number" == typeof n && this.navCompanion.selectCell(n)
    }, t.deactivateAsNavFor = function () {
        this.removeNavSelectedElements()
    }, t.destroyAsNavFor = function () {
        this.navCompanion && (this.navCompanion.off("select", this.onNavCompanionSelect), this.off("staticClick", this.onNavStaticClick), delete this.navCompanion)
    }, n
}), function (e, i) {
    "use strict";
    "function" == typeof define && define.amd ? define("imagesloaded/imagesloaded", ["ev-emitter/ev-emitter"], function (t) {
        return i(e, t)
    }) : "object" == typeof module && module.exports ? module.exports = i(e, require("ev-emitter")) : e.imagesLoaded = i(e, e.EvEmitter)
}("undefined" != typeof window ? window : this, function (e, t) {
    var s = e.jQuery, o = e.console;

    function r(t, e) {
        for (var i in e) t[i] = e[i];
        return t
    }

    var a = Array.prototype.slice;

    function l(t, e, i) {
        if (!(this instanceof l)) return new l(t, e, i);
        var n = t;
        "string" == typeof t && (n = document.querySelectorAll(t)), n ? (this.elements = function (t) {
            return Array.isArray(t) ? t : "object" == typeof t && "number" == typeof t.length ? a.call(t) : [t]
        }(n), this.options = r({}, this.options), "function" == typeof e ? i = e : r(this.options, e), i && this.on("always", i), this.getImages(), s && (this.jqDeferred = new s.Deferred), setTimeout(this.check.bind(this))) : o.error("Bad element for imagesLoaded " + (n || t))
    }

    (l.prototype = Object.create(t.prototype)).options = {}, l.prototype.getImages = function () {
        this.images = [], this.elements.forEach(this.addElementImages, this)
    }, l.prototype.addElementImages = function (t) {
        "IMG" == t.nodeName && this.addImage(t), !0 === this.options.background && this.addElementBackgroundImages(t);
        var e = t.nodeType;
        if (e && h[e]) {
            for (var i = t.querySelectorAll("img"), n = 0; n < i.length; n++) {
                var s = i[n];
                this.addImage(s)
            }
            if ("string" == typeof this.options.background) {
                var o = t.querySelectorAll(this.options.background);
                for (n = 0; n < o.length; n++) {
                    var r = o[n];
                    this.addElementBackgroundImages(r)
                }
            }
        }
    };
    var h = {1: !0, 9: !0, 11: !0};

    function i(t) {
        this.img = t
    }

    function n(t, e) {
        this.url = t, this.element = e, this.img = new Image
    }

    return l.prototype.addElementBackgroundImages = function (t) {
        var e = getComputedStyle(t);
        if (e) for (var i = /url\((['"])?(.*?)\1\)/gi, n = i.exec(e.backgroundImage); null !== n;) {
            var s = n && n[2];
            s && this.addBackground(s, t), n = i.exec(e.backgroundImage)
        }
    }, l.prototype.addImage = function (t) {
        var e = new i(t);
        this.images.push(e)
    }, l.prototype.addBackground = function (t, e) {
        var i = new n(t, e);
        this.images.push(i)
    }, l.prototype.check = function () {
        var n = this;

        function e(t, e, i) {
            setTimeout(function () {
                n.progress(t, e, i)
            })
        }

        this.progressedCount = 0, this.hasAnyBroken = !1, this.images.length ? this.images.forEach(function (t) {
            t.once("progress", e), t.check()
        }) : this.complete()
    }, l.prototype.progress = function (t, e, i) {
        this.progressedCount++, this.hasAnyBroken = this.hasAnyBroken || !t.isLoaded, this.emitEvent("progress", [this, t, e]), this.jqDeferred && this.jqDeferred.notify && this.jqDeferred.notify(this, t), this.progressedCount == this.images.length && this.complete(), this.options.debug && o && o.log("progress: " + i, t, e)
    }, l.prototype.complete = function () {
        var t = this.hasAnyBroken ? "fail" : "done";
        if (this.isComplete = !0, this.emitEvent(t, [this]), this.emitEvent("always", [this]), this.jqDeferred) {
            var e = this.hasAnyBroken ? "reject" : "resolve";
            this.jqDeferred[e](this)
        }
    }, (i.prototype = Object.create(t.prototype)).check = function () {
        this.getIsImageComplete() ? this.confirm(0 !== this.img.naturalWidth, "naturalWidth") : (this.proxyImage = new Image, this.proxyImage.addEventListener("load", this), this.proxyImage.addEventListener("error", this), this.img.addEventListener("load", this), this.img.addEventListener("error", this), this.proxyImage.src = this.img.src)
    }, i.prototype.getIsImageComplete = function () {
        return this.img.complete && this.img.naturalWidth
    }, i.prototype.confirm = function (t, e) {
        this.isLoaded = t, this.emitEvent("progress", [this, this.img, e])
    }, i.prototype.handleEvent = function (t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }, i.prototype.onload = function () {
        this.confirm(!0, "onload"), this.unbindEvents()
    }, i.prototype.onerror = function () {
        this.confirm(!1, "onerror"), this.unbindEvents()
    }, i.prototype.unbindEvents = function () {
        this.proxyImage.removeEventListener("load", this), this.proxyImage.removeEventListener("error", this), this.img.removeEventListener("load", this), this.img.removeEventListener("error", this)
    }, (n.prototype = Object.create(i.prototype)).check = function () {
        this.img.addEventListener("load", this), this.img.addEventListener("error", this), this.img.src = this.url, this.getIsImageComplete() && (this.confirm(0 !== this.img.naturalWidth, "naturalWidth"), this.unbindEvents())
    }, n.prototype.unbindEvents = function () {
        this.img.removeEventListener("load", this), this.img.removeEventListener("error", this)
    }, n.prototype.confirm = function (t, e) {
        this.isLoaded = t, this.emitEvent("progress", [this, this.element, e])
    }, l.makeJQueryPlugin = function (t) {
        (t = t || e.jQuery) && ((s = t).fn.imagesLoaded = function (t, e) {
            return new l(this, t, e).jqDeferred.promise(s(this))
        })
    }, l.makeJQueryPlugin(), l
}), function (i, n) {
    "function" == typeof define && define.amd ? define(["flickity/js/index", "imagesloaded/imagesloaded"], function (t, e) {
        return n(i, t, e)
    }) : "object" == typeof module && module.exports ? module.exports = n(i, require("flickity"), require("imagesloaded")) : i.Flickity = n(i, i.Flickity, i.imagesLoaded)
}(window, function (t, e, i) {
    "use strict";
    e.createMethods.push("_createImagesLoaded");
    var n = e.prototype;
    return n._createImagesLoaded = function () {
        this.on("activate", this.imagesLoaded)
    }, n.imagesLoaded = function () {
        if (this.options.imagesLoaded) {
            var n = this;
            i(this.slider).on("progress", function (t, e) {
                var i = n.getParentCell(e.img);
                n.cellSizeChange(i && i.element), n.options.freeScroll || n.positionSliderAtSelected()
            })
        }
    }, e
});

/** * Flickity background lazyload v1.0.1
 * lazyload background cell images */
!function (t, e) {
    "function" == typeof define && define.amd ? define(["flickity/js/index", "fizzy-ui-utils/utils"], e) : "object" == typeof module && module.exports ? module.exports = e(require("flickity"), require("fizzy-ui-utils")) : e(t.Flickity, t.fizzyUIUtils)
}(window, function (t, e) {
    "use strict";
    t.createMethods.push("_createBgLazyLoad");
    var i = t.prototype;

    function o(t, e, i) {
        this.element = t, this.url = e, this.img = new Image, this.flickity = i, this.load()
    }

    return i._createBgLazyLoad = function () {
        this.on("select", this.bgLazyLoad)
    }, i.bgLazyLoad = function () {
        var t = this.options.bgLazyLoad;
        if (t) for (var e = "number" == typeof t ? t : 0, i = this.getAdjacentCellElements(e), o = 0; o < i.length; o++) {
            var a = i[o];
            this.bgLazyLoadElem(a);
            for (var l = a.querySelectorAll("[data-flickity-bg-lazyload]"), n = 0; n < l.length; n++) this.bgLazyLoadElem(l[n])
        }
    }, i.bgLazyLoadElem = function (t) {
        var e = t.getAttribute("data-flickity-bg-lazyload");
        e && new o(t, e, this)
    }, o.prototype.handleEvent = e.handleEvent, o.prototype.load = function () {
        this.img.addEventListener("load", this), this.img.addEventListener("error", this), this.img.src = this.url, this.element.removeAttribute("data-flickity-bg-lazyload")
    }, o.prototype.onload = function (t) {
        this.element.style.backgroundImage = 'url("' + this.url + '")', this.complete(t, "flickity-bg-lazyloaded")
    }, o.prototype.onerror = function (t) {
        this.complete(t, "flickity-bg-lazyerror")
    }, o.prototype.complete = function (t, e) {
        this.img.removeEventListener("load", this), this.img.removeEventListener("error", this), this.element.classList.add(e), this.flickity.dispatchEvent("bgLazyLoad", t, this.element)
    }, t.BgLazyLoader = o, t
});


// Ion.RangeSlider
!function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], function (i) {
        return t(i, document, window, navigator)
    }) : "object" == typeof exports ? t(require("jquery"), document, window, navigator) : t(jQuery, document, window, navigator)
}(function (t, i, s, o, e) {
    "use strict";
    var h, r, n = 0,
        a = (h = o.userAgent, r = /msie\s\d+/i, h.search(r) > 0 && r.exec(h).toString().split(" ")[1] < 9 && (t("html").addClass("lt-ie9"), !0));
    Function.prototype.bind || (Function.prototype.bind = function (t) {
        var i = this, s = [].slice;
        if ("function" != typeof i) throw new TypeError;
        var o = s.call(arguments, 1), e = function () {
            if (this instanceof e) {
                var h = function () {
                };
                h.prototype = i.prototype;
                var r = new h, n = i.apply(r, o.concat(s.call(arguments)));
                return Object(n) === n ? n : r
            }
            return i.apply(t, o.concat(s.call(arguments)))
        };
        return e
    }), Array.prototype.indexOf || (Array.prototype.indexOf = function (t, i) {
        var s;
        if (null == this) throw new TypeError('"this" is null or not defined');
        var o = Object(this), e = o.length >>> 0;
        if (0 === e) return -1;
        var h = +i || 0;
        if (Math.abs(h) === 1 / 0 && (h = 0), h >= e) return -1;
        for (s = Math.max(h >= 0 ? h : e - Math.abs(h), 0); s < e;) {
            if (s in o && o[s] === t) return s;
            s++
        }
        return -1
    });
    var c = function (o, h, r) {
        this.VERSION = "2.2.0", this.input = o, this.plugin_count = r, this.current_plugin = 0, this.calc_count = 0, this.update_tm = 0, this.old_from = 0, this.old_to = 0, this.old_min_interval = null, this.raf_id = null, this.dragging = !1, this.force_redraw = !1, this.no_diapason = !1, this.has_tab_index = !0, this.is_key = !1, this.is_update = !1, this.is_start = !0, this.is_finish = !1, this.is_active = !1, this.is_resize = !1, this.is_click = !1, h = h || {}, this.$cache = {
            win: t(s),
            body: t(i.body),
            input: t(o),
            cont: null,
            rs: null,
            min: null,
            max: null,
            from: null,
            to: null,
            single: null,
            bar: null,
            line: null,
            s_single: null,
            s_from: null,
            s_to: null,
            shad_single: null,
            shad_from: null,
            shad_to: null,
            edge: null,
            grid: null,
            grid_labels: []
        }, this.coords = {
            x_gap: 0,
            x_pointer: 0,
            w_rs: 0,
            w_rs_old: 0,
            w_handle: 0,
            p_gap: 0,
            p_gap_left: 0,
            p_gap_right: 0,
            p_step: 0,
            p_pointer: 0,
            p_handle: 0,
            p_single_fake: 0,
            p_single_real: 0,
            p_from_fake: 0,
            p_from_real: 0,
            p_to_fake: 0,
            p_to_real: 0,
            p_bar_x: 0,
            p_bar_w: 0,
            grid_gap: 0,
            big_num: 0,
            big: [],
            big_w: [],
            big_p: [],
            big_x: []
        }, this.labels = {
            w_min: 0,
            w_max: 0,
            w_from: 0,
            w_to: 0,
            w_single: 0,
            p_min: 0,
            p_max: 0,
            p_from_fake: 0,
            p_from_left: 0,
            p_to_fake: 0,
            p_to_left: 0,
            p_single_fake: 0,
            p_single_left: 0
        };
        var n, a, c, l = this.$cache.input, _ = l.prop("value");
        for (c in n = {
            type: "single",
            min: 10,
            max: 100,
            from: null,
            to: null,
            step: 1,
            min_interval: 0,
            max_interval: 0,
            drag_interval: !1,
            values: [],
            p_values: [],
            from_fixed: !1,
            from_min: null,
            from_max: null,
            from_shadow: !1,
            to_fixed: !1,
            to_min: null,
            to_max: null,
            to_shadow: !1,
            prettify_enabled: !0,
            prettify_separator: " ",
            prettify: null,
            force_edges: !1,
            keyboard: !0,
            grid: !1,
            grid_margin: !0,
            grid_num: 4,
            grid_snap: !1,
            hide_min_max: !1,
            hide_from_to: !1,
            prefix: "",
            postfix: "",
            max_postfix: "",
            decorate_both: !0,
            values_separator: " — ",
            input_values_separator: ";",
            disable: !1,
            block: !1,
            extra_classes: "",
            scope: null,
            onStart: null,
            onChange: null,
            onFinish: null,
            onUpdate: null
        }, "INPUT" !== l[0].nodeName && console && console.warn && console.warn("Base element should be <input>!", l[0]), (a = {
            type: l.data("type"),
            min: l.data("min"),
            max: l.data("max"),
            from: l.data("from"),
            to: l.data("to"),
            step: l.data("step"),
            min_interval: l.data("minInterval"),
            max_interval: l.data("maxInterval"),
            drag_interval: l.data("dragInterval"),
            values: l.data("values"),
            from_fixed: l.data("fromFixed"),
            from_min: l.data("fromMin"),
            from_max: l.data("fromMax"),
            from_shadow: l.data("fromShadow"),
            to_fixed: l.data("toFixed"),
            to_min: l.data("toMin"),
            to_max: l.data("toMax"),
            to_shadow: l.data("toShadow"),
            prettify_enabled: l.data("prettifyEnabled"),
            prettify_separator: l.data("prettifySeparator"),
            force_edges: l.data("forceEdges"),
            keyboard: l.data("keyboard"),
            grid: l.data("grid"),
            grid_margin: l.data("gridMargin"),
            grid_num: l.data("gridNum"),
            grid_snap: l.data("gridSnap"),
            hide_min_max: l.data("hideMinMax"),
            hide_from_to: l.data("hideFromTo"),
            prefix: l.data("prefix"),
            postfix: l.data("postfix"),
            max_postfix: l.data("maxPostfix"),
            decorate_both: l.data("decorateBoth"),
            values_separator: l.data("valuesSeparator"),
            input_values_separator: l.data("inputValuesSeparator"),
            disable: l.data("disable"),
            block: l.data("block"),
            extra_classes: l.data("extraClasses")
        }).values = a.values && a.values.split(","), a) a.hasOwnProperty(c) && (a[c] !== e && "" !== a[c] || delete a[c]);
        _ !== e && "" !== _ && ((_ = _.split(a.input_values_separator || h.input_values_separator || ";"))[0] && _[0] == +_[0] && (_[0] = +_[0]), _[1] && _[1] == +_[1] && (_[1] = +_[1]), h && h.values && h.values.length ? (n.from = _[0] && h.values.indexOf(_[0]), n.to = _[1] && h.values.indexOf(_[1])) : (n.from = _[0] && +_[0], n.to = _[1] && +_[1])), t.extend(n, h), t.extend(n, a), this.options = n, this.update_check = {}, this.validate(), this.result = {
            input: this.$cache.input,
            slider: null,
            min: this.options.min,
            max: this.options.max,
            from: this.options.from,
            from_percent: 0,
            from_value: null,
            to: this.options.to,
            to_percent: 0,
            to_value: null
        }, this.init()
    };
    c.prototype = {
        init: function (t) {
            this.no_diapason = !1, this.coords.p_step = this.convertToPercent(this.options.step, !0), this.target = "base", this.toggleInput(), this.append(), this.setMinMax(), t ? (this.force_redraw = !0, this.calc(!0), this.callOnUpdate()) : (this.force_redraw = !0, this.calc(!0), this.callOnStart()), this.updateScene()
        }, append: function () {
            var t = '<span class="irs js-irs-' + this.plugin_count + " " + this.options.extra_classes + '"></span>';
            this.$cache.input.before(t), this.$cache.input.prop("readonly", !0), this.$cache.cont = this.$cache.input.prev(), this.result.slider = this.$cache.cont, this.$cache.cont.html('<span class="irs"><span class="irs-line" tabindex="0"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min">0</span><span class="irs-max">1</span><span class="irs-from">0</span><span class="irs-to">0</span><span class="irs-single">0</span></span><span class="irs-grid"></span><span class="irs-bar color-main"></span>'), this.$cache.rs = this.$cache.cont.find(".irs"), this.$cache.min = this.$cache.cont.find(".irs-min"), this.$cache.max = this.$cache.cont.find(".irs-max"), this.$cache.from = this.$cache.cont.find(".irs-from"), this.$cache.to = this.$cache.cont.find(".irs-to"), this.$cache.single = this.$cache.cont.find(".irs-single"), this.$cache.bar = this.$cache.cont.find(".irs-bar"), this.$cache.line = this.$cache.cont.find(".irs-line"), this.$cache.grid = this.$cache.cont.find(".irs-grid"), "single" === this.options.type ? (this.$cache.cont.append('<span class="irs-bar-edge"></span><span class="irs-shadow shadow-single"></span><span class="irs-slider single"></span>'), this.$cache.edge = this.$cache.cont.find(".irs-bar-edge"), this.$cache.s_single = this.$cache.cont.find(".single"), this.$cache.from[0].style.visibility = "hidden", this.$cache.to[0].style.visibility = "hidden", this.$cache.shad_single = this.$cache.cont.find(".shadow-single")) : (this.$cache.cont.append('<span class="irs-shadow shadow-from"></span><span class="irs-shadow shadow-to"></span><span class="irs-slider from color-main"></span><span class="irs-slider to color-main"></span>'), this.$cache.s_from = this.$cache.cont.find(".from"), this.$cache.s_to = this.$cache.cont.find(".to"), this.$cache.shad_from = this.$cache.cont.find(".shadow-from"), this.$cache.shad_to = this.$cache.cont.find(".shadow-to"), this.setTopHandler()), this.options.hide_from_to && (this.$cache.from[0].style.display = "none", this.$cache.to[0].style.display = "none", this.$cache.single[0].style.display = "none"), this.appendGrid(), this.options.disable ? (this.appendDisableMask(), this.$cache.input[0].disabled = !0) : (this.$cache.input[0].disabled = !1, this.removeDisableMask(), this.bindEvents()), this.options.disable || (this.options.block ? this.appendDisableMask() : this.removeDisableMask()), this.options.drag_interval && (this.$cache.bar[0].style.cursor = "ew-resize")
        }, setTopHandler: function () {
            var t = this.options.min, i = this.options.max, s = this.options.from, o = this.options.to;
            s > t && o === i ? this.$cache.s_from.addClass("type_last") : o < i && this.$cache.s_to.addClass("type_last")
        }, changeLevel: function (t) {
            switch (t) {
                case"single":
                    this.coords.p_gap = this.toFixed(this.coords.p_pointer - this.coords.p_single_fake), this.$cache.s_single.addClass("state_hover");
                    break;
                case"from":
                    this.coords.p_gap = this.toFixed(this.coords.p_pointer - this.coords.p_from_fake), this.$cache.s_from.addClass("state_hover"), this.$cache.s_from.addClass("type_last"), this.$cache.s_to.removeClass("type_last");
                    break;
                case"to":
                    this.coords.p_gap = this.toFixed(this.coords.p_pointer - this.coords.p_to_fake), this.$cache.s_to.addClass("state_hover"), this.$cache.s_to.addClass("type_last"), this.$cache.s_from.removeClass("type_last");
                    break;
                case"both":
                    this.coords.p_gap_left = this.toFixed(this.coords.p_pointer - this.coords.p_from_fake), this.coords.p_gap_right = this.toFixed(this.coords.p_to_fake - this.coords.p_pointer), this.$cache.s_to.removeClass("type_last"), this.$cache.s_from.removeClass("type_last")
            }
        }, appendDisableMask: function () {
            this.$cache.cont.append('<span class="irs-disable-mask"></span>'), this.$cache.cont.addClass("irs-disabled")
        }, removeDisableMask: function () {
            this.$cache.cont.remove(".irs-disable-mask"), this.$cache.cont.removeClass("irs-disabled")
        }, remove: function () {
            this.$cache.cont.remove(), this.$cache.cont = null, this.$cache.line.off("keydown.irs_" + this.plugin_count), this.$cache.body.off("touchmove.irs_" + this.plugin_count), this.$cache.body.off("mousemove.irs_" + this.plugin_count), this.$cache.win.off("touchend.irs_" + this.plugin_count), this.$cache.win.off("mouseup.irs_" + this.plugin_count), a && (this.$cache.body.off("mouseup.irs_" + this.plugin_count), this.$cache.body.off("mouseleave.irs_" + this.plugin_count)), this.$cache.grid_labels = [], this.coords.big = [], this.coords.big_w = [], this.coords.big_p = [], this.coords.big_x = [], cancelAnimationFrame(this.raf_id)
        }, bindEvents: function () {
            this.no_diapason || (this.$cache.body.on("touchmove.irs_" + this.plugin_count, this.pointerMove.bind(this)), this.$cache.body.on("mousemove.irs_" + this.plugin_count, this.pointerMove.bind(this)), this.$cache.win.on("touchend.irs_" + this.plugin_count, this.pointerUp.bind(this)), this.$cache.win.on("mouseup.irs_" + this.plugin_count, this.pointerUp.bind(this)), this.$cache.line.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.line.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.line.on("focus.irs_" + this.plugin_count, this.pointerFocus.bind(this)), this.options.drag_interval && "double" === this.options.type ? (this.$cache.bar.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "both")), this.$cache.bar.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "both"))) : (this.$cache.bar.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.bar.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click"))), "single" === this.options.type ? (this.$cache.single.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.s_single.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.shad_single.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.single.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.s_single.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.edge.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.shad_single.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click"))) : (this.$cache.single.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, null)), this.$cache.single.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, null)), this.$cache.from.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.s_from.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.to.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.s_to.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.shad_from.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.shad_to.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.from.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.s_from.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.to.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.s_to.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.shad_from.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.shad_to.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click"))), this.options.keyboard && this.$cache.line.on("keydown.irs_" + this.plugin_count, this.key.bind(this, "keyboard")), a && (this.$cache.body.on("mouseup.irs_" + this.plugin_count, this.pointerUp.bind(this)), this.$cache.body.on("mouseleave.irs_" + this.plugin_count, this.pointerUp.bind(this))))
        }, pointerFocus: function (t) {
            var i, s;
            this.target || (i = (s = "single" === this.options.type ? this.$cache.single : this.$cache.from).offset().left, i += s.width() / 2 - 1, this.pointerClick("single", {
                preventDefault: function () {
                }, pageX: i
            }))
        }, pointerMove: function (t) {
            if (this.dragging) {
                var i = t.pageX || t.originalEvent.touches && t.originalEvent.touches[0].pageX;
                this.coords.x_pointer = i - this.coords.x_gap, this.calc()
            }
        }, pointerUp: function (i) {
            this.current_plugin === this.plugin_count && this.is_active && (this.is_active = !1, this.$cache.cont.find(".state_hover").removeClass("state_hover"), this.force_redraw = !0, a && t("*").prop("unselectable", !1), this.updateScene(), this.restoreOriginalMinInterval(), (t.contains(this.$cache.cont[0], i.target) || this.dragging) && this.callOnFinish(), this.dragging = !1)
        }, pointerDown: function (i, s) {
            s.preventDefault();
            var o = s.pageX || s.originalEvent.touches && s.originalEvent.touches[0].pageX;
            2 !== s.button && ("both" === i && this.setTempMinInterval(), i || (i = this.target || "from"), this.current_plugin = this.plugin_count, this.target = i, this.is_active = !0, this.dragging = !0, this.coords.x_gap = this.$cache.rs.offset().left, this.coords.x_pointer = o - this.coords.x_gap, this.calcPointerPercent(), this.changeLevel(i), a && t("*").prop("unselectable", !0), this.$cache.line.trigger("focus"), this.updateScene())
        }, pointerClick: function (t, i) {
            i.preventDefault();
            var s = i.pageX || i.originalEvent.touches && i.originalEvent.touches[0].pageX;
            2 !== i.button && (this.current_plugin = this.plugin_count, this.target = t, this.is_click = !0, this.coords.x_gap = this.$cache.rs.offset().left, this.coords.x_pointer = +(s - this.coords.x_gap).toFixed(), this.force_redraw = !0, this.calc(), this.$cache.line.trigger("focus"))
        }, key: function (t, i) {
            if (!(this.current_plugin !== this.plugin_count || i.altKey || i.ctrlKey || i.shiftKey || i.metaKey)) {
                switch (i.which) {
                    case 83:
                    case 65:
                    case 40:
                    case 37:
                        i.preventDefault(), this.moveByKey(!1);
                        break;
                    case 87:
                    case 68:
                    case 38:
                    case 39:
                        i.preventDefault(), this.moveByKey(!0)
                }
                return !0
            }
        }, moveByKey: function (t) {
            var i = this.coords.p_pointer, s = (this.options.max - this.options.min) / 100;
            s = this.options.step / s, t ? i += s : i -= s, this.coords.x_pointer = this.toFixed(this.coords.w_rs / 100 * i), this.is_key = !0, this.calc()
        }, setMinMax: function () {
            if (this.options) {
                if (this.options.hide_min_max) return this.$cache.min[0].style.display = "none", void (this.$cache.max[0].style.display = "none");
                if (this.options.values.length) this.$cache.min.html(this.decorate(this.options.p_values[this.options.min])), this.$cache.max.html(this.decorate(this.options.p_values[this.options.max])); else {
                    var t = this._prettify(this.options.min), i = this._prettify(this.options.max);
                    this.result.min_pretty = t, this.result.max_pretty = i, this.$cache.min.html(this.decorate(t, this.options.min)), this.$cache.max.html(this.decorate(i, this.options.max))
                }
                this.labels.w_min = this.$cache.min.outerWidth(!1), this.labels.w_max = this.$cache.max.outerWidth(!1)
            }
        }, setTempMinInterval: function () {
            var t = this.result.to - this.result.from;
            null === this.old_min_interval && (this.old_min_interval = this.options.min_interval), this.options.min_interval = t
        }, restoreOriginalMinInterval: function () {
            null !== this.old_min_interval && (this.options.min_interval = this.old_min_interval, this.old_min_interval = null)
        }, calc: function (t) {
            if (this.options && (this.calc_count++, (10 === this.calc_count || t) && (this.calc_count = 0, this.coords.w_rs = this.$cache.rs.outerWidth(!1), this.calcHandlePercent()), this.coords.w_rs)) {
                this.calcPointerPercent();
                var i = this.getHandleX();
                switch ("both" === this.target && (this.coords.p_gap = 0, i = this.getHandleX()), "click" === this.target && (this.coords.p_gap = this.coords.p_handle / 2, i = this.getHandleX(), this.options.drag_interval ? this.target = "both_one" : this.target = this.chooseHandle(i)), this.target) {
                    case"base":
                        var s = (this.options.max - this.options.min) / 100,
                            o = (this.result.from - this.options.min) / s, e = (this.result.to - this.options.min) / s;
                        this.coords.p_single_real = this.toFixed(o), this.coords.p_from_real = this.toFixed(o), this.coords.p_to_real = this.toFixed(e), this.coords.p_single_real = this.checkDiapason(this.coords.p_single_real, this.options.from_min, this.options.from_max), this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max), this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max), this.coords.p_single_fake = this.convertToFakePercent(this.coords.p_single_real), this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real), this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real), this.target = null;
                        break;
                    case"single":
                        if (this.options.from_fixed) break;
                        this.coords.p_single_real = this.convertToRealPercent(i), this.coords.p_single_real = this.calcWithStep(this.coords.p_single_real), this.coords.p_single_real = this.checkDiapason(this.coords.p_single_real, this.options.from_min, this.options.from_max), this.coords.p_single_fake = this.convertToFakePercent(this.coords.p_single_real);
                        break;
                    case"from":
                        if (this.options.from_fixed) break;
                        this.coords.p_from_real = this.convertToRealPercent(i), this.coords.p_from_real = this.calcWithStep(this.coords.p_from_real), this.coords.p_from_real > this.coords.p_to_real && (this.coords.p_from_real = this.coords.p_to_real), this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max), this.coords.p_from_real = this.checkMinInterval(this.coords.p_from_real, this.coords.p_to_real, "from"), this.coords.p_from_real = this.checkMaxInterval(this.coords.p_from_real, this.coords.p_to_real, "from"), this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real);
                        break;
                    case"to":
                        if (this.options.to_fixed) break;
                        this.coords.p_to_real = this.convertToRealPercent(i), this.coords.p_to_real = this.calcWithStep(this.coords.p_to_real), this.coords.p_to_real < this.coords.p_from_real && (this.coords.p_to_real = this.coords.p_from_real), this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max), this.coords.p_to_real = this.checkMinInterval(this.coords.p_to_real, this.coords.p_from_real, "to"), this.coords.p_to_real = this.checkMaxInterval(this.coords.p_to_real, this.coords.p_from_real, "to"), this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real);
                        break;
                    case"both":
                        if (this.options.from_fixed || this.options.to_fixed) break;
                        i = this.toFixed(i + .001 * this.coords.p_handle), this.coords.p_from_real = this.convertToRealPercent(i) - this.coords.p_gap_left, this.coords.p_from_real = this.calcWithStep(this.coords.p_from_real), this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max), this.coords.p_from_real = this.checkMinInterval(this.coords.p_from_real, this.coords.p_to_real, "from"), this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real), this.coords.p_to_real = this.convertToRealPercent(i) + this.coords.p_gap_right, this.coords.p_to_real = this.calcWithStep(this.coords.p_to_real), this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max), this.coords.p_to_real = this.checkMinInterval(this.coords.p_to_real, this.coords.p_from_real, "to"), this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real);
                        break;
                    case"both_one":
                        if (this.options.from_fixed || this.options.to_fixed) break;
                        var h = this.convertToRealPercent(i), r = this.result.from_percent,
                            n = this.result.to_percent - r, a = n / 2, c = h - a, l = h + a;
                        c < 0 && (l = (c = 0) + n), l > 100 && (c = (l = 100) - n), this.coords.p_from_real = this.calcWithStep(c), this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max), this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real), this.coords.p_to_real = this.calcWithStep(l), this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max), this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real)
                }
                "single" === this.options.type ? (this.coords.p_bar_x = this.coords.p_handle / 2, this.coords.p_bar_w = this.coords.p_single_fake, this.result.from_percent = this.coords.p_single_real, this.result.from = this.convertToValue(this.coords.p_single_real), this.result.from_pretty = this._prettify(this.result.from), this.options.values.length && (this.result.from_value = this.options.values[this.result.from])) : (this.coords.p_bar_x = this.toFixed(this.coords.p_from_fake + this.coords.p_handle / 2), this.coords.p_bar_w = this.toFixed(this.coords.p_to_fake - this.coords.p_from_fake), this.result.from_percent = this.coords.p_from_real, this.result.from = this.convertToValue(this.coords.p_from_real), this.result.from_pretty = this._prettify(this.result.from), this.result.to_percent = this.coords.p_to_real, this.result.to = this.convertToValue(this.coords.p_to_real), this.result.to_pretty = this._prettify(this.result.to), this.options.values.length && (this.result.from_value = this.options.values[this.result.from], this.result.to_value = this.options.values[this.result.to])), this.calcMinMax(), this.calcLabels()
            }
        }, calcPointerPercent: function () {
            this.coords.w_rs ? (this.coords.x_pointer < 0 || isNaN(this.coords.x_pointer) ? this.coords.x_pointer = 0 : this.coords.x_pointer > this.coords.w_rs && (this.coords.x_pointer = this.coords.w_rs), this.coords.p_pointer = this.toFixed(this.coords.x_pointer / this.coords.w_rs * 100)) : this.coords.p_pointer = 0
        }, convertToRealPercent: function (t) {
            return t / (100 - this.coords.p_handle) * 100
        }, convertToFakePercent: function (t) {
            return t / 100 * (100 - this.coords.p_handle)
        }, getHandleX: function () {
            var t = 100 - this.coords.p_handle, i = this.toFixed(this.coords.p_pointer - this.coords.p_gap);
            return i < 0 ? i = 0 : i > t && (i = t), i
        }, calcHandlePercent: function () {
            "single" === this.options.type ? this.coords.w_handle = this.$cache.s_single.outerWidth(!1) : this.coords.w_handle = this.$cache.s_from.outerWidth(!1), this.coords.p_handle = this.toFixed(this.coords.w_handle / this.coords.w_rs * 100)
        }, chooseHandle: function (t) {
            return "single" === this.options.type ? "single" : t >= this.coords.p_from_real + (this.coords.p_to_real - this.coords.p_from_real) / 2 ? this.options.to_fixed ? "from" : "to" : this.options.from_fixed ? "to" : "from"
        }, calcMinMax: function () {
            this.coords.w_rs && (this.labels.p_min = this.labels.w_min / this.coords.w_rs * 100, this.labels.p_max = this.labels.w_max / this.coords.w_rs * 100)
        }, calcLabels: function () {
            this.coords.w_rs && !this.options.hide_from_to && ("single" === this.options.type ? (this.labels.w_single = this.$cache.single.outerWidth(!1), this.labels.p_single_fake = this.labels.w_single / this.coords.w_rs * 100, this.labels.p_single_left = this.coords.p_single_fake + this.coords.p_handle / 2 - this.labels.p_single_fake / 2, this.labels.p_single_left = this.checkEdges(this.labels.p_single_left, this.labels.p_single_fake)) : (this.labels.w_from = this.$cache.from.outerWidth(!1), this.labels.p_from_fake = this.labels.w_from / this.coords.w_rs * 100, this.labels.p_from_left = this.coords.p_from_fake + this.coords.p_handle / 2 - this.labels.p_from_fake / 2, this.labels.p_from_left = this.toFixed(this.labels.p_from_left), this.labels.p_from_left = this.checkEdges(this.labels.p_from_left, this.labels.p_from_fake), this.labels.w_to = this.$cache.to.outerWidth(!1), this.labels.p_to_fake = this.labels.w_to / this.coords.w_rs * 100, this.labels.p_to_left = this.coords.p_to_fake + this.coords.p_handle / 2 - this.labels.p_to_fake / 2, this.labels.p_to_left = this.toFixed(this.labels.p_to_left), this.labels.p_to_left = this.checkEdges(this.labels.p_to_left, this.labels.p_to_fake), this.labels.w_single = this.$cache.single.outerWidth(!1), this.labels.p_single_fake = this.labels.w_single / this.coords.w_rs * 100, this.labels.p_single_left = (this.labels.p_from_left + this.labels.p_to_left + this.labels.p_to_fake) / 2 - this.labels.p_single_fake / 2, this.labels.p_single_left = this.toFixed(this.labels.p_single_left), this.labels.p_single_left = this.checkEdges(this.labels.p_single_left, this.labels.p_single_fake)))
        }, updateScene: function () {
            this.raf_id && (cancelAnimationFrame(this.raf_id), this.raf_id = null), clearTimeout(this.update_tm), this.update_tm = null, this.options && (this.drawHandles(), this.is_active ? this.raf_id = requestAnimationFrame(this.updateScene.bind(this)) : this.update_tm = setTimeout(this.updateScene.bind(this), 300))
        }, drawHandles: function () {
            this.coords.w_rs = this.$cache.rs.outerWidth(!1), this.coords.w_rs && (this.coords.w_rs !== this.coords.w_rs_old && (this.target = "base", this.is_resize = !0), (this.coords.w_rs !== this.coords.w_rs_old || this.force_redraw) && (this.setMinMax(), this.calc(!0), this.drawLabels(), this.options.grid && (this.calcGridMargin(), this.calcGridLabels()), this.force_redraw = !0, this.coords.w_rs_old = this.coords.w_rs, this.drawShadow()), this.coords.w_rs && (this.dragging || this.force_redraw || this.is_key) && ((this.old_from !== this.result.from || this.old_to !== this.result.to || this.force_redraw || this.is_key) && (this.drawLabels(), this.$cache.bar[0].style.left = this.coords.p_bar_x + "%", this.$cache.bar[0].style.width = this.coords.p_bar_w + "%", "single" === this.options.type ? (this.$cache.s_single[0].style.left = this.coords.p_single_fake + "%", this.$cache.single[0].style.left = this.labels.p_single_left + "%") : (this.$cache.s_from[0].style.left = this.coords.p_from_fake + "%", this.$cache.s_to[0].style.left = this.coords.p_to_fake + "%", (this.old_from !== this.result.from || this.force_redraw) && (this.$cache.from[0].style.left = this.labels.p_from_left + "%"), (this.old_to !== this.result.to || this.force_redraw) && (this.$cache.to[0].style.left = this.labels.p_to_left + "%"), this.$cache.single[0].style.left = this.labels.p_single_left + "%"), this.writeToInput(), this.old_from === this.result.from && this.old_to === this.result.to || this.is_start || (this.$cache.input.trigger("change"), this.$cache.input.trigger("input")), this.old_from = this.result.from, this.old_to = this.result.to, this.is_resize || this.is_update || this.is_start || this.is_finish || this.callOnChange(), (this.is_key || this.is_click) && (this.is_key = !1, this.is_click = !1, this.callOnFinish()), this.is_update = !1, this.is_resize = !1, this.is_finish = !1), this.is_start = !1, this.is_key = !1, this.is_click = !1, this.force_redraw = !1))
        }, drawLabels: function () {
            if (this.options) {
                var t, i, s, o, e, h = this.options.values.length, r = this.options.p_values;
                if (!this.options.hide_from_to) if ("single" === this.options.type) h ? (t = this.decorate(r[this.result.from]), this.$cache.single.html(t)) : (o = this._prettify(this.result.from), t = this.decorate(o, this.result.from), this.$cache.single.html(t)), this.calcLabels(), this.labels.p_single_left < this.labels.p_min + 1 ? this.$cache.min[0].style.visibility = "hidden" : this.$cache.min[0].style.visibility = "visible", this.labels.p_single_left + this.labels.p_single_fake > 100 - this.labels.p_max - 1 ? this.$cache.max[0].style.visibility = "hidden" : this.$cache.max[0].style.visibility = "visible"; else {
                    h ? (this.options.decorate_both ? (t = this.decorate(r[this.result.from]), t += this.options.values_separator, t += this.decorate(r[this.result.to])) : t = this.decorate(r[this.result.from] + this.options.values_separator + r[this.result.to]), i = this.decorate(r[this.result.from]), s = this.decorate(r[this.result.to]), this.$cache.single.html(t), this.$cache.from.html(i), this.$cache.to.html(s)) : (o = this._prettify(this.result.from), e = this._prettify(this.result.to), this.options.decorate_both ? (t = this.decorate(o, this.result.from), t += this.options.values_separator, t += this.decorate(e, this.result.to)) : t = this.decorate(o + this.options.values_separator + e, this.result.to), i = this.decorate(o, this.result.from), s = this.decorate(e, this.result.to), this.$cache.single.html(t), this.$cache.from.html(i), this.$cache.to.html(s)), this.calcLabels();
                    var n = Math.min(this.labels.p_single_left, this.labels.p_from_left),
                        a = this.labels.p_single_left + this.labels.p_single_fake,
                        c = this.labels.p_to_left + this.labels.p_to_fake, l = Math.max(a, c);
                    this.labels.p_from_left + this.labels.p_from_fake >= this.labels.p_to_left ? (this.$cache.from[0].style.visibility = "hidden", this.$cache.to[0].style.visibility = "hidden", this.$cache.single[0].style.visibility = "visible", this.result.from === this.result.to ? ("from" === this.target ? this.$cache.from[0].style.visibility = "visible" : "to" === this.target ? this.$cache.to[0].style.visibility = "visible" : this.target || (this.$cache.from[0].style.visibility = "visible"), this.$cache.single[0].style.visibility = "hidden", l = c) : (this.$cache.from[0].style.visibility = "hidden", this.$cache.to[0].style.visibility = "hidden", this.$cache.single[0].style.visibility = "visible", l = Math.max(a, c))) : (this.$cache.from[0].style.visibility = "visible", this.$cache.to[0].style.visibility = "visible", this.$cache.single[0].style.visibility = "hidden"), n < this.labels.p_min + 1 ? this.$cache.min[0].style.visibility = "hidden" : this.$cache.min[0].style.visibility = "visible", l > 100 - this.labels.p_max - 1 ? this.$cache.max[0].style.visibility = "hidden" : this.$cache.max[0].style.visibility = "visible"
                }
            }
        }, drawShadow: function () {
            var t, i, s, o, e = this.options, h = this.$cache, r = "number" == typeof e.from_min && !isNaN(e.from_min),
                n = "number" == typeof e.from_max && !isNaN(e.from_max),
                a = "number" == typeof e.to_min && !isNaN(e.to_min),
                c = "number" == typeof e.to_max && !isNaN(e.to_max);
            "single" === e.type ? e.from_shadow && (r || n) ? (t = this.convertToPercent(r ? e.from_min : e.min), i = this.convertToPercent(n ? e.from_max : e.max) - t, t = this.toFixed(t - this.coords.p_handle / 100 * t), i = this.toFixed(i - this.coords.p_handle / 100 * i), t += this.coords.p_handle / 2, h.shad_single[0].style.display = "block", h.shad_single[0].style.left = t + "%", h.shad_single[0].style.width = i + "%") : h.shad_single[0].style.display = "none" : (e.from_shadow && (r || n) ? (t = this.convertToPercent(r ? e.from_min : e.min), i = this.convertToPercent(n ? e.from_max : e.max) - t, t = this.toFixed(t - this.coords.p_handle / 100 * t), i = this.toFixed(i - this.coords.p_handle / 100 * i), t += this.coords.p_handle / 2, h.shad_from[0].style.display = "block", h.shad_from[0].style.left = t + "%", h.shad_from[0].style.width = i + "%") : h.shad_from[0].style.display = "none", e.to_shadow && (a || c) ? (s = this.convertToPercent(a ? e.to_min : e.min), o = this.convertToPercent(c ? e.to_max : e.max) - s, s = this.toFixed(s - this.coords.p_handle / 100 * s), o = this.toFixed(o - this.coords.p_handle / 100 * o), s += this.coords.p_handle / 2, h.shad_to[0].style.display = "block", h.shad_to[0].style.left = s + "%", h.shad_to[0].style.width = o + "%") : h.shad_to[0].style.display = "none")
        }, writeToInput: function () {
            "single" === this.options.type ? (this.options.values.length ? this.$cache.input.prop("value", this.result.from_value) : this.$cache.input.prop("value", this.result.from), this.$cache.input.data("from", this.result.from)) : (this.options.values.length ? this.$cache.input.prop("value", this.result.from_value + this.options.input_values_separator + this.result.to_value) : this.$cache.input.prop("value", this.result.from + this.options.input_values_separator + this.result.to), this.$cache.input.data("from", this.result.from), this.$cache.input.data("to", this.result.to))
        }, callOnStart: function () {
            this.writeToInput(), this.options.onStart && "function" == typeof this.options.onStart && (this.options.scope ? this.options.onStart.call(this.options.scope, this.result) : this.options.onStart(this.result))
        }, callOnChange: function () {
            this.writeToInput(), this.options.onChange && "function" == typeof this.options.onChange && (this.options.scope ? this.options.onChange.call(this.options.scope, this.result) : this.options.onChange(this.result))
        }, callOnFinish: function () {
            this.writeToInput(), this.options.onFinish && "function" == typeof this.options.onFinish && (this.options.scope ? this.options.onFinish.call(this.options.scope, this.result) : this.options.onFinish(this.result))
        }, callOnUpdate: function () {
            this.writeToInput(), this.options.onUpdate && "function" == typeof this.options.onUpdate && (this.options.scope ? this.options.onUpdate.call(this.options.scope, this.result) : this.options.onUpdate(this.result))
        }, toggleInput: function () {
            this.$cache.input.toggleClass("irs-hidden-input"), this.has_tab_index ? this.$cache.input.prop("tabindex", -1) : this.$cache.input.removeProp("tabindex"), this.has_tab_index = !this.has_tab_index
        }, convertToPercent: function (t, i) {
            var s, o = this.options.max - this.options.min, e = o / 100;
            return o ? (s = (i ? t : t - this.options.min) / e, this.toFixed(s)) : (this.no_diapason = !0, 0)
        }, convertToValue: function (t) {
            var i, s, o = this.options.min, e = this.options.max, h = o.toString().split(".")[1],
                r = e.toString().split(".")[1], n = 0, a = 0;
            if (0 === t) return this.options.min;
            if (100 === t) return this.options.max;
            h && (n = i = h.length), r && (n = s = r.length), i && s && (n = i >= s ? i : s), o < 0 && (o = +(o + (a = Math.abs(o))).toFixed(n), e = +(e + a).toFixed(n));
            var c, l = (e - o) / 100 * t + o, _ = this.options.step.toString().split(".")[1];
            return _ ? l = +l.toFixed(_.length) : (l /= this.options.step, l = +(l *= this.options.step).toFixed(0)), a && (l -= a), (c = _ ? +l.toFixed(_.length) : this.toFixed(l)) < this.options.min ? c = this.options.min : c > this.options.max && (c = this.options.max), c
        }, calcWithStep: function (t) {
            var i = Math.round(t / this.coords.p_step) * this.coords.p_step;
            return i > 100 && (i = 100), 100 === t && (i = 100), this.toFixed(i)
        }, checkMinInterval: function (t, i, s) {
            var o, e, h = this.options;
            return h.min_interval ? (o = this.convertToValue(t), e = this.convertToValue(i), "from" === s ? e - o < h.min_interval && (o = e - h.min_interval) : o - e < h.min_interval && (o = e + h.min_interval), this.convertToPercent(o)) : t
        }, checkMaxInterval: function (t, i, s) {
            var o, e, h = this.options;
            return h.max_interval ? (o = this.convertToValue(t), e = this.convertToValue(i), "from" === s ? e - o > h.max_interval && (o = e - h.max_interval) : o - e > h.max_interval && (o = e + h.max_interval), this.convertToPercent(o)) : t
        }, checkDiapason: function (t, i, s) {
            var o = this.convertToValue(t), e = this.options;
            return "number" != typeof i && (i = e.min), "number" != typeof s && (s = e.max), o < i && (o = i), o > s && (o = s), this.convertToPercent(o)
        }, toFixed: function (t) {
            return +(t = t.toFixed(20))
        }, _prettify: function (t) {
            return this.options.prettify_enabled ? this.options.prettify && "function" == typeof this.options.prettify ? this.options.prettify(t) : this.prettify(t) : t
        }, prettify: function (t) {
            return t.toString().replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g, "$1" + this.options.prettify_separator)
        }, checkEdges: function (t, i) {
            return this.options.force_edges ? (t < 0 ? t = 0 : t > 100 - i && (t = 100 - i), this.toFixed(t)) : this.toFixed(t)
        }, validate: function () {
            var t, i, s = this.options, o = this.result, e = s.values, h = e.length;
            if ("string" == typeof s.min && (s.min = +s.min), "string" == typeof s.max && (s.max = +s.max), "string" == typeof s.from && (s.from = +s.from), "string" == typeof s.to && (s.to = +s.to), "string" == typeof s.step && (s.step = +s.step), "string" == typeof s.from_min && (s.from_min = +s.from_min), "string" == typeof s.from_max && (s.from_max = +s.from_max), "string" == typeof s.to_min && (s.to_min = +s.to_min), "string" == typeof s.to_max && (s.to_max = +s.to_max), "string" == typeof s.grid_num && (s.grid_num = +s.grid_num), s.max < s.min && (s.max = s.min), h) for (s.p_values = [], s.min = 0, s.max = h - 1, s.step = 1, s.grid_num = s.max, s.grid_snap = !0, i = 0; i < h; i++) t = +e[i], isNaN(t) ? t = e[i] : (e[i] = t, t = this._prettify(t)), s.p_values.push(t);
            ("number" != typeof s.from || isNaN(s.from)) && (s.from = s.min), ("number" != typeof s.to || isNaN(s.to)) && (s.to = s.max), "single" === s.type ? (s.from < s.min && (s.from = s.min), s.from > s.max && (s.from = s.max)) : (s.from < s.min && (s.from = s.min), s.from > s.max && (s.from = s.max), s.to < s.min && (s.to = s.min), s.to > s.max && (s.to = s.max), this.update_check.from && (this.update_check.from !== s.from && s.from > s.to && (s.from = s.to), this.update_check.to !== s.to && s.to < s.from && (s.to = s.from)), s.from > s.to && (s.from = s.to), s.to < s.from && (s.to = s.from)), ("number" != typeof s.step || isNaN(s.step) || !s.step || s.step < 0) && (s.step = 1), "number" == typeof s.from_min && s.from < s.from_min && (s.from = s.from_min), "number" == typeof s.from_max && s.from > s.from_max && (s.from = s.from_max), "number" == typeof s.to_min && s.to < s.to_min && (s.to = s.to_min), "number" == typeof s.to_max && s.from > s.to_max && (s.to = s.to_max), o && (o.min !== s.min && (o.min = s.min), o.max !== s.max && (o.max = s.max), (o.from < o.min || o.from > o.max) && (o.from = s.from), (o.to < o.min || o.to > o.max) && (o.to = s.to)), ("number" != typeof s.min_interval || isNaN(s.min_interval) || !s.min_interval || s.min_interval < 0) && (s.min_interval = 0), ("number" != typeof s.max_interval || isNaN(s.max_interval) || !s.max_interval || s.max_interval < 0) && (s.max_interval = 0), s.min_interval && s.min_interval > s.max - s.min && (s.min_interval = s.max - s.min), s.max_interval && s.max_interval > s.max - s.min && (s.max_interval = s.max - s.min)
        }, decorate: function (t, i) {
            var s = "", o = this.options;
            return o.prefix && (s += o.prefix), s += t, o.max_postfix && (o.values.length && t === o.p_values[o.max] ? (s += o.max_postfix, o.postfix && (s += " ")) : i === o.max && (s += o.max_postfix, o.postfix && (s += " "))), o.postfix && (s += o.postfix), s
        }, updateFrom: function () {
            this.result.from = this.options.from, this.result.from_percent = this.convertToPercent(this.result.from), this.result.from_pretty = this._prettify(this.result.from), this.options.values && (this.result.from_value = this.options.values[this.result.from])
        }, updateTo: function () {
            this.result.to = this.options.to, this.result.to_percent = this.convertToPercent(this.result.to), this.result.to_pretty = this._prettify(this.result.to), this.options.values && (this.result.to_value = this.options.values[this.result.to])
        }, updateResult: function () {
            this.result.min = this.options.min, this.result.max = this.options.max, this.updateFrom(), this.updateTo()
        }, appendGrid: function () {
            if (this.options.grid) {
                var t, i, s, o, e, h = this.options, r = h.max - h.min, n = h.grid_num, a = 0, c = 0, l = 4, _ = "";
                for (this.calcGridMargin(), h.grid_snap ? r > 50 ? (n = 50 / h.step, a = this.toFixed(h.step / .5)) : (n = r / h.step, a = this.toFixed(h.step / (r / 100))) : a = this.toFixed(100 / n), n > 4 && (l = 3), n > 7 && (l = 2), n > 14 && (l = 1), n > 28 && (l = 0), t = 0; t < n + 1; t++) {
                    for (s = l, (c = this.toFixed(a * t)) > 100 && (c = 100), this.coords.big[t] = c, o = (c - a * (t - 1)) / (s + 1), i = 1; i <= s && 0 !== c; i++) _ += '<span class="irs-grid-pol small" style="left: ' + this.toFixed(c - o * i) + '%"></span>';
                    _ += '<span class="irs-grid-pol" style="left: ' + c + '%"></span>', e = this.convertToValue(c), _ += '<span class="irs-grid-text js-grid-text-' + t + '" style="left: ' + c + '%">' + (e = h.values.length ? h.p_values[e] : this._prettify(e)) + "</span>"
                }
                this.coords.big_num = Math.ceil(n + 1), this.$cache.cont.addClass("irs-with-grid"), this.$cache.grid.html(_), this.cacheGridLabels()
            }
        }, cacheGridLabels: function () {
            var t, i, s = this.coords.big_num;
            for (i = 0; i < s; i++) t = this.$cache.grid.find(".js-grid-text-" + i), this.$cache.grid_labels.push(t);
            this.calcGridLabels()
        }, calcGridLabels: function () {
            var t, i, s = [], o = [], e = this.coords.big_num;
            for (t = 0; t < e; t++) this.coords.big_w[t] = this.$cache.grid_labels[t].outerWidth(!1), this.coords.big_p[t] = this.toFixed(this.coords.big_w[t] / this.coords.w_rs * 100), this.coords.big_x[t] = this.toFixed(this.coords.big_p[t] / 2), s[t] = this.toFixed(this.coords.big[t] - this.coords.big_x[t]), o[t] = this.toFixed(s[t] + this.coords.big_p[t]);
            for (this.options.force_edges && (s[0] < -this.coords.grid_gap && (s[0] = -this.coords.grid_gap, o[0] = this.toFixed(s[0] + this.coords.big_p[0]), this.coords.big_x[0] = this.coords.grid_gap), o[e - 1] > 100 + this.coords.grid_gap && (o[e - 1] = 100 + this.coords.grid_gap, s[e - 1] = this.toFixed(o[e - 1] - this.coords.big_p[e - 1]), this.coords.big_x[e - 1] = this.toFixed(this.coords.big_p[e - 1] - this.coords.grid_gap))), this.calcGridCollision(2, s, o), this.calcGridCollision(4, s, o), t = 0; t < e; t++) i = this.$cache.grid_labels[t][0], this.coords.big_x[t] !== Number.POSITIVE_INFINITY && (i.style.marginLeft = -this.coords.big_x[t] + "%")
        }, calcGridCollision: function (t, i, s) {
            var o, e, h, r = this.coords.big_num;
            for (o = 0; o < r && !((e = o + t / 2) >= r); o += t) h = this.$cache.grid_labels[e][0], s[o] <= i[e] ? h.style.visibility = "visible" : h.style.visibility = "hidden"
        }, calcGridMargin: function () {
            this.options.grid_margin && (this.coords.w_rs = this.$cache.rs.outerWidth(!1), this.coords.w_rs && ("single" === this.options.type ? this.coords.w_handle = this.$cache.s_single.outerWidth(!1) : this.coords.w_handle = this.$cache.s_from.outerWidth(!1), this.coords.p_handle = this.toFixed(this.coords.w_handle / this.coords.w_rs * 100), this.coords.grid_gap = this.toFixed(this.coords.p_handle / 2 - .1), this.$cache.grid[0].style.width = this.toFixed(100 - this.coords.p_handle) + "%", this.$cache.grid[0].style.left = this.coords.grid_gap + "%"))
        }, update: function (i) {
            this.input && (this.is_update = !0, this.options.from = this.result.from, this.options.to = this.result.to, this.update_check.from = this.result.from, this.update_check.to = this.result.to, this.options = t.extend(this.options, i), this.validate(), this.updateResult(i), this.toggleInput(), this.remove(), this.init(!0))
        }, reset: function () {
            this.input && (this.updateResult(), this.update())
        }, destroy: function () {
            this.input && (this.toggleInput(), this.$cache.input.prop("readonly", !1), t.data(this.input, "ionRangeSlider", null), this.remove(), this.input = null, this.options = null)
        }
    }, t.fn.ionRangeSlider = function (i) {
        return this.each(function () {
            t.data(this, "ionRangeSlider") || t.data(this, "ionRangeSlider", new c(this, i, n++))
        })
    }, function () {
        for (var t = 0, i = ["ms", "moz", "webkit", "o"], o = 0; o < i.length && !s.requestAnimationFrame; ++o) s.requestAnimationFrame = s[i[o] + "RequestAnimationFrame"], s.cancelAnimationFrame = s[i[o] + "CancelAnimationFrame"] || s[i[o] + "CancelRequestAnimationFrame"];
        s.requestAnimationFrame || (s.requestAnimationFrame = function (i, o) {
            var e = (new Date).getTime(), h = Math.max(0, 16 - (e - t)), r = s.setTimeout(function () {
                i(e + h)
            }, h);
            return t = e + h, r
        }), s.cancelAnimationFrame || (s.cancelAnimationFrame = function (t) {
            clearTimeout(t)
        })
    }()
});

/**
 * jQuery CSS Customizable Scrollbar
 */
!function (l, e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : e(l.jQuery)
}(this, function (l) {
    "use strict";

    function e(e) {
        if (t.webkit && !e) return {height: 0, width: 0};
        if (!t.data.outer) {
            var o = {
                border: "none",
                "box-sizing": "content-box",
                height: "200px",
                margin: "0",
                padding: "0",
                width: "200px"
            };
            t.data.inner = l("<div>").css(l.extend({}, o)), t.data.outer = l("<div>").css(l.extend({
                left: "-1000px",
                overflow: "scroll",
                position: "absolute",
                top: "-1000px"
            }, o)).append(t.data.inner).appendTo("body")
        }
        return t.data.outer.scrollLeft(1e3).scrollTop(1e3), {
            height: Math.ceil(t.data.outer.offset().top - t.data.inner.offset().top || 0),
            width: Math.ceil(t.data.outer.offset().left - t.data.inner.offset().left || 0)
        }
    }

    function o() {
        var l = e(!0);
        return !(l.height || l.width)
    }

    function s(l) {
        var e = l.originalEvent;
        return e.axis && e.axis === e.HORIZONTAL_AXIS ? !1 : e.wheelDeltaX ? !1 : !0
    }

    var r = !1, t = {
        data: {index: 0, name: "scrollbar"},
        macosx: /mac/i.test(navigator.platform),
        mobile: /android|webos|iphone|ipad|ipod|blackberry/i.test(navigator.userAgent),
        overlay: null,
        scroll: null,
        scrolls: [],
        webkit: /webkit/i.test(navigator.userAgent) && !/edge\/\d+/i.test(navigator.userAgent)
    };
    t.scrolls.add = function (l) {
        this.remove(l).push(l)
    }, t.scrolls.remove = function (e) {
        for (; l.inArray(e, this) >= 0;) this.splice(l.inArray(e, this), 1);
        return this
    };
    var i = {
        autoScrollSize: !0,
        autoUpdate: !0,
        debug: !1,
        disableBodyScroll: !1,
        duration: 200,
        ignoreMobile: !1,
        ignoreOverlay: !1,
        scrollStep: 30,
        showArrows: !1,
        stepScrolling: !0,
        scrollx: null,
        scrolly: null,
        onDestroy: null,
        onInit: null,
        onScroll: null,
        onUpdate: null
    }, n = function (s) {
        t.scroll || (t.overlay = o(), t.scroll = e(), a(), l(window).resize(function () {
            var l = !1;
            if (t.scroll && (t.scroll.height || t.scroll.width)) {
                var o = e();
                (o.height !== t.scroll.height || o.width !== t.scroll.width) && (t.scroll = o, l = !0)
            }
            a(l)
        })), this.container = s, this.namespace = ".scrollbar_" + t.data.index++, this.options = l.extend({}, i, window.jQueryScrollbarOptions || {}), this.scrollTo = null, this.scrollx = {}, this.scrolly = {}, s.data(t.data.name, this), t.scrolls.add(this)
    };
    n.prototype = {
        destroy: function () {
            if (this.wrapper) {
                this.container.removeData(t.data.name), t.scrolls.remove(this);
                var e = this.container.scrollLeft(), o = this.container.scrollTop();
                this.container.insertBefore(this.wrapper).css({
                    height: "",
                    margin: "",
                    "max-height": ""
                }).removeClass("scroll-content scroll-scrollx_visible scroll-scrolly_visible").off(this.namespace).scrollLeft(e).scrollTop(o), this.scrollx.scroll.removeClass("scroll-scrollx_visible").find("div").andSelf().off(this.namespace), this.scrolly.scroll.removeClass("scroll-scrolly_visible").find("div").andSelf().off(this.namespace), this.wrapper.remove(), l(document).add("body").off(this.namespace), l.isFunction(this.options.onDestroy) && this.options.onDestroy.apply(this, [this.container])
            }
        }, init: function (e) {
            var o = this, r = this.container, i = this.containerWrapper || r, n = this.namespace,
                c = l.extend(this.options, e || {}), a = {x: this.scrollx, y: this.scrolly}, d = this.wrapper,
                h = {scrollLeft: r.scrollLeft(), scrollTop: r.scrollTop()};
            if (t.mobile && c.ignoreMobile || t.overlay && c.ignoreOverlay || t.macosx && !t.webkit) return !1;
            if (d) i.css({
                height: "auto",
                "margin-bottom": -1 * t.scroll.height + "px",
                "margin-right": -1 * t.scroll.width + "px",
                "max-height": ""
            }); else {
                if (this.wrapper = d = l("<div>").addClass("scroll-wrapper").addClass(r.attr("class")).css("position", "absolute" == r.css("position") ? "absolute" : "relative").insertBefore(r).append(r), r.is("textarea") && (this.containerWrapper = i = l("<div>").insertBefore(r).append(r), d.addClass("scroll-textarea")), i.addClass("scroll-content").css({
                    height: "auto",
                    "margin-bottom": -1 * t.scroll.height + "px",
                    "margin-right": -1 * t.scroll.width + "px",
                    "max-height": ""
                }), r.on("scroll" + n, function (e) {
                    l.isFunction(c.onScroll) && c.onScroll.call(o, {
                        maxScroll: a.y.maxScrollOffset,
                        scroll: r.scrollTop(),
                        size: a.y.size,
                        visible: a.y.visible
                    }, {
                        maxScroll: a.x.maxScrollOffset,
                        scroll: r.scrollLeft(),
                        size: a.x.size,
                        visible: a.x.visible
                    }), a.x.isVisible && a.x.scroll.bar.css("left", r.scrollLeft() * a.x.kx + "px"), a.y.isVisible && a.y.scroll.bar.css("top", r.scrollTop() * a.y.kx + "px")
                }), d.on("scroll" + n, function () {
                    d.scrollTop(0).scrollLeft(0)
                }), c.disableBodyScroll) {
                    var p = function (l) {
                        s(l) ? a.y.isVisible && a.y.mousewheel(l) : a.x.isVisible && a.x.mousewheel(l)
                    };
                    d.on("MozMousePixelScroll" + n, p), d.on("mousewheel" + n, p), t.mobile && d.on("touchstart" + n, function (e) {
                        var o = e.originalEvent.touches && e.originalEvent.touches[0] || e,
                            s = {pageX: o.pageX, pageY: o.pageY}, t = {left: r.scrollLeft(), top: r.scrollTop()};
                        l(document).on("touchmove" + n, function (l) {
                            var e = l.originalEvent.targetTouches && l.originalEvent.targetTouches[0] || l;
                            r.scrollLeft(t.left + s.pageX - e.pageX), r.scrollTop(t.top + s.pageY - e.pageY), l.preventDefault()
                        }), l(document).on("touchend" + n, function () {
                            l(document).off(n)
                        })
                    })
                }
                l.isFunction(c.onInit) && c.onInit.apply(this, [r])
            }
            l.each(a, function (e, t) {
                var i = null, d = 1, h = "x" === e ? "scrollLeft" : "scrollTop", p = c.scrollStep, u = function () {
                    var l = r[h]();
                    r[h](l + p), 1 == d && l + p >= f && (l = r[h]()), -1 == d && f >= l + p && (l = r[h]()), r[h]() == l && i && i()
                }, f = 0;
                t.scroll || (t.scroll = o._getScroll(c["scroll" + e]).addClass("scroll-" + e), c.showArrows && t.scroll.addClass("scroll-element_arrows_visible"), t.mousewheel = function (l) {
                    if (!t.isVisible || "x" === e && s(l)) return !0;
                    if ("y" === e && !s(l)) return a.x.mousewheel(l), !0;
                    var i = -1 * l.originalEvent.wheelDelta || l.originalEvent.detail,
                        n = t.size - t.visible - t.offset;
                    return (i > 0 && n > f || 0 > i && f > 0) && (f += i, 0 > f && (f = 0), f > n && (f = n), o.scrollTo = o.scrollTo || {}, o.scrollTo[h] = f, setTimeout(function () {
                        o.scrollTo && (r.stop().animate(o.scrollTo, 240, "linear", function () {
                            f = r[h]()
                        }), o.scrollTo = null)
                    }, 1)), l.preventDefault(), !1
                }, t.scroll.on("MozMousePixelScroll" + n, t.mousewheel).on("mousewheel" + n, t.mousewheel).on("mouseenter" + n, function () {
                    f = r[h]()
                }), t.scroll.find(".scroll-arrow, .scroll-element_track").on("mousedown" + n, function (s) {
                    if (1 != s.which) return !0;
                    d = 1;
                    var n = {
                        eventOffset: s["x" === e ? "pageX" : "pageY"],
                        maxScrollValue: t.size - t.visible - t.offset,
                        scrollbarOffset: t.scroll.bar.offset()["x" === e ? "left" : "top"],
                        scrollbarSize: t.scroll.bar["x" === e ? "outerWidth" : "outerHeight"]()
                    }, a = 0, v = 0;
                    return l(this).hasClass("scroll-arrow") ? (d = l(this).hasClass("scroll-arrow_more") ? 1 : -1, p = c.scrollStep * d, f = d > 0 ? n.maxScrollValue : 0) : (d = n.eventOffset > n.scrollbarOffset + n.scrollbarSize ? 1 : n.eventOffset < n.scrollbarOffset ? -1 : 0, p = Math.round(.75 * t.visible) * d, f = n.eventOffset - n.scrollbarOffset - (c.stepScrolling ? 1 == d ? n.scrollbarSize : 0 : Math.round(n.scrollbarSize / 2)), f = r[h]() + f / t.kx), o.scrollTo = o.scrollTo || {}, o.scrollTo[h] = c.stepScrolling ? r[h]() + p : f, c.stepScrolling && (i = function () {
                        f = r[h](), clearInterval(v), clearTimeout(a), a = 0, v = 0
                    }, a = setTimeout(function () {
                        v = setInterval(u, 40)
                    }, c.duration + 100)), setTimeout(function () {
                        o.scrollTo && (r.animate(o.scrollTo, c.duration), o.scrollTo = null)
                    }, 1), o._handleMouseDown(i, s)
                }), t.scroll.bar.on("mousedown" + n, function (s) {
                    if (1 != s.which) return !0;
                    var i = s["x" === e ? "pageX" : "pageY"], c = r[h]();
                    return t.scroll.addClass("scroll-draggable"), l(document).on("mousemove" + n, function (l) {
                        var o = parseInt((l["x" === e ? "pageX" : "pageY"] - i) / t.kx, 10);
                        r[h](c + o)
                    }), o._handleMouseDown(function () {
                        t.scroll.removeClass("scroll-draggable"), f = r[h]()
                    }, s)
                }))
            }), l.each(a, function (l, e) {
                var o = "scroll-scroll" + l + "_visible", s = "x" == l ? a.y : a.x;
                e.scroll.removeClass(o), s.scroll.removeClass(o), i.removeClass(o)
            }), l.each(a, function (e, o) {
                l.extend(o, "x" == e ? {
                    offset: parseInt(r.css("left"), 10) || 0,
                    size: r.prop("scrollWidth"),
                    visible: d.width()
                } : {offset: parseInt(r.css("top"), 10) || 0, size: r.prop("scrollHeight"), visible: d.height()})
            }), this._updateScroll("x", this.scrollx), this._updateScroll("y", this.scrolly), l.isFunction(c.onUpdate) && c.onUpdate.apply(this, [r]), l.each(a, function (l, e) {
                var o = "x" === l ? "left" : "top", s = "x" === l ? "outerWidth" : "outerHeight",
                    t = "x" === l ? "width" : "height", i = parseInt(r.css(o), 10) || 0, n = e.size, a = e.visible + i,
                    d = e.scroll.size[s]() + (parseInt(e.scroll.size.css(o), 10) || 0);
                c.autoScrollSize && (e.scrollbarSize = parseInt(d * a / n, 10), e.scroll.bar.css(t, e.scrollbarSize + "px")), e.scrollbarSize = e.scroll.bar[s](), e.kx = (d - e.scrollbarSize) / (n - a) || 1, e.maxScrollOffset = n - a
            }), r.scrollLeft(h.scrollLeft).scrollTop(h.scrollTop).trigger("scroll")
        }, _getScroll: function (e) {
            var o = {
                advanced: ['<div class="scroll-element">', '<div class="scroll-element_corner"></div>', '<div class="scroll-arrow scroll-arrow_less"></div>', '<div class="scroll-arrow scroll-arrow_more"></div>', '<div class="scroll-element_outer">', '<div class="scroll-element_size"></div>', '<div class="scroll-element_inner-wrapper">', '<div class="scroll-element_inner scroll-element_track">', '<div class="scroll-element_inner-bottom"></div>', "</div>", "</div>", '<div class="scroll-bar">', '<div class="scroll-bar_body">', '<div class="scroll-bar_body-inner"></div>', "</div>", '<div class="scroll-bar_bottom"></div>', '<div class="scroll-bar_center"></div>', "</div>", "</div>", "</div>"].join(""),
                simple: ['<div class="scroll-element">', '<div class="scroll-element_outer">', '<div class="scroll-element_size"></div>', '<div class="scroll-element_track"></div>', '<div class="scroll-bar"></div>', "</div>", "</div>"].join("")
            };
            return o[e] && (e = o[e]), e || (e = o.simple), e = "string" == typeof e ? l(e).appendTo(this.wrapper) : l(e), l.extend(e, {
                bar: e.find(".scroll-bar"),
                size: e.find(".scroll-element_size"),
                track: e.find(".scroll-element_track")
            }), e
        }, _handleMouseDown: function (e, o) {
            var s = this.namespace;
            return l(document).on("blur" + s, function () {
                l(document).add("body").off(s), e && e()
            }), l(document).on("dragstart" + s, function (l) {
                return l.preventDefault(), !1
            }), l(document).on("mouseup" + s, function () {
                l(document).add("body").off(s), e && e()
            }), l("body").on("selectstart" + s, function (l) {
                return l.preventDefault(), !1
            }), o && o.preventDefault(), !1
        }, _updateScroll: function (e, o) {
            var s = this.container, r = this.containerWrapper || s, i = "scroll-scroll" + e + "_visible",
                n = "x" === e ? this.scrolly : this.scrollx,
                c = parseInt(this.container.css("x" === e ? "left" : "top"), 10) || 0, a = this.wrapper, d = o.size,
                h = o.visible + c;
            o.isVisible = d - h > 1, o.isVisible ? (o.scroll.addClass(i), n.scroll.addClass(i), r.addClass(i)) : (o.scroll.removeClass(i), n.scroll.removeClass(i), r.removeClass(i)), "y" === e && (s.is("textarea") || h > d ? r.css({
                height: h + t.scroll.height + "px",
                "max-height": "none"
            }) : r.css({"max-height": h + t.scroll.height + "px"})), (o.size != s.prop("scrollWidth") || n.size != s.prop("scrollHeight") || o.visible != a.width() || n.visible != a.height() || o.offset != (parseInt(s.css("left"), 10) || 0) || n.offset != (parseInt(s.css("top"), 10) || 0)) && (l.extend(this.scrollx, {
                offset: parseInt(s.css("left"), 10) || 0,
                size: s.prop("scrollWidth"),
                visible: a.width()
            }), l.extend(this.scrolly, {
                offset: parseInt(s.css("top"), 10) || 0,
                size: this.container.prop("scrollHeight"),
                visible: a.height()
            }), this._updateScroll("x" === e ? "y" : "x", n))
        }
    };
    var c = n;
    l.fn.scrollbar = function (e, o) {
        return "string" != typeof e && (o = e, e = "init"), "undefined" == typeof o && (o = []), l.isArray(o) || (o = [o]), this.not("body, .scroll-wrapper").each(function () {
            var s = l(this), r = s.data(t.data.name);
            (r || "init" === e) && (r || (r = new c(s)), r[e] && r[e].apply(r, o))
        }), this
    }, l.fn.scrollbar.options = i;
    var a = function () {
        var l = 0, e = 0;
        return function (o) {
            var s, i, n, c, d, h, p;
            for (s = 0; s < t.scrolls.length; s++) c = t.scrolls[s], i = c.container, n = c.options, d = c.wrapper, h = c.scrollx, p = c.scrolly, (o || n.autoUpdate && d && d.is(":visible") && (i.prop("scrollWidth") != h.size || i.prop("scrollHeight") != p.size || d.width() != h.visible || d.height() != p.visible)) && (c.init(), n.debug && (window.console && console.log({
                scrollHeight: i.prop("scrollHeight") + ":" + c.scrolly.size,
                scrollWidth: i.prop("scrollWidth") + ":" + c.scrollx.size,
                visibleHeight: d.height() + ":" + c.scrolly.visible,
                visibleWidth: d.width() + ":" + c.scrollx.visible
            }, !0), e++));
            r && e > 10 ? (window.console && console.log("Scroll updates exceed 10"), a = function () {
            }) : (clearTimeout(l), l = setTimeout(a, 300))
        }
    }();
    window.angular && !function (l) {
        l.module("jQueryScrollbar", []).provider("jQueryScrollbar", function () {
            var e = i;
            return {
                setOptions: function (o) {
                    l.extend(e, o)
                }, $get: function () {
                    return {options: l.copy(e)}
                }
            }
        }).directive("jqueryScrollbar", ["jQueryScrollbar", "$parse", function (l, e) {
            return {
                restrict: "AC", link: function (o, s, r) {
                    var t = e(r.jqueryScrollbar), i = t(o);
                    s.scrollbar(i || l.options).on("$destroy", function () {
                        s.scrollbar("destroy")
                    })
                }
            }
        }])
    }(window.angular)
});


/* Loaders */
!function (t) {
    var a = "spinner-circle";
    t.mlsAjax = {
        preloaderShow: function (t) {
            "frame" == t.type && t.frame.attr("data-loader-frame", "1").append('<i class="' + a + '"><div class="lds-ripple"><div></div><div></div></div></i>'), "text" == t.type && t.frame.html(t.frame.data("loader"))
        },
        preloaderHide: function () {
            t("[data-loader-frame]").removeAttr("data-loader-frame").find("." + a).remove()
        }
    }
}($);


/*!
 * jQuery Cookie Plugin v1.4.1
 */
!function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (e) {
    var n = /\+/g;

    function o(e) {
        return t.raw ? e : encodeURIComponent(e)
    }

    function i(e) {
        return o(t.json ? JSON.stringify(e) : String(e))
    }

    function r(o, i) {
        var r = t.raw ? o : function (e) {
            0 === e.indexOf('"') && (e = e.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
            try {
                return e = decodeURIComponent(e.replace(n, " ")), t.json ? JSON.parse(e) : e
            } catch (e) {
            }
        }(o);
        return e.isFunction(i) ? i(r) : r
    }

    var t = e.cookie = function (n, c, u) {
        if (arguments.length > 1 && !e.isFunction(c)) {
            if ("number" == typeof (u = e.extend({}, t.defaults, u)).expires) {
                var s = u.expires, a = u.expires = new Date;
                a.setMilliseconds(a.getMilliseconds() + 864e5 * s)
            }
            return document.cookie = [o(n), "=", i(c), u.expires ? "; expires=" + u.expires.toUTCString() : "", u.path ? "; path=" + u.path : "", u.domain ? "; domain=" + u.domain : "", u.secure ? "; secure" : ""].join("")
        }
        for (var d, f = n ? void 0 : {}, p = document.cookie ? document.cookie.split("; ") : [], l = 0, m = p.length; l < m; l++) {
            var x = p[l].split("="), g = (d = x.shift(), t.raw ? d : decodeURIComponent(d)), v = x.join("=");
            if (n === g) {
                f = r(v, c);
                break
            }
            n || void 0 === (v = r(v)) || (f[g] = v)
        }
        return f
    };
    t.defaults = {}, e.removeCookie = function (n, o) {
        return e.cookie(n, "", e.extend({}, o, {expires: -1})), !e.cookie(n)
    }
});


/*! PLUGIN :: lozad.js - v1.15.0 - 2020-05-23 */
!function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : t.lozad = e()
}(this, function () {
    "use strict";
    /**
     * Detect IE browser
     * @const {boolean}
     * @private
     */var u = "undefined" != typeof document && document.documentMode, c = {
        rootMargin: "0px", threshold: 0, load: function (t) {
            if ("picture" === t.nodeName.toLowerCase()) {
                var e = document.createElement("img");
                u && t.getAttribute("data-iesrc") && (e.src = t.getAttribute("data-iesrc")), t.getAttribute("data-alt") && (e.alt = t.getAttribute("data-alt")), t.append(e)
            }
            if ("video" === t.nodeName.toLowerCase() && !t.getAttribute("data-src") && t.children) {
                for (var r = t.children, a = void 0, i = 0; i <= r.length - 1; i++) (a = r[i].getAttribute("data-src")) && (r[i].src = a);
                t.load()
            }
            t.getAttribute("data-poster") && (t.poster = t.getAttribute("data-poster")), t.getAttribute("data-src") && (t.src = t.getAttribute("data-src")), t.getAttribute("data-srcset") && t.setAttribute("srcset", t.getAttribute("data-srcset"));
            var o = ",";
            if (t.getAttribute("data-background-delimiter") && (o = t.getAttribute("data-background-delimiter")), t.getAttribute("data-background-image")) t.style.backgroundImage = "url('" + t.getAttribute("data-background-image").split(o).join("'),url('") + "')"; else if (t.getAttribute("data-background-image-set")) {
                var n = t.getAttribute("data-background-image-set").split(o),
                    d = n[0].substr(0, n[0].indexOf(" ")) || n[0];// Substring before ... 1x
                d = -1 === d.indexOf("url(") ? "url(" + d + ")" : d, 1 === n.length ? t.style.backgroundImage = d : t.setAttribute("style", (t.getAttribute("style") || "") + "background-image: " + d + "; background-image: -webkit-image-set(" + n + "); background-image: image-set(" + n + ")")
            }
            t.getAttribute("data-toggle-class") && t.classList.toggle(t.getAttribute("data-toggle-class"))
        }, loaded: function () {
        }
    };

    function l(t) {
        t.setAttribute("data-loaded", !0)
    }

    var b = function (t) {
        return "true" === t.getAttribute("data-loaded")
    };
    return function () {
        var r, a, i = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : ".lozad",
            t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {}, e = Object.assign({}, c, t),
            o = e.root, n = e.rootMargin, d = e.threshold, u = e.load, g = e.loaded, s = void 0;
        return "undefined" != typeof window && window.IntersectionObserver && (s = new IntersectionObserver((r = u, a = g, function (t, e) {
            t.forEach(function (t) {
                (0 < t.intersectionRatio || t.isIntersecting) && (e.unobserve(t.target), b(t.target) || (r(t.target), l(t.target), a(t.target)))
            })
        }), {root: o, rootMargin: n, threshold: d})), {
            observe: function () {
                for (var t = function (t) {
                    var e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : document;
                    return t instanceof Element ? [t] : t instanceof NodeList ? t : e.querySelectorAll(t)
                }(i, o), e = 0; e < t.length; e++) b(t[e]) || (s ? s.observe(t[e]) : (u(t[e]), l(t[e]), g(t[e])))
            }, triggerLoad: function (t) {
                b(t) || (u(t), l(t), g(t))
            }, observer: s
        }
    }
});


/*
Копировние в буфер обмена
 */
function copyClipboard($from) {
    var $copyText = document.querySelector($from);
    $copyText.select();
    $copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    $copyText.classList.add("copy--success");
    setTimeout(function () {
        $copyText.classList.remove("copy--success");
    }, 500);
}

function copyToClipboardFromElement(text, element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    var $status = document.execCommand("copy");
    $temp.remove();

    $(element).addClass('type--copysuccess');
    setTimeout(function(){
        $(element).removeClass('type--copysuccess');
    }, 4000);

    return $status;
}


// Simple JavaScript Templating @ John Resig
!function () {
    var t = {};
    this.tmpl = function n(p, i) {
        var e = /\W/.test(p) ? new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" + p.replace(/[\r\t\n]/g, " ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'") + "');}return p.join('');") : t[p] = t[p] || n(document.getElementById(p).innerHTML);
        return i ? e(i) : e
    }
}();


//Init
(function ($) {
    "use strict";
    jQuery(function () {
        var $document = $(document);
        var $body = $('#body');
        var $headerWrapHeight = $('#fn_header_wrap').height();

        /*
		Откладываем CSS анимацию до полной загрузки страницы
		 */
        $body.removeClass('load--preload');


        /*
        Меню в шапке закрепляем
         */
        var $headerNavFixMove = false;
        var __headerNavFix = function ($scrolltop) {
            if (window.matchMedia('(min-width: 869px)').matches) {
                if ($scrolltop > $headerWrapHeight) {
                    if (!$headerNavFixMove) {
                        $body.addClass('nav--fixed');
                        $document.trigger('click.notice_box');
                    }
                    $headerNavFixMove = true;
                } else {
                    if ($headerNavFixMove) {
                        $body.removeClass('nav--fixed');
                        $document.trigger('click.notice_box');
                    }
                    $headerNavFixMove = false;
                }
            }
        }
        __headerNavFix($(window).scrollTop());

        /*
        Панелька иконок
         */
        var $floatflySelectMove = false;
        var $floatflySelectStart = $('.fb_container_products');
        if ($floatflySelectStart.length) {
            var $floatflySelectStartTop = $floatflySelectStart.offset().top;
            var __floatflySelectFix = function ($scrolltop) {
                if ($scrolltop > $floatflySelectStartTop) {
                    if (!$floatflySelectMove) $body.addClass('floatfly--show');
                    $floatflySelectMove = true;
                } else {
                    if ($floatflySelectMove) $body.removeClass('floatfly--show');
                    $floatflySelectMove = false;
                }
            }
        }

        /*
        Кнопка наверх
         */
        var $scrollupMove = false;
        var __scrollUpFix = function ($scrolltop) {
            if ($scrolltop > 500) {
                if (!$scrollupMove) $scrollup.addClass('type--show');
                $scrollupMove = true;
            } else {
                if ($scrollupMove) $scrollup.removeClass('type--show');
                $scrollupMove = false;
            }
        }

        /*
        Скролл страницы наверх
         */
        var $scrollup = $("#fn_scrollup");
        var timerScrollup;
        $(window).scroll(function () {
            if (timerScrollup) clearTimeout(timerScrollup);
            timerScrollup = setTimeout(function (e) {

                var $scrolltop = $(window).scrollTop();

                __scrollUpFix($scrolltop);

                __headerNavFix($scrolltop);

                if (typeof __floatflySelectFix === "function") {
                    __floatflySelectFix($scrolltop);
                }

            }, 50);
        });
        $scrollup.click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });


        /*
        Шапка - Всплывающие окна для адаптива и других частей
         */
        $('.fn_close_switch, [data-btn-dropclose]').click(function (e) {
            e.preventDefault();
            $body.removeAttr('data-dropshow');
        });

        $document.on('click', '[data-btn-dropshow]', function (e) {
            e.preventDefault();
            var $this = $(this);
            var $dropshow = $this.attr('data-btn-dropshow');

            if ($body.attr('data-dropshow') === $dropshow) {
                $body.removeAttr('data-dropshow');
            } else {
                if (window.matchMedia('(min-width: 869px)').matches) {
                    $body.css({'max-width': $('.wraps').width()});
                }
                $body.attr('data-dropshow', $dropshow);
            }
        });


        /*
        Суб-навигация для адаптива
         */
        $('.header__nav-list .h__nav-link-arrow').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var $wrapNav = $this.closest('li');
            if (!$wrapNav.find('> .h__nav-sub').length) {
                return true;
            }

            $('.header__nav-list .drop--open').not($wrapNav).removeClass('drop--open');

            $wrapNav.toggleClass('drop--open');
        });


        /*
        Включаем жирный фокус для клавиатурщиков
         */
        var $focusEnable = false;
        $body.on('keyup.focus_disabled', function (e) {
            var code = e.keyCode || e.which;
            if (Number(code) === 9) {
                $focusEnable = true;
                $body.removeClass('focus-disabled');
                $body.off('keyup.focus_disabled');
            }
        });


        // Header search autocomplete
        // Fast search
        var $timerBoxSearch;
        $document.on('keyup focus', 'input[data-fastsearch-input]', function () {
            var $this = $(this);
            var $form = $this.closest('[data-fastsearch-form]');
            var $drop = $('[data-fastsearch-drop]');
            $drop.removeClass('type--scroll');
            clearTimeout($timerBoxSearch);
            $this.removeClass('loader--pending');
            var $val = $this.val();
            if ($val.length >= 3) $form.addClass('loader--pending');

            if ($val !== '') {
                $form.addClass('has--empty-none');
            } else {
                $form.removeClass('has--empty-none');
            }

            var ms = 1000;
            $timerBoxSearch = setTimeout(function () {
                var $query = $this.val();
                if ($query.length >= 3) {
                    var $queryData = $form.serialize();
                    var $boxTpls = false;

                    var _dropShow = function ($data) {
                        $drop.addClass('drop--show');
                        $form.removeClass('loader--pending');

                        var $templateHtml = '';
                        for (var i = 0; i < $data.items.length; i++) {
                            $templateHtml += tmpl("search_item_tmpl", $data.items[i]);
                        }

                        var $searchResults = $('#fn_search_results');
                        $searchResults.html(tmpl("search_items_tmpl", {'items': $templateHtml}));

                        if ($templateHtml !== '') {
                            if (window.matchMedia('(min-width: 869px)').matches) {
                                $searchResults.find(".scrollbar-inner").scrollbar();
                            }
                        }

                        $document.on('click.search_box', function (e) {
                            if ($(e.target).closest('.header__search-drop').length) {
                                return false;
                            }
                            $drop.removeClass('drop--show');
                            $document.off("click.search_box");
                        });
                    };


                    // $.ajax({
                    //     'url' : '/?action=ajax_search&' + $queryData,
                    //     'type' : 'GET',
                    //     'dataType' : "json",
                    //     'success' : function( $responses )
                    //     {
                    //        _dropShow($responses);
                    //     }
                    // });

                    /* ПРИМЕР - ЭМУЛЯЦИЯ AJAX С ЗАДЕРЖКОЙ */
                    setTimeout(function () {

                        var $responses = {
                            'items': [
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU',
                                    'url': '#url-product1',
                                    'image': 'img/blank/account__item-vk.png'
                                },
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': false,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU',
                                    'url': '#url-product3',
                                    'image': 'img/blank/account__item-fb.png'
                                },
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU Аккаунты FB. Ручная регистрация через номер телефона RU ',
                                    'url': '#url-product4',
                                    'image': 'img/blank/product__item-01.jpg'
                                }


                                ,
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU Аккаунты FB. Ручная регистрация через номер телефона RU ',
                                    'url': '#url-product4',
                                    'image': 'img/blank/product__item-01.jpg'
                                },
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU Аккаунты FB. Ручная регистрация через номер телефона RU ',
                                    'url': '#url-product4',
                                    'image': 'img/blank/product__item-01.jpg'
                                },
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU Аккаунты FB. Ручная регистрация через номер телефона RU ',
                                    'url': '#url-product4',
                                    'image': 'img/blank/product__item-01.jpg'
                                },
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU Аккаунты FB. Ручная регистрация через номер телефона RU ',
                                    'url': '#url-product4',
                                    'image': 'img/blank/product__item-01.jpg'
                                },
                                {
                                    'id': 'YOUR_ID_PRODUCT',
                                    'stock': true,
                                    'price': '3242.00',
                                    'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU Аккаунты FB. Ручная регистрация через номер телефона RU ',
                                    'url': '#url-product4',
                                    'image': 'img/blank/product__item-01.jpg'
                                }
                            ]
                        };
                        _dropShow($responses);

                    }, 300);
                    /* END - ПРИМЕР */

                } else {
                    $document.trigger('click.search_box');
                }
            }, ms);
        });

        $document.on("change", "#select-sort", function (e) {
            $("form#search-form input[name=sort]").val(($(this).val()));
            $("form#search-form").trigger("submit");
        });

        $document.on("click", ".in-development", function (e) {
            e.preventDefault();
            alert("Вскоре будет доступно");
        });

        $document.on('submit', '#buy-form', function (e) {
            e.preventDefault();

            // Yandex.Commerce
            try {
                commerceAddToCartFromPurchaseForm($(this));
            } catch (e) {
                console.error(e);
            }

            // Functions
            const buy = () => sendData($(this), function (data) {
                if ("payment_link" in data) {
                    document.location.href = data.payment_link;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ошибка',
                        text: 'Не удалось сформировать платежную ссылку. Пожалуйста, попробуйте выбрать другой метод, или связаться с поддержкой'
                    })
                }
            });
            const handleUnsuccessfulCheck = (data) => {
                let action = {message : null, confirmed : null};

                switch (data.scenario) {
                    case "not_found":
                        action.message = "Товар на данный момент недоступен. Пожалуйста, попробуйте через пару минут";
                        break;
                    case "not_available":
                        action.message = "Товара нет в наличии. Пожалуйста, попробуйте позже";
                        break;
                    case "not_required_amount":
                        action.message = `К сожалению, в наличии осталось ${data.quantity} единиц. Отредактировать число в заказе?`;
                        action.confirmed = () => {
                            let buyQuantity = $("#buy_quantity");
                            buyQuantity.val(data.quantity);
                            buyQuantity.trigger("change");
                        };
                        break;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Ошибка',
                    text: action.message,
                    showDenyButton: action.confirmed !== null,
                    confirmButtonText : action.confirmed !== null ? "Да" : "ОК",
                    denyButtonText : "Нет",
                }).then(result => {
                    if(result.isConfirmed && action.confirmed !== null) {
                        action.confirmed();
                    }
                })
            };

            // Call
            sendData($(this), function (data) {
                data.success ? buy() : handleUnsuccessfulCheck(data);
            }, "/point/order/check")
        });

        $document.on('submit', '#feedback-form', function (e) {
            e.preventDefault();
            sendData($(this), function (data) {
                if ("message" in data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Обращение отправлено',
                        text: data.message
                    });
                    $("#feedback-form").trigger("reset");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ошибка',
                        text: 'Не удалось сформировать платежную ссылку. Пожалуйста, попробуйте позже, или выберите другой метод контакта'
                    })
                }
            });
        });


        $document.on("change", "#buy-form input[name=method]", function () {
            var checked = $("#buy-form input[name=method]:checked");

            var description = checked.data("description") ? `<div class="form__notices">${checked.data("description")}</div>` : null;
            var warning = checked.data("warning") ? `<div class="form__group-info_text">${checked.data("warning")}</div>` : null;

            $("#payment-description").html(description);
            $("#payment-warning").html(warning);
        });

        /* Соглашение */
        $document.on('change', '[data-rules-check]', function () {
            var $this = $(this);
            var $form = $this.parents('form');
            if ($(this).is(':checked')) {
                $form.find('[data-rules-btn]').prop('disabled', false);
                $form.find('[data-rules-error]').hide();
            } else {
                $form.find('[data-rules-btn]').prop('disabled', true);
                $form.find('[data-rules-error]').show();
            }
        });


        /*
        Слайдер серии игр-товаров
         */
        var $caruseleProductsRelated = $('[data-slider="products_related"]');
        if ($caruseleProductsRelated.length) {
            $caruseleProductsRelated.each(function () {
                var $this = $(this);

                var $caruseleItem = $this.find('.product__item');
                for (var i = 0; i < $caruseleItem.length; i += 2) {
                    $caruseleItem.slice(i, i + 2).wrapAll('<div class="product__item-group"></div>');
                }

                $this.on('ready.flickity', function () {
                    $this.find('.flickity-button').insertAfter($this).wrapAll('<div class="flickity__arrw-append"></div>');
                });
                $this.flickity({
                    wrapAround: true,
                    draggable: false,
                    groupCells: true,
                    bgLazyLoad: 1,
                    cellAlign: 'left',
                    contain: true,
                    pageDots: true,
                    prevNextButtons: true,
                    arrowShape: {
                        x0: 10,
                        x1: 50, y1: 40,
                        x2: 60, y2: 30,
                        x3: 30
                    }
                });
            });
        }

        /*
        Слайдер похожих игр-товаров
         */
        var $caruseleProductsSimilar = $('[data-slider="products_similar"]');
        if ($caruseleProductsSimilar.length) {
            $caruseleProductsSimilar.each(function () {
                var $this = $(this);

                var $caruseleItem = $this.find('.product__item');
                for (var i = 0; i < $caruseleItem.length; i += 4) {
                    $caruseleItem.slice(i, i + 4).wrapAll('<div class="product__item-group"></div>');
                }

                $this.on('ready.flickity', function () {
                    $this.find('.flickity-button').insertAfter($this).wrapAll('<div class="flickity__arrw-append"></div>');
                });
                $this.flickity({
                    wrapAround: true,
                    draggable: false,
                    groupCells: true,
                    bgLazyLoad: 1,
                    cellAlign: 'left',
                    contain: true,
                    pageDots: false,
                    prevNextButtons: true,
                    arrowShape: {
                        x0: 10,
                        x1: 50, y1: 40,
                        x2: 60, y2: 30,
                        x3: 30
                    }
                });
            });
        }


        /*
        Слайдер серии аккаунт-товаров
         */
        var $caruseleAccountRelated = $('[data-slider="accounts_related"]');
        if ($caruseleAccountRelated.length) {
            $caruseleAccountRelated.each(function () {
                var $this = $(this);

                var $caruseleItem = $this.find('.account__item');
                for (var i = 0; i < $caruseleItem.length; i += 2) {
                    $caruseleItem.slice(i, i + 2).wrapAll('<div class="account__item-group"></div>');
                }

                $this.on('ready.flickity', function () {
                    $this.find('.flickity-button').insertAfter($this).wrapAll('<div class="flickity__arrw-append"></div>');
                });
                $this.flickity({
                    wrapAround: true,
                    draggable: false,
                    groupCells: true,
                    bgLazyLoad: 1,
                    cellAlign: 'left',
                    contain: true,
                    pageDots: true,
                    prevNextButtons: true,
                    arrowShape: {
                        x0: 10,
                        x1: 50, y1: 40,
                        x2: 60, y2: 30,
                        x3: 30
                    }
                });
            });
        }


        /*
        Полет товара в корзину/избранное
         */
        var $indx = 0;

        function moveProductToCart($moveFrom, $moveTo) {
            $indx++;
            var $productItem = $moveFrom.closest('[data-product-item]');

            var $productFly = $productItem.find('[data-fly]');

            var $productOffset = $productFly.offset();
            var $productWidth = $productFly.width();
            var $productHeight = $productFly.height();

            if ($productFly.length) {
                var imgclone = $productFly.clone()
                    .css({
                        'padding': '0',
                        'top': $productOffset.top,
                        'left': $productOffset.left,
                        'opacity': '0.7',
                        'position': 'absolute',
                        'height': $productHeight,
                        'width': $productWidth,
                        'z-index': '1009',
                        'pointer-events': 'none'
                    })
                    .appendTo($body);

                var $left = ($moveTo.offset().left + $moveTo.width() - $productWidth / 2) - $productOffset.left;
                var $top = ($moveTo.offset().top + 10 - $productHeight / 2) - $productOffset.top;

                setTimeout(function () {
                    imgclone.addClass('run-animate run-animate-' + $indx)
                }, 10);
                var $style = '.run-animate-' + $indx + ' {';
                $style += 'opacity:0 !important;';
                $style += '-moz-transform: translate(' + $left + 'px, ' + $top + 'px) matrix(0.07, 0, 0, 0.07, 0, 0);';
                $style += '-webkit-transform: translate(' + $left + 'px, ' + $top + 'px) matrix(0.07, 0, 0, 0.07, 0, 0);';
                $style += '-o-transform: translate(' + $left + 'px, ' + $top + 'px) matrix(0.07, 0, 0, 0.07, 0, 0);';
                $style += '-ms-transform: translate(' + $left + 'px, ' + $top + 'px) matrix(0.07, 0, 0, 0.07, 0, 0);';
                $style += 'transform: translate(' + $left + 'px, ' + $top + 'px) matrix(0.07, 0, 0, 0.07, 0, 0);';
                $style += '}';

                $('<style>' + $style + '</style>').appendTo('head');

                setTimeout(function () {
                    $moveTo.addClass('anim__tremor');
                }, 1600);
                setTimeout(function () {
                    $moveTo.removeClass('anim__tremor');
                    imgclone.remove();
                }, 1800);
            }
        }


        /*
        Добавление товара в корзину
         */
        $document.on('click', '[data-btn-product-cart]', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var $movoToFind = '.fn_header_cart';
            if (window.matchMedia('(max-width: 869px)').matches) {
                $movoToFind = '.fn_adap_header_cart';
            }
            var $moveTo = $($movoToFind);

            moveProductToCart($btn, $moveTo);

            // AJAX запрос

            $moveTo.addClass('type--add');
            $moveTo.find('.btn--counter').html('10');
        });


        /*
        Добавление товара в избранное
         */
        $document.on('click', '[data-btn-product-fav]', function (e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.hasClass('fav--add')) return;

            $btn.addClass('fav--add');
            var $movoToFind = '.fn_header_fav';
            if (window.matchMedia('(max-width: 869px)').matches) {
                $movoToFind = '.fn_adap_header_fav';
            }
            var $moveTo = $($movoToFind);
            $moveTo.addClass('type--add');
            moveProductToCart($btn, $moveTo);
        });

        /*
        Удаление товара из избранного
         */
        $document.on('click', '.fav--add[data-btn-product-fav]', function (e) {
            e.preventDefault();
            var $btn = $(this);

            $btn.removeClass('fav--add');
        });

        function changeCheckoutTotal(quantity, price)
        {
            let total = quantity * price;
            $("#checkout-total").html(total.toFixed(2));
        }

        /*
        Быстрая покупка товара
         */
        $document.on('click', '[data-btn-product-buy]', function (e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.hasClass('buy--add')) return false;

            var $modalBuy = $('.sidefly.sidefly--buy');

            var $productId = $btn.attr('data-btn-product-buy');
            var $productQuantityInput = $modalBuy.find('#buy_quantity');

            var $data = $btn.data('options');

            var productPrice = $btn.attr('data-btn-product-price');
            var quantity = $productQuantityInput && $productQuantityInput.val() ? $productQuantityInput.val() : 1;

            changeCheckoutTotal(quantity, productPrice);

            if ($data) {
                $.each($data, function ($find, $insert) {
                    if ($insert === 'parent') {
                        $modalBuy.find('[data-buyform="' + $find + '"]').html(
                            $btn.closest('[data-product-item]').find('[data-product-' + $find + ']').text()
                        );
                        return;
                    }
                    $modalBuy.find('[data-buyform="' + $find + '"]').html($insert);
                });
                $modalBuy.find('[data-buyform="id"]').val($productId);
                $('#price-per-item').val(productPrice);
            }
            /* Для программиста */
            else {
                alert('Параметры товара не заданы');
                return false;
            }

            if (window.matchMedia('(min-width: 869px)').matches) {
                $body.css({'max-width': $('.wraps').width()});
            }
            $body.attr('data-dropshow', 'sidefly--buy');
        });

        /*
         Подсчет цены при изменении кол-ва товара
         */
        $document.on("change", "#buy_quantity", function () {
            var pricePerItem = $("#price-per-item").val();
            var orderQuantity = $("#buy_quantity").val();
            changeCheckoutTotal(orderQuantity, pricePerItem);
        });


        /*
        Фильтр - Открыть дополнительные параметры
         */
        $document.on('click', '[data-filter-toggler]', function () {
            var $this = $(this);
            $this.blur();
            var $for = $this.attr('data-filter-toggler');
            var $attach = $($for);

            if ($this.hasClass('current')) {
                $this.removeClass('current');
                $attach.removeClass('show--toggles');//.css({'max-height' : 0});
            } else {
                $this.addClass('current');
                $attach.addClass('show--toggles');//.css({'max-height' : $attach.children().innerHeight()});
            }
        });


        /*
        Фильтр цен в каталоге
         */
        var params = {
            'minPrice': 0,
            'maxPrice': 10000
        };

        var $priceRangeSlider = $('#price-range-slider');
        if ($priceRangeSlider.length) {
            var $priceRangeMin = $('#price-range-min');
            var $priceRangeMax = $('#price-range-max');
            $priceRangeSlider.ionRangeSlider({
                type: "double",
                min: 0,
                max: 10000,
                from: params.minPrice,
                to: params.maxPrice,
                postfix: false,
                step: 50,
                grid: false,
                keyboard: true,
                hide_min_max: false,
                hide_from_to: false,
                onFinish: function (data) {
                    params.minPrice = data.from;
                    params.maxPrice = data.to;
                    $priceRangeMin.prop("value", data.from);
                    $priceRangeMax.prop("value", data.to);
                    return false;
                },
                onStart: function (data) {
                    $priceRangeMin.prop("value", data.from);
                    $priceRangeMax.prop("value", data.to);
                },
                onChange: function (data) {
                    $priceRangeMin.prop("value", data.from);
                    $priceRangeMax.prop("value", data.to);
                }
            });

            var $priceRangeSliderInit = $priceRangeSlider.data("ionRangeSlider");
            $priceRangeSlider.on('submitChange', function () {
                params.minPrice = parseInt($priceRangeMin.val().replace(/\D+/g, ""));
                params.maxPrice = parseInt($priceRangeMax.val().replace(/\D+/g, ""));
                $priceRangeMin.val(params.minPrice);
                $priceRangeMax.val(params.maxPrice);
                $priceRangeSliderInit.update({
                    from: params.minPrice,
                    to: params.maxPrice
                });
            });
            $priceRangeMin.on('keyup', function () {
                $priceRangeSlider.trigger('submitChange');
            });
            $priceRangeMax.on('keyup', function () {
                $priceRangeSlider.trigger('submitChange');
            });
        }

        /*
        Дозагрузка товаров при скролле в каталоге
         */
        var $productPaginator = $('#fn_product_paginator');
        if ($productPaginator.length) {
            var $isAllowPagLoader = true;
            var $timerPagLoader;
            $(window).scroll(function () {
                if ($timerPagLoader) clearTimeout($timerPagLoader);
                $timerPagLoader = setTimeout(function () {
                    if (!$isAllowPagLoader) return;
                    if (($(window).scrollTop() + $(window).height()) > $productPaginator.offset().top) {
                        $isAllowPagLoader = false;

                        console.log('Производим подзагрузку товаров удобным способом, например через ajax с сервера готовым кодом, или же используем js шаблон');

                        $.mlsAjax.preloaderShow({type: "frame", frame: $productPaginator});


                        /*
                        AJAX - Загружаем товара, для наглядности сделаем таймаут 2 секунды
                         */
                        setTimeout(function () {
                            $.mlsAjax.preloaderHide();

                            /*
                            Далее переключаем переменную в true, если страница уже загрузилась
                             */
                            $isAllowPagLoader = true;
                        }, 2000);

                    }
                }, 10);
            });
        }


        /*
        Переключатель отображения фильтра каталога
         */
        var $catalogContainer = $('#fn_catalog_container');
        if ($catalogContainer.length) {
            var rememberTurnOff = function () {
                $.removeCookie("filter_toggles", {path: '/'});
                $.cookie('filter_toggles', false, {expires: 9999, path: '/'});
            };
            var rememberTurnOn = function () {
                $.cookie('filter_toggles', true, {expires: 9999, path: '/'});
            };

            var $getBlockFilter = $.cookie('filter_toggles');
            if ($getBlockFilter !== "false") {
                $('#toggler_side').prop('checked', true);
                $catalogContainer.addClass('filter--show');
            }

            $(document).on("submit", "#search-form", function() {
                rememberTurnOff();
            });

            $document.on('change', '#toggler_side', function () {
                var $this = $(this);
                var $has = $this.is(':checked');

                if ($has) {
                    $catalogContainer.addClass('filter--show');
                    rememberTurnOn();
                } else {
                    $catalogContainer.removeClass('filter--show');
                    rememberTurnOff();
                }
            });
        }

        /*
 * Сброс фильтров в форме
 */

        $(".filter__btn-remove").on("click", function () {

            var $form = $(this).closest('form');
            $form.find('input:checked').prop('checked', false);

            $form.find('input')
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .removeAttr('checked');

            $('select option[value=""]').prop('selected', true);
            $('select').trigger('update');


            $form.find("#price-range-min").val(0);
            $form.find("#price-range-max").val(10000);
            $priceRangeSlider.trigger('submitChange');

            return false;
        });


        /*
        Офомрмление заказа
         */
        $document.on('change', '[data-checkout-promocode="check"]', function () {
            var $this = $(this);
            var $box = $this.closest('[data-checkout-promocode="box"]');
            if ($this.is(':checked')) {
                $box.addClass('promocode--show');
            } else {
                $box.removeClass('promocode--show');
            }
        });


        /*
        Галерея для товара
         */
        var $productImages = $('#product__images');
        if ($productImages.length) {
            var $product__gallery = $productImages.flickity({
                initialIndex: 0,
                cellAlign: 'left',
                prevNextButtons: true,
                arrowShape: {
                    x0: 10,
                    x1: 50, y1: 40,
                    x2: 60, y2: 30,
                    x3: 30
                },
                pageDots: true,
            });

            var $product__galleryNav = $('#product__images-nav');
            var $product__galleryNavCells = $product__galleryNav.find('.product__gallery-item');

            $product__galleryNav.on('click', '.product__gallery-item', function (event) {
                var index = $(event.currentTarget).index();
                $product__gallery.flickity('select', index);
            });

            var flkty = $product__gallery.data('flickity');

            $product__gallery.on('select.flickity', function () {
                $document.trigger('youtube_player_stop');

                var navCellHeight = $product__galleryNavCells.height() + 4;
                var navHeight = $product__galleryNav.height();

                // set selected nav cell
                $product__galleryNav.find('.is-nav-selected').removeClass('is-nav-selected');
                var $selected = $product__galleryNavCells.eq(flkty.selectedIndex)
                    .addClass('is-nav-selected');
                // scroll nav
                var scrollY = $selected.position().top + $product__galleryNav.scrollTop() - (navHeight + navCellHeight) / 4;
                $product__galleryNav.animate({
                    scrollTop: scrollY
                });
            });

            $product__gallery.on('dragStart.flickity', function () {
                $product__gallery.find('a').css({pointerEvents: 'none'});
            });
            $product__gallery.on('dragEnd.flickity', function () {
                $product__gallery.find('a').css({pointerEvents: 'all'});
            });
        }


        $document.on('click', '[data-btn-youtube-play]', function () {
            var $this = $(this);
            var $code = $this.attr('data-btn-youtube-play');
            var $replace = $this.closest('[data-btn-youtube-inject]');
            var $iframe = $('<iframe />').attr({
                'width': $replace.width(),
                'height': $replace.height(),
                'src': "https://www.youtube.com/embed/" + $code + "?autoplay=1&version=3&enablejsapi=1",
                'frameborder': 0,
                "allow": "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture",
                "allowfullscreen": "allowfullscreen",
            });

            $iframe.appendTo($replace.html(""));
            $document.on('youtube_player_stop', function () {
                $iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            });
        });


        /*
        Перенос блока related товаров вниз при адаптиве
         */
        if (window.matchMedia('(max-width: 869px)').matches) {
            var $fn_adap_move_related__product = $('#fn_adap_move_related__block');
            if ($fn_adap_move_related__product.length) {
                $fn_adap_move_related__product.appendTo('.page__width');
            }
        }


        /*
        Ленивая загрузка изображений
         */
        if ($('[data-background-image]').length) {
            var observer = lozad('[data-background-image]', {
                threshold: 0.1
            });
            observer.observe();
        }

        if ($('.lozad').length) {
            const observer2 = lozad('.lozad', {
                threshold: 0.1
            });
            observer2.observe();
        }


        /*
        Селект - стилиация
         */
        $document.on('style-select-refresh', function () {
            $('.fn_input_select:not(.init-style)').each(function () {
                var $this = $(this);
                $this.addClass('init-style');
                $this.wrap('<div data-ostyle-select="wrap" class="input__select"></div>');

                var $selectTitle = $('<div data-ostyle-select="title" class="input__select-title" tabindex="0">123</div>');
                $selectTitle.insertAfter($this);

                var _chooses = function () {
                    var $optionTpl = [];
                    var $optionSelect = $this.find('option:selected');

                    var $optionIcon = $optionSelect.attr('data-icon');
                    if ($optionIcon) {
                        $optionTpl.push('<span class="option--icon" style="background-image: url(' + $optionIcon + ')"></span>');
                    }

                    $optionTpl.push('<span class="option--label">' + $optionSelect.html() + '</span>');

                    $selectTitle.html($optionTpl.join(''));
                }

                $this.on('change update', function () {
                    _chooses();
                });
                _chooses();
            });
        });
        $document.trigger('style-select-refresh');


        $document.on('keydown', '[data-ostyle-select="title"]', function (e) {
            if (e.keyCode === 40 || e.keyCode === 38) {
                var $this = $(this);
                var $select = $this.prev();

                if ($select.attr('disabled') === 'disabled') return;

                if (e.keyCode === 38) {
                    $select.find('option:selected').prop('selected', false).prev(':not([disabled])').prop('selected', true);
                } else {
                    $select.find('option:selected').prop('selected', false).next().prop('selected', true);
                }
                $select.trigger('change');
                return false;
            }

        });

        var __divSelect = function (even) {
            var $this = $(this);

            if ($this.hasClass('current')) {
                $document.trigger('click.pseudoDiv');
                return;
            }

            var $select = $this.prev();

            if ($select.attr('disabled') === 'disabled') return;

            $this.addClass('current');

            var $selectHtml = $select.html();
            $selectHtml = $selectHtml.replace(/<option/g, '<div tabindex="0"');
            $selectHtml = $selectHtml.replace(/option>/g, 'div>');

            $this.parents('.input__select').addClass('current');

            var $drop = $('<div/>').attr({'class': 'input__select-drop'}).html($selectHtml);


            $drop.find('div').each(function () {
                var $divOption = $(this);
                var $optionIcon = $divOption.attr('data-icon');
                if ($optionIcon) {
                    $divOption.prepend('<span class="option--icon" style="background-image: url(' + $optionIcon + ')"></span>');
                }
            });


            $drop.find('div').eq($select.find('option:selected').index()).addClass('current');

            $this.after($drop);
            $drop.find('> div.current').focus();

            $drop.on('click keypress', 'div:not([disabled])', function () {
                var $index = $(this).index();
                $select.find('option').prop('selected', false).eq($index).prop('selected', true);
                $select.trigger('change');
                $this.removeClass('current');
                $this.parents('.input__select').removeClass('current');
                $drop.off('click').remove();
                $this.focus();
            });

            $document.on('keydown.select-drop', function (e) {
                if (e.keyCode === 40) {
                    $drop.find(':focus').next().focus();
                    return false;
                }
                if (e.keyCode === 38) {
                    $drop.find(':focus').prev().focus();
                    return false;
                }
            });

            $document.one('click.pseudoDiv', function (even) {
                $this.removeClass('current');
                $this.parents('.input__select').removeClass('current');
                $document.off('select-drop-close');
                $drop.off('click').remove();

                $document.off('keydown.select-drop');
                $this.focus();
            });
        };
        $document.on('click keypress', '[data-ostyle-select="title"]', __divSelect);


        /* Разморозка стилизированного селекта */

        $document.ready(function () {
            if(!$(".fn_filter_category").is(":visible")) {
                $('.fn_filter_subcategory-title').removeAttr('data-disabled');
                $('select.fn_filter_subcategory').prop('disabled', false);
            }
        });

        $document.on('change', '.fn_filter_category', function () {
            $('.fn_filter_subcategory-title').removeAttr('data-disabled');

            var $fn_filter_subcategory = $('select.fn_filter_subcategory');
            $fn_filter_subcategory.prop('disabled', false);

            $.ajax({
                url: "/point/group/list-by-category",
                data: {category: $(this).val()},
                success: function (result) {
                    var options = "";

                    options = '<option value="">Выбрать</option>';

                    $(result.data).each(function (index, element) {
                        var selectedGroup = $fn_filter_subcategory.data("selected-group") == element.id ? "selected" : "";
                        options += '<option value="' + element.id + '" ' + selectedGroup + '>' + element.name + '</option>'
                    });

                    $fn_filter_subcategory.html(options).trigger('update');
                }
            });
        });

        $document.ready(function () {
            var $fn_filter_category = $(".fn_filter_category");

            if ($fn_filter_category.val() != "") {
                $(".fn_filter_category").trigger('change');
            }
        });


        /*
        Стилизированный скролл в блоках
         */
        $(".scrollbar-inner.scroll-basic").scrollbar();

        /*
        Стилизированный скролл в тех-поддержке
         */
        var $scrollTicket = $('#fn_scroll_ticket');
        if ($scrollTicket.length) {
            var $scrollTicketContent = $scrollTicket.find('.nano-content');
            var $scrollTicketBottom = $scrollTicketContent.height();
            $scrollTicket.scrollbar();
            $scrollTicket.scrollTop($scrollTicketBottom);

            /*
            Если чат будет активным, то соответственно после добавления
             динамического контента в область сообщений,
             проверяем высоту внутреннего седержания и задаем новую позицию scrollTop
             AJAX пример:
             */
            setInterval(function () {
                $scrollTicketContent.append(tmpl("template_ticket_message", {
                    'response': true,
                    'message': 'Text text text left'
                }));
                $scrollTicketContent.append(tmpl("template_ticket_message", {
                    'response': false,
                    'message': 'Text text text right'
                }));
                setTimeout(function () {
                    // Резкий переход
                    //$scrollTicket.scrollTop($scrollTicketContent.height());
                    // Анимированный переход
                    $scrollTicket.animate({
                        scrollTop: $scrollTicketContent.height()
                    }, "slow");
                }, 250);
            }, 3000);

        }


        /*
        Создаем информационную всплывашку
         */
        var __notifyModal = function ($btn, $template) {
            var $btnWidth = $btn.width();
            var $btnHeight = $btn.height();
            var $btnOffset = $btn.offset();


            var $posLeft = $btnOffset.left + ($btnWidth / 2);
            var $posTop = $btnOffset.top + $btnHeight;


            var $wscrolltop = $(window).scrollTop();
            if ($wscrolltop > $headerWrapHeight) {
                $posTop = $posTop - $wscrolltop;
            }

            var _move = $('<div/>')
                .html($template)
                .css({'left': $posLeft, 'top': $posTop})
                .attr({'class': 'notice__modal'})
                .appendTo($body);

            if (window.matchMedia('(min-width: 870px)').matches) {
                _move.find(".scrollbar-inner").scrollbar();
            }

            var __notifyModalClose = function (es) {
                if ($(es.target).closest(_move).length) {
                    $document.one('click.notice_box', __notifyModalClose);
                    return es.preventDefault();
                }
                _move.remove();
                $btn.removeClass('drop--open');
            }
            $document.one('click.notice_box', __notifyModalClose);
        }


        /*
        Всплывашка для уведомлений
         */
        $document.on('click', '.fn_btn_open_notify', function (e) {
            e.preventDefault();
            $body.removeAttr('data-dropshow');
            var $btn = $(this);
            if ($btn.hasClass('drop--open')) return;
            $btn.addClass('drop--open');

            /*
            Ajax запрос или извлекаем данные из глобальной переменной,
            которую загружаем при загрузке сайта, в таком случае, можно будет делать манипуляции на ходу
             */
            var $data = {
                'items': [
                    {
                        'read': false,
                        'type': 'Товар доступен',
                        'url': '#',
                        'image': 'img/blank/account__item-vk.png',
                        'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU'
                    },
                    {
                        'read': false,
                        'type': 'Новости магазина',
                        'url': '#',
                        'image': 'img/blank/account__item-fb.png',
                        'title': 'Аккаунты FB. Ручная регистрация через'
                    },
                    {
                        'read': true,
                        'type': 'Товар доступен',
                        'url': '#',
                        'image': 'img/blank/account__item-vk.png',
                        'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU'
                    },
                    {
                        'read': false,
                        'type': 'Товар доступен',
                        'url': '#',
                        'image': 'img/blank/account__item-vk.png',
                        'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU'
                    },
                    {
                        'read': false,
                        'type': 'Новости магазина',
                        'url': '#',
                        'image': 'img/blank/account__item-fb.png',
                        'title': 'Аккаунты FB. Ручная регистрация через'
                    },
                    {
                        'read': true,
                        'type': 'Товар доступен',
                        'url': '#',
                        'image': 'img/blank/account__item-vk.png',
                        'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU'
                    }
                ]
            }

            __notifyModal($btn, tmpl("template_notices_notify", $data));
        });

        /*
        Всплывашка для корзины
         */
        $document.on('click', '.fn_btn_open_cart', function (e) {
            e.preventDefault();
            $body.removeAttr('data-dropshow');
            var $btn = $(this);
            if ($btn.hasClass('drop--open')) return;
            $btn.addClass('drop--open');

            /*
            Ajax запрос или извлекаем данные из глобальной переменной,
            которую загружаем при загрузке сайта, в таком случае, можно будет делать манипуляции на ходу
             */
            var $data = {
                'items': [
                    {
                        'type': 'Вконтакте',
                        'url': '#',
                        'image': 'img/blank/account__item-vk.png',
                        'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU'
                    },
                    {
                        'type': 'Другое',
                        'url': '#',
                        'image': 'img/blank/account__item-fb.png',
                        'title': 'Аккаунты FB. Ручная регистрация через'
                    },
                    {
                        'type': 'Instagram',
                        'url': '#',
                        'image': 'img/blank/account__item-vk.png',
                        'title': 'Аккаунты FB. Ручная регистрация через номер телефона RU'
                    }
                ]
            }

            __notifyModal($btn, tmpl("template_notices_cart", $data));
        });


        /*
        Плавающая панелька на главной
         */
        $document.on('click', '[data-floatfly="btn"]', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var $wrap = $btn.closest('[data-floatfly="wrap"]');
            $wrap.toggleClass('toggle--open');

        });
        $document.on('click', '[data-floatfly="option"]', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var $html = $btn.html();

            var $wrap = $btn.closest('[data-floatfly="wrap"]');
            var $label = $wrap.find('[data-floatfly="btn"]');
            $label.html($html);
            $wrap.removeClass('toggle--open');
        });


        /*
        Поставщик, формы входа и регистрации
         */
        $document.on('click', '[data-authform-btn]', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var $blocks = $btn.closest('[data-authform-blocks]');
            $blocks.find('[data-authform-block]').addClass('hidden');
            var $id = $($btn.attr('href'));
            $id.removeClass('hidden');
        });

        /*
            Show/Hide all goods
         */

        $(document).on("click", ".hide-all-goods", function (e) {
            e.preventDefault();

            var targetList = $(this).data("target-list");
            var existingProducts = $(this).data("existing-products");

            $(targetList + " .account__item").each(function () {
                if (existingProducts.indexOf($(this).data("product-id")) === -1) {
                    $(this).remove();
                }
            });

            $(this).html('<span class="btn--label">Показать все товары</span>');
            $(this).addClass("show-all-goods").removeClass("hide-all-goods");
            $(window).scrollTop($(targetList).offset().top);

        });

        $document.on("click", ".show-all-goods", function (e) {
            e.preventDefault();

            var targetList = $(this).data("target-list");
            var context = $(this);
            var searchData = {};

            $(".search-form").serializeArray().map(function (x) {
                searchData[x.name] = x.value;
            })

            $.ajax({
                url: "/point/product/showcase",
                data: {
                    "gid": $(this).data("gid"),
                    "existing": $(this).data("existing-products"),
                    'searchParams': searchData
                },
                method: "POST",
                success: function (result) {
                    $(targetList).append(result.data.html_products);

                    $(context).removeClass("show-all-goods").addClass("hide-all-goods").html("Скрыть товары");
                }
            });
        });

        /* FAQ list toggler */
        $(document).ready(function() {
            $('.faq-list dt').click(function () {
                var $this = $(this);
                if($this.hasClass('current'))
                {
                    $this.removeClass('current').next().fadeOut();
                    return false;
                }
                var $wrapfaq = $this.closest('.faq-list');
                $wrapfaq.find('dt').removeClass('current');
                $wrapfaq.find('dd').fadeOut();

                $this.addClass('current');
                $this.next().fadeIn(500);
                return false;
            });
        });
        /* END */

        //END
    });
})(jQuery);
/* END */

// ################################################
// Yandex.Commerce Events
// ################################################

function commercePurchaseFromResultPage()
{
    const Commerce = new YandexCommerce();
    let resultPage = $("#result-page");
    if (resultPage.length) {
        let product = getProduct(resultPage.data("product"));
        if (product) {
            Commerce.purchase({
                ...product,
                productId: resultPage.data("product"),
                orderId: resultPage.data("order"),
                revenue: resultPage.data("sum")
            })
        }
    }
}

function commerceAddToCartFromPurchaseForm(formData)
{
    formData = $(formData).serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});

    let quantity = formData.quantity;
    let product = getProduct(formData.product_id);

    if (product) {
        const Commerce = new YandexCommerce();
        Commerce.addToCartProduct({...product, quantity});
    }
}

function commerceViewProductPage()
{
    const Commerce = new YandexCommerce();
    let pageProduct = $("#product-page");
    if (pageProduct.length) {
        let product = getProduct(pageProduct.data("id"));
        if (product) {
            Commerce.viewProduct(product)
        }
    }
}

// Interact with API

function getProduct(id) {
    let product = null;
    $.ajax({
        async: false,
        url: "/point/product/view?id=" + id,
        success(response) {
            if ("data" in response && "product" in response.data) {
                product = response.data.product;
            }
        }
    });
    return product;
}

function sendData(form, successCallback, url = null) {

    var $form = form;
    var $action = url ? url : $form.attr('action');
    var $method = $form.attr('method');
    var $module = $form.attr('data-form-ajax');

    $.mlsAjax.preloaderShow({type: "frame", frame: $form});

    $.ajax({
        'url': $action,
        'type': $method,
        'dataType': "json",
        'data': $form.serializeArray(),
        success: function (data) {
            $.mlsAjax.preloaderHide();

            if (data.success) {
                successCallback(data.data);
            } else {
                var errorMessage = '';

                if ("message" in data.data) {
                    errorMessage = data.data.message;
                }
                if (Array.isArray(data.data)) {

                    data.data.forEach((element) => {
                        errorMessage += "* " + element.message + "<br>";
                    })
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Произошла ошибка',
                    html: errorMessage
                });
            }
        },
        error: function (response) {
            $.mlsAjax.preloaderHide();
            var data = JSON.parse(response.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Ошибка',
                text: "message" in data ? data.message : "Server error. Please try again later"
            });
        }
    });

}