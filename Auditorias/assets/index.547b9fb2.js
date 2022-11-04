;(function () {
  const t = document.createElement("link").relList
  if (t && t.supports && t.supports("modulepreload")) return
  for (const s of document.querySelectorAll('link[rel="modulepreload"]')) r(s)
  new MutationObserver((s) => {
    for (const i of s) if (i.type === "childList") for (const o of i.addedNodes) o.tagName === "LINK" && o.rel === "modulepreload" && r(o)
  }).observe(document, { childList: !0, subtree: !0 })
  function n(s) {
    const i = {}
    return (
      s.integrity && (i.integrity = s.integrity),
      s.referrerpolicy && (i.referrerPolicy = s.referrerpolicy),
      s.crossorigin === "use-credentials" ? (i.credentials = "include") : s.crossorigin === "anonymous" ? (i.credentials = "omit") : (i.credentials = "same-origin"),
      i
    )
  }
  function r(s) {
    if (s.ep) return
    s.ep = !0
    const i = n(s)
    fetch(s.href, i)
  }
})()
function li(e, t) {
  const n = Object.create(null),
    r = e.split(",")
  for (let s = 0; s < r.length; s++) n[r[s]] = !0
  return t ? (s) => !!n[s.toLowerCase()] : (s) => !!n[s]
}
const Nu = "itemscope,allowfullscreen,formnovalidate,ismap,nomodule,novalidate,readonly",
  Lu = li(Nu)
function Ra(e) {
  return !!e || e === ""
}
function tt(e) {
  if (J(e)) {
    const t = {}
    for (let n = 0; n < e.length; n++) {
      const r = e[n],
        s = Oe(r) ? Hu(r) : tt(r)
      if (s) for (const i in s) t[i] = s[i]
    }
    return t
  } else {
    if (Oe(e)) return e
    if (be(e)) return e
  }
}
const Uu = /;(?![^(]*\))/g,
  Wu = /:(.+)/
function Hu(e) {
  const t = {}
  return (
    e.split(Uu).forEach((n) => {
      if (n) {
        const r = n.split(Wu)
        r.length > 1 && (t[r[0].trim()] = r[1].trim())
      }
    }),
    t
  )
}
function es(e) {
  let t = ""
  if (Oe(e)) t = e
  else if (J(e))
    for (let n = 0; n < e.length; n++) {
      const r = es(e[n])
      r && (t += r + " ")
    }
  else if (be(e)) for (const n in e) e[n] && (t += n + " ")
  return t.trim()
}
const _e = (e) => (Oe(e) ? e : e == null ? "" : J(e) || (be(e) && (e.toString === Na || !Z(e.toString))) ? JSON.stringify(e, Ia, 2) : String(e)),
  Ia = (e, t) =>
    t && t.__v_isRef
      ? Ia(e, t.value)
      : xn(t)
      ? { [`Map(${t.size})`]: [...t.entries()].reduce((n, [r, s]) => ((n[`${r} =>`] = s), n), {}) }
      : Da(t)
      ? { [`Set(${t.size})`]: [...t.values()] }
      : be(t) && !J(t) && !La(t)
      ? String(t)
      : t,
  me = {},
  $n = [],
  st = () => {},
  zu = () => !1,
  Bu = /^on[^a-z]/,
  ts = (e) => Bu.test(e),
  ui = (e) => e.startsWith("onUpdate:"),
  Fe = Object.assign,
  ci = (e, t) => {
    const n = e.indexOf(t)
    n > -1 && e.splice(n, 1)
  },
  Vu = Object.prototype.hasOwnProperty,
  ie = (e, t) => Vu.call(e, t),
  J = Array.isArray,
  xn = (e) => ns(e) === "[object Map]",
  Da = (e) => ns(e) === "[object Set]",
  Z = (e) => typeof e == "function",
  Oe = (e) => typeof e == "string",
  fi = (e) => typeof e == "symbol",
  be = (e) => e !== null && typeof e == "object",
  Fa = (e) => be(e) && Z(e.then) && Z(e.catch),
  Na = Object.prototype.toString,
  ns = (e) => Na.call(e),
  qu = (e) => ns(e).slice(8, -1),
  La = (e) => ns(e) === "[object Object]",
  di = (e) => Oe(e) && e !== "NaN" && e[0] !== "-" && "" + parseInt(e, 10) === e,
  $r = li(",key,ref,ref_for,ref_key,onVnodeBeforeMount,onVnodeMounted,onVnodeBeforeUpdate,onVnodeUpdated,onVnodeBeforeUnmount,onVnodeUnmounted"),
  rs = (e) => {
    const t = Object.create(null)
    return (n) => t[n] || (t[n] = e(n))
  },
  Ku = /-(\w)/g,
  yt = rs((e) => e.replace(Ku, (t, n) => (n ? n.toUpperCase() : ""))),
  Yu = /\B([A-Z])/g,
  cn = rs((e) => e.replace(Yu, "-$1").toLowerCase()),
  ss = rs((e) => e.charAt(0).toUpperCase() + e.slice(1)),
  vs = rs((e) => (e ? `on${ss(e)}` : "")),
  Zn = (e, t) => !Object.is(e, t),
  xr = (e, t) => {
    for (let n = 0; n < e.length; n++) e[n](t)
  },
  Rr = (e, t, n) => {
    Object.defineProperty(e, t, { configurable: !0, enumerable: !1, value: n })
  },
  As = (e) => {
    const t = parseFloat(e)
    return isNaN(t) ? e : t
  }
let Xi
const Gu = () => Xi || (Xi = typeof globalThis < "u" ? globalThis : typeof self < "u" ? self : typeof window < "u" ? window : typeof global < "u" ? global : {})
let ze
class Qu {
  constructor(t = !1) {
    ;(this.active = !0), (this.effects = []), (this.cleanups = []), !t && ze && ((this.parent = ze), (this.index = (ze.scopes || (ze.scopes = [])).push(this) - 1))
  }
  run(t) {
    if (this.active) {
      const n = ze
      try {
        return (ze = this), t()
      } finally {
        ze = n
      }
    }
  }
  on() {
    ze = this
  }
  off() {
    ze = this.parent
  }
  stop(t) {
    if (this.active) {
      let n, r
      for (n = 0, r = this.effects.length; n < r; n++) this.effects[n].stop()
      for (n = 0, r = this.cleanups.length; n < r; n++) this.cleanups[n]()
      if (this.scopes) for (n = 0, r = this.scopes.length; n < r; n++) this.scopes[n].stop(!0)
      if (this.parent && !t) {
        const s = this.parent.scopes.pop()
        s && s !== this && ((this.parent.scopes[this.index] = s), (s.index = this.index))
      }
      this.active = !1
    }
  }
}
function Ju(e, t = ze) {
  t && t.active && t.effects.push(e)
}
function Xu() {
  return ze
}
function Zu(e) {
  ze && ze.cleanups.push(e)
}
const pi = (e) => {
    const t = new Set(e)
    return (t.w = 0), (t.n = 0), t
  },
  Ua = (e) => (e.w & zt) > 0,
  Wa = (e) => (e.n & zt) > 0,
  ec = ({ deps: e }) => {
    if (e.length) for (let t = 0; t < e.length; t++) e[t].w |= zt
  },
  tc = (e) => {
    const { deps: t } = e
    if (t.length) {
      let n = 0
      for (let r = 0; r < t.length; r++) {
        const s = t[r]
        Ua(s) && !Wa(s) ? s.delete(e) : (t[n++] = s), (s.w &= ~zt), (s.n &= ~zt)
      }
      t.length = n
    }
  },
  Ts = new WeakMap()
let Bn = 0,
  zt = 1
const Ms = 30
let et
const nn = Symbol(""),
  js = Symbol("")
class hi {
  constructor(t, n = null, r) {
    ;(this.fn = t), (this.scheduler = n), (this.active = !0), (this.deps = []), (this.parent = void 0), Ju(this, r)
  }
  run() {
    if (!this.active) return this.fn()
    let t = et,
      n = Wt
    for (; t; ) {
      if (t === this) return
      t = t.parent
    }
    try {
      return (this.parent = et), (et = this), (Wt = !0), (zt = 1 << ++Bn), Bn <= Ms ? ec(this) : Zi(this), this.fn()
    } finally {
      Bn <= Ms && tc(this), (zt = 1 << --Bn), (et = this.parent), (Wt = n), (this.parent = void 0), this.deferStop && this.stop()
    }
  }
  stop() {
    et === this ? (this.deferStop = !0) : this.active && (Zi(this), this.onStop && this.onStop(), (this.active = !1))
  }
}
function Zi(e) {
  const { deps: t } = e
  if (t.length) {
    for (let n = 0; n < t.length; n++) t[n].delete(e)
    t.length = 0
  }
}
let Wt = !0
const Ha = []
function Fn() {
  Ha.push(Wt), (Wt = !1)
}
function Nn() {
  const e = Ha.pop()
  Wt = e === void 0 ? !0 : e
}
function Ke(e, t, n) {
  if (Wt && et) {
    let r = Ts.get(e)
    r || Ts.set(e, (r = new Map()))
    let s = r.get(n)
    s || r.set(n, (s = pi())), za(s)
  }
}
function za(e, t) {
  let n = !1
  Bn <= Ms ? Wa(e) || ((e.n |= zt), (n = !Ua(e))) : (n = !e.has(et)), n && (e.add(et), et.deps.push(e))
}
function Ot(e, t, n, r, s, i) {
  const o = Ts.get(e)
  if (!o) return
  let a = []
  if (t === "clear") a = [...o.values()]
  else if (n === "length" && J(e))
    o.forEach((l, d) => {
      ;(d === "length" || d >= r) && a.push(l)
    })
  else
    switch ((n !== void 0 && a.push(o.get(n)), t)) {
      case "add":
        J(e) ? di(n) && a.push(o.get("length")) : (a.push(o.get(nn)), xn(e) && a.push(o.get(js)))
        break
      case "delete":
        J(e) || (a.push(o.get(nn)), xn(e) && a.push(o.get(js)))
        break
      case "set":
        xn(e) && a.push(o.get(nn))
        break
    }
  if (a.length === 1) a[0] && Rs(a[0])
  else {
    const l = []
    for (const d of a) d && l.push(...d)
    Rs(pi(l))
  }
}
function Rs(e, t) {
  const n = J(e) ? e : [...e]
  for (const r of n) r.computed && eo(r)
  for (const r of n) r.computed || eo(r)
}
function eo(e, t) {
  ;(e !== et || e.allowRecurse) && (e.scheduler ? e.scheduler() : e.run())
}
const nc = li("__proto__,__v_isRef,__isVue"),
  Ba = new Set(
    Object.getOwnPropertyNames(Symbol)
      .filter((e) => e !== "arguments" && e !== "caller")
      .map((e) => Symbol[e])
      .filter(fi)
  ),
  rc = mi(),
  sc = mi(!1, !0),
  ic = mi(!0),
  to = oc()
function oc() {
  const e = {}
  return (
    ["includes", "indexOf", "lastIndexOf"].forEach((t) => {
      e[t] = function (...n) {
        const r = fe(this)
        for (let i = 0, o = this.length; i < o; i++) Ke(r, "get", i + "")
        const s = r[t](...n)
        return s === -1 || s === !1 ? r[t](...n.map(fe)) : s
      }
    }),
    ["push", "pop", "shift", "unshift", "splice"].forEach((t) => {
      e[t] = function (...n) {
        Fn()
        const r = fe(this)[t].apply(this, n)
        return Nn(), r
      }
    }),
    e
  )
}
function mi(e = !1, t = !1) {
  return function (r, s, i) {
    if (s === "__v_isReactive") return !e
    if (s === "__v_isReadonly") return e
    if (s === "__v_isShallow") return t
    if (s === "__v_raw" && i === (e ? (t ? $c : Ga) : t ? Ya : Ka).get(r)) return r
    const o = J(r)
    if (!e && o && ie(to, s)) return Reflect.get(to, s, i)
    const a = Reflect.get(r, s, i)
    return (fi(s) ? Ba.has(s) : nc(s)) || (e || Ke(r, "get", s), t) ? a : $e(a) ? (o && di(s) ? a : a.value) : be(a) ? (e ? Qa(a) : pt(a)) : a
  }
}
const ac = Va(),
  lc = Va(!0)
function Va(e = !1) {
  return function (n, r, s, i) {
    let o = n[r]
    if (On(o) && $e(o) && !$e(s)) return !1
    if (!e && (!Ir(s) && !On(s) && ((o = fe(o)), (s = fe(s))), !J(n) && $e(o) && !$e(s))) return (o.value = s), !0
    const a = J(n) && di(r) ? Number(r) < n.length : ie(n, r),
      l = Reflect.set(n, r, s, i)
    return n === fe(i) && (a ? Zn(s, o) && Ot(n, "set", r, s) : Ot(n, "add", r, s)), l
  }
}
function uc(e, t) {
  const n = ie(e, t)
  e[t]
  const r = Reflect.deleteProperty(e, t)
  return r && n && Ot(e, "delete", t, void 0), r
}
function cc(e, t) {
  const n = Reflect.has(e, t)
  return (!fi(t) || !Ba.has(t)) && Ke(e, "has", t), n
}
function fc(e) {
  return Ke(e, "iterate", J(e) ? "length" : nn), Reflect.ownKeys(e)
}
const qa = { get: rc, set: ac, deleteProperty: uc, has: cc, ownKeys: fc },
  dc = {
    get: ic,
    set(e, t) {
      return !0
    },
    deleteProperty(e, t) {
      return !0
    },
  },
  pc = Fe({}, qa, { get: sc, set: lc }),
  gi = (e) => e,
  is = (e) => Reflect.getPrototypeOf(e)
function hr(e, t, n = !1, r = !1) {
  e = e.__v_raw
  const s = fe(e),
    i = fe(t)
  n || (t !== i && Ke(s, "get", t), Ke(s, "get", i))
  const { has: o } = is(s),
    a = r ? gi : n ? wi : er
  if (o.call(s, t)) return a(e.get(t))
  if (o.call(s, i)) return a(e.get(i))
  e !== s && e.get(t)
}
function mr(e, t = !1) {
  const n = this.__v_raw,
    r = fe(n),
    s = fe(e)
  return t || (e !== s && Ke(r, "has", e), Ke(r, "has", s)), e === s ? n.has(e) : n.has(e) || n.has(s)
}
function gr(e, t = !1) {
  return (e = e.__v_raw), !t && Ke(fe(e), "iterate", nn), Reflect.get(e, "size", e)
}
function no(e) {
  e = fe(e)
  const t = fe(this)
  return is(t).has.call(t, e) || (t.add(e), Ot(t, "add", e, e)), this
}
function ro(e, t) {
  t = fe(t)
  const n = fe(this),
    { has: r, get: s } = is(n)
  let i = r.call(n, e)
  i || ((e = fe(e)), (i = r.call(n, e)))
  const o = s.call(n, e)
  return n.set(e, t), i ? Zn(t, o) && Ot(n, "set", e, t) : Ot(n, "add", e, t), this
}
function so(e) {
  const t = fe(this),
    { has: n, get: r } = is(t)
  let s = n.call(t, e)
  s || ((e = fe(e)), (s = n.call(t, e))), r && r.call(t, e)
  const i = t.delete(e)
  return s && Ot(t, "delete", e, void 0), i
}
function io() {
  const e = fe(this),
    t = e.size !== 0,
    n = e.clear()
  return t && Ot(e, "clear", void 0, void 0), n
}
function vr(e, t) {
  return function (r, s) {
    const i = this,
      o = i.__v_raw,
      a = fe(o),
      l = t ? gi : e ? wi : er
    return !e && Ke(a, "iterate", nn), o.forEach((d, f) => r.call(s, l(d), l(f), i))
  }
}
function yr(e, t, n) {
  return function (...r) {
    const s = this.__v_raw,
      i = fe(s),
      o = xn(i),
      a = e === "entries" || (e === Symbol.iterator && o),
      l = e === "keys" && o,
      d = s[e](...r),
      f = n ? gi : t ? wi : er
    return (
      !t && Ke(i, "iterate", l ? js : nn),
      {
        next() {
          const { value: u, done: c } = d.next()
          return c ? { value: u, done: c } : { value: a ? [f(u[0]), f(u[1])] : f(u), done: c }
        },
        [Symbol.iterator]() {
          return this
        },
      }
    )
  }
}
function Mt(e) {
  return function (...t) {
    return e === "delete" ? !1 : this
  }
}
function hc() {
  const e = {
      get(i) {
        return hr(this, i)
      },
      get size() {
        return gr(this)
      },
      has: mr,
      add: no,
      set: ro,
      delete: so,
      clear: io,
      forEach: vr(!1, !1),
    },
    t = {
      get(i) {
        return hr(this, i, !1, !0)
      },
      get size() {
        return gr(this)
      },
      has: mr,
      add: no,
      set: ro,
      delete: so,
      clear: io,
      forEach: vr(!1, !0),
    },
    n = {
      get(i) {
        return hr(this, i, !0)
      },
      get size() {
        return gr(this, !0)
      },
      has(i) {
        return mr.call(this, i, !0)
      },
      add: Mt("add"),
      set: Mt("set"),
      delete: Mt("delete"),
      clear: Mt("clear"),
      forEach: vr(!0, !1),
    },
    r = {
      get(i) {
        return hr(this, i, !0, !0)
      },
      get size() {
        return gr(this, !0)
      },
      has(i) {
        return mr.call(this, i, !0)
      },
      add: Mt("add"),
      set: Mt("set"),
      delete: Mt("delete"),
      clear: Mt("clear"),
      forEach: vr(!0, !0),
    }
  return (
    ["keys", "values", "entries", Symbol.iterator].forEach((i) => {
      ;(e[i] = yr(i, !1, !1)), (n[i] = yr(i, !0, !1)), (t[i] = yr(i, !1, !0)), (r[i] = yr(i, !0, !0))
    }),
    [e, n, t, r]
  )
}
const [mc, gc, vc, yc] = hc()
function vi(e, t) {
  const n = t ? (e ? yc : vc) : e ? gc : mc
  return (r, s, i) => (s === "__v_isReactive" ? !e : s === "__v_isReadonly" ? e : s === "__v_raw" ? r : Reflect.get(ie(n, s) && s in r ? n : r, s, i))
}
const bc = { get: vi(!1, !1) },
  wc = { get: vi(!1, !0) },
  _c = { get: vi(!0, !1) },
  Ka = new WeakMap(),
  Ya = new WeakMap(),
  Ga = new WeakMap(),
  $c = new WeakMap()
function xc(e) {
  switch (e) {
    case "Object":
    case "Array":
      return 1
    case "Map":
    case "Set":
    case "WeakMap":
    case "WeakSet":
      return 2
    default:
      return 0
  }
}
function kc(e) {
  return e.__v_skip || !Object.isExtensible(e) ? 0 : xc(qu(e))
}
function pt(e) {
  return On(e) ? e : yi(e, !1, qa, bc, Ka)
}
function Cc(e) {
  return yi(e, !1, pc, wc, Ya)
}
function Qa(e) {
  return yi(e, !0, dc, _c, Ga)
}
function yi(e, t, n, r, s) {
  if (!be(e) || (e.__v_raw && !(t && e.__v_isReactive))) return e
  const i = s.get(e)
  if (i) return i
  const o = kc(e)
  if (o === 0) return e
  const a = new Proxy(e, o === 2 ? r : n)
  return s.set(e, a), a
}
function mt(e) {
  return On(e) ? mt(e.__v_raw) : !!(e && e.__v_isReactive)
}
function On(e) {
  return !!(e && e.__v_isReadonly)
}
function Ir(e) {
  return !!(e && e.__v_isShallow)
}
function Ja(e) {
  return mt(e) || On(e)
}
function fe(e) {
  const t = e && e.__v_raw
  return t ? fe(t) : e
}
function bi(e) {
  return Rr(e, "__v_skip", !0), e
}
const er = (e) => (be(e) ? pt(e) : e),
  wi = (e) => (be(e) ? Qa(e) : e)
function Xa(e) {
  Wt && et && ((e = fe(e)), za(e.dep || (e.dep = pi())))
}
function _i(e, t) {
  ;(e = fe(e)), e.dep && Rs(e.dep)
}
function $e(e) {
  return !!(e && e.__v_isRef === !0)
}
function ne(e) {
  return el(e, !1)
}
function Za(e) {
  return el(e, !0)
}
function el(e, t) {
  return $e(e) ? e : new Pc(e, t)
}
class Pc {
  constructor(t, n) {
    ;(this.__v_isShallow = n), (this.dep = void 0), (this.__v_isRef = !0), (this._rawValue = n ? t : fe(t)), (this._value = n ? t : er(t))
  }
  get value() {
    return Xa(this), this._value
  }
  set value(t) {
    const n = this.__v_isShallow || Ir(t) || On(t)
    ;(t = n ? t : fe(t)), Zn(t, this._rawValue) && ((this._rawValue = t), (this._value = n ? t : er(t)), _i(this))
  }
}
function br(e) {
  _i(e)
}
function gt(e) {
  return $e(e) ? e.value : e
}
const Oc = {
  get: (e, t, n) => gt(Reflect.get(e, t, n)),
  set: (e, t, n, r) => {
    const s = e[t]
    return $e(s) && !$e(n) ? ((s.value = n), !0) : Reflect.set(e, t, n, r)
  },
}
function tl(e) {
  return mt(e) ? e : new Proxy(e, Oc)
}
class Ec {
  constructor(t, n, r) {
    ;(this._object = t), (this._key = n), (this._defaultValue = r), (this.__v_isRef = !0)
  }
  get value() {
    const t = this._object[this._key]
    return t === void 0 ? this._defaultValue : t
  }
  set value(t) {
    this._object[this._key] = t
  }
}
function Sc(e, t, n) {
  const r = e[t]
  return $e(r) ? r : new Ec(e, t, n)
}
var nl
class Ac {
  constructor(t, n, r, s) {
    ;(this._setter = n),
      (this.dep = void 0),
      (this.__v_isRef = !0),
      (this[nl] = !1),
      (this._dirty = !0),
      (this.effect = new hi(t, () => {
        this._dirty || ((this._dirty = !0), _i(this))
      })),
      (this.effect.computed = this),
      (this.effect.active = this._cacheable = !s),
      (this.__v_isReadonly = r)
  }
  get value() {
    const t = fe(this)
    return Xa(t), (t._dirty || !t._cacheable) && ((t._dirty = !1), (t._value = t.effect.run())), t._value
  }
  set value(t) {
    this._setter(t)
  }
}
nl = "__v_isReadonly"
function Tc(e, t, n = !1) {
  let r, s
  const i = Z(e)
  return i ? ((r = e), (s = st)) : ((r = e.get), (s = e.set)), new Ac(r, s, i || !s, n)
}
function Ht(e, t, n, r) {
  let s
  try {
    s = r ? e(...r) : e()
  } catch (i) {
    os(i, t, n)
  }
  return s
}
function it(e, t, n, r) {
  if (Z(e)) {
    const i = Ht(e, t, n, r)
    return (
      i &&
        Fa(i) &&
        i.catch((o) => {
          os(o, t, n)
        }),
      i
    )
  }
  const s = []
  for (let i = 0; i < e.length; i++) s.push(it(e[i], t, n, r))
  return s
}
function os(e, t, n, r = !0) {
  const s = t ? t.vnode : null
  if (t) {
    let i = t.parent
    const o = t.proxy,
      a = n
    for (; i; ) {
      const d = i.ec
      if (d) {
        for (let f = 0; f < d.length; f++) if (d[f](e, o, a) === !1) return
      }
      i = i.parent
    }
    const l = t.appContext.config.errorHandler
    if (l) {
      Ht(l, null, 10, [e, o, a])
      return
    }
  }
  Mc(e, n, s, r)
}
function Mc(e, t, n, r = !0) {
  console.error(e)
}
let tr = !1,
  Is = !1
const je = []
let dt = 0
const kn = []
let $t = null,
  Jt = 0
const rl = Promise.resolve()
let $i = null
function as(e) {
  const t = $i || rl
  return e ? t.then(this ? e.bind(this) : e) : t
}
function jc(e) {
  let t = dt + 1,
    n = je.length
  for (; t < n; ) {
    const r = (t + n) >>> 1
    nr(je[r]) < e ? (t = r + 1) : (n = r)
  }
  return t
}
function xi(e) {
  ;(!je.length || !je.includes(e, tr && e.allowRecurse ? dt + 1 : dt)) && (e.id == null ? je.push(e) : je.splice(jc(e.id), 0, e), sl())
}
function sl() {
  !tr && !Is && ((Is = !0), ($i = rl.then(ol)))
}
function Rc(e) {
  const t = je.indexOf(e)
  t > dt && je.splice(t, 1)
}
function Ic(e) {
  J(e) ? kn.push(...e) : (!$t || !$t.includes(e, e.allowRecurse ? Jt + 1 : Jt)) && kn.push(e), sl()
}
function oo(e, t = tr ? dt + 1 : 0) {
  for (; t < je.length; t++) {
    const n = je[t]
    n && n.pre && (je.splice(t, 1), t--, n())
  }
}
function il(e) {
  if (kn.length) {
    const t = [...new Set(kn)]
    if (((kn.length = 0), $t)) {
      $t.push(...t)
      return
    }
    for ($t = t, $t.sort((n, r) => nr(n) - nr(r)), Jt = 0; Jt < $t.length; Jt++) $t[Jt]()
    ;($t = null), (Jt = 0)
  }
}
const nr = (e) => (e.id == null ? 1 / 0 : e.id),
  Dc = (e, t) => {
    const n = nr(e) - nr(t)
    if (n === 0) {
      if (e.pre && !t.pre) return -1
      if (t.pre && !e.pre) return 1
    }
    return n
  }
function ol(e) {
  ;(Is = !1), (tr = !0), je.sort(Dc)
  const t = st
  try {
    for (dt = 0; dt < je.length; dt++) {
      const n = je[dt]
      n && n.active !== !1 && Ht(n, null, 14)
    }
  } finally {
    ;(dt = 0), (je.length = 0), il(), (tr = !1), ($i = null), (je.length || kn.length) && ol()
  }
}
function Fc(e, t, ...n) {
  if (e.isUnmounted) return
  const r = e.vnode.props || me
  let s = n
  const i = t.startsWith("update:"),
    o = i && t.slice(7)
  if (o && o in r) {
    const f = `${o === "modelValue" ? "model" : o}Modifiers`,
      { number: u, trim: c } = r[f] || me
    c && (s = n.map((p) => p.trim())), u && (s = n.map(As))
  }
  let a,
    l = r[(a = vs(t))] || r[(a = vs(yt(t)))]
  !l && i && (l = r[(a = vs(cn(t)))]), l && it(l, e, 6, s)
  const d = r[a + "Once"]
  if (d) {
    if (!e.emitted) e.emitted = {}
    else if (e.emitted[a]) return
    ;(e.emitted[a] = !0), it(d, e, 6, s)
  }
}
function al(e, t, n = !1) {
  const r = t.emitsCache,
    s = r.get(e)
  if (s !== void 0) return s
  const i = e.emits
  let o = {},
    a = !1
  if (!Z(e)) {
    const l = (d) => {
      const f = al(d, t, !0)
      f && ((a = !0), Fe(o, f))
    }
    !n && t.mixins.length && t.mixins.forEach(l), e.extends && l(e.extends), e.mixins && e.mixins.forEach(l)
  }
  return !i && !a ? (be(e) && r.set(e, null), null) : (J(i) ? i.forEach((l) => (o[l] = null)) : Fe(o, i), be(e) && r.set(e, o), o)
}
function ls(e, t) {
  return !e || !ts(t) ? !1 : ((t = t.slice(2).replace(/Once$/, "")), ie(e, t[0].toLowerCase() + t.slice(1)) || ie(e, cn(t)) || ie(e, t))
}
let Qe = null,
  us = null
function Dr(e) {
  const t = Qe
  return (Qe = e), (us = (e && e.type.__scopeId) || null), t
}
function ll(e) {
  us = e
}
function ul() {
  us = null
}
function Nc(e, t = Qe, n) {
  if (!t || e._n) return e
  const r = (...s) => {
    r._d && yo(-1)
    const i = Dr(t),
      o = e(...s)
    return Dr(i), r._d && yo(1), o
  }
  return (r._n = !0), (r._c = !0), (r._d = !0), r
}
function ys(e) {
  const {
    type: t,
    vnode: n,
    proxy: r,
    withProxy: s,
    props: i,
    propsOptions: [o],
    slots: a,
    attrs: l,
    emit: d,
    render: f,
    renderCache: u,
    data: c,
    setupState: p,
    ctx: $,
    inheritAttrs: b,
  } = e
  let w, g
  const k = Dr(e)
  try {
    if (n.shapeFlag & 4) {
      const _ = s || r
      ;(w = ft(f.call(_, _, u, i, p, c, $))), (g = l)
    } else {
      const _ = t
      ;(w = ft(_.length > 1 ? _(i, { attrs: l, slots: a, emit: d }) : _(i, null))), (g = t.props ? l : Lc(l))
    }
  } catch (_) {
    ;(Gn.length = 0), os(_, e, 1), (w = Re(sn))
  }
  let M = w
  if (g && b !== !1) {
    const _ = Object.keys(g),
      { shapeFlag: P } = M
    _.length && P & 7 && (o && _.some(ui) && (g = Uc(g, o)), (M = En(M, g)))
  }
  return n.dirs && ((M = En(M)), (M.dirs = M.dirs ? M.dirs.concat(n.dirs) : n.dirs)), n.transition && (M.transition = n.transition), (w = M), Dr(k), w
}
const Lc = (e) => {
    let t
    for (const n in e) (n === "class" || n === "style" || ts(n)) && ((t || (t = {}))[n] = e[n])
    return t
  },
  Uc = (e, t) => {
    const n = {}
    for (const r in e) (!ui(r) || !(r.slice(9) in t)) && (n[r] = e[r])
    return n
  }
function Wc(e, t, n) {
  const { props: r, children: s, component: i } = e,
    { props: o, children: a, patchFlag: l } = t,
    d = i.emitsOptions
  if (t.dirs || t.transition) return !0
  if (n && l >= 0) {
    if (l & 1024) return !0
    if (l & 16) return r ? ao(r, o, d) : !!o
    if (l & 8) {
      const f = t.dynamicProps
      for (let u = 0; u < f.length; u++) {
        const c = f[u]
        if (o[c] !== r[c] && !ls(d, c)) return !0
      }
    }
  } else return (s || a) && (!a || !a.$stable) ? !0 : r === o ? !1 : r ? (o ? ao(r, o, d) : !0) : !!o
  return !1
}
function ao(e, t, n) {
  const r = Object.keys(t)
  if (r.length !== Object.keys(e).length) return !0
  for (let s = 0; s < r.length; s++) {
    const i = r[s]
    if (t[i] !== e[i] && !ls(n, i)) return !0
  }
  return !1
}
function Hc({ vnode: e, parent: t }, n) {
  for (; t && t.subTree === e; ) ((e = t.vnode).el = n), (t = t.parent)
}
const zc = (e) => e.__isSuspense
function Bc(e, t) {
  t && t.pendingBranch ? (J(e) ? t.effects.push(...e) : t.effects.push(e)) : Ic(e)
}
function Kn(e, t) {
  if (Se) {
    let n = Se.provides
    const r = Se.parent && Se.parent.provides
    r === n && (n = Se.provides = Object.create(r)), (n[e] = t)
  }
}
function Je(e, t, n = !1) {
  const r = Se || Qe
  if (r) {
    const s = r.parent == null ? r.vnode.appContext && r.vnode.appContext.provides : r.parent.provides
    if (s && e in s) return s[e]
    if (arguments.length > 1) return n && Z(t) ? t.call(r.proxy) : t
  }
}
function xt(e, t) {
  return ki(e, null, t)
}
const lo = {}
function Ve(e, t, n) {
  return ki(e, t, n)
}
function ki(e, t, { immediate: n, deep: r, flush: s, onTrack: i, onTrigger: o } = me) {
  const a = Se
  let l,
    d = !1,
    f = !1
  if (
    ($e(e)
      ? ((l = () => e.value), (d = Ir(e)))
      : mt(e)
      ? ((l = () => e), (r = !0))
      : J(e)
      ? ((f = !0),
        (d = e.some((g) => mt(g) || Ir(g))),
        (l = () =>
          e.map((g) => {
            if ($e(g)) return g.value
            if (mt(g)) return tn(g)
            if (Z(g)) return Ht(g, a, 2)
          })))
      : Z(e)
      ? t
        ? (l = () => Ht(e, a, 2))
        : (l = () => {
            if (!(a && a.isUnmounted)) return u && u(), it(e, a, 3, [c])
          })
      : (l = st),
    t && r)
  ) {
    const g = l
    l = () => tn(g())
  }
  let u,
    c = (g) => {
      u = w.onStop = () => {
        Ht(g, a, 4)
      }
    }
  if (sr) return (c = st), t ? n && it(t, a, 3, [l(), f ? [] : void 0, c]) : l(), st
  let p = f ? [] : lo
  const $ = () => {
    if (!!w.active)
      if (t) {
        const g = w.run()
        ;(r || d || (f ? g.some((k, M) => Zn(k, p[M])) : Zn(g, p))) && (u && u(), it(t, a, 3, [g, p === lo ? void 0 : p, c]), (p = g))
      } else w.run()
  }
  $.allowRecurse = !!t
  let b
  s === "sync" ? (b = $) : s === "post" ? (b = () => We($, a && a.suspense)) : (($.pre = !0), a && ($.id = a.uid), (b = () => xi($)))
  const w = new hi(l, b)
  return (
    t ? (n ? $() : (p = w.run())) : s === "post" ? We(w.run.bind(w), a && a.suspense) : w.run(),
    () => {
      w.stop(), a && a.scope && ci(a.scope.effects, w)
    }
  )
}
function Vc(e, t, n) {
  const r = this.proxy,
    s = Oe(e) ? (e.includes(".") ? cl(r, e) : () => r[e]) : e.bind(r, r)
  let i
  Z(t) ? (i = t) : ((i = t.handler), (n = t))
  const o = Se
  Sn(this)
  const a = ki(s, i.bind(r), n)
  return o ? Sn(o) : rn(), a
}
function cl(e, t) {
  const n = t.split(".")
  return () => {
    let r = e
    for (let s = 0; s < n.length && r; s++) r = r[n[s]]
    return r
  }
}
function tn(e, t) {
  if (!be(e) || e.__v_skip || ((t = t || new Set()), t.has(e))) return e
  if ((t.add(e), $e(e))) tn(e.value, t)
  else if (J(e)) for (let n = 0; n < e.length; n++) tn(e[n], t)
  else if (Da(e) || xn(e))
    e.forEach((n) => {
      tn(n, t)
    })
  else if (La(e)) for (const n in e) tn(e[n], t)
  return e
}
function ur(e) {
  return Z(e) ? { setup: e, name: e.name } : e
}
const kr = (e) => !!e.type.__asyncLoader,
  fl = (e) => e.type.__isKeepAlive
function qc(e, t) {
  dl(e, "a", t)
}
function Kc(e, t) {
  dl(e, "da", t)
}
function dl(e, t, n = Se) {
  const r =
    e.__wdc ||
    (e.__wdc = () => {
      let s = n
      for (; s; ) {
        if (s.isDeactivated) return
        s = s.parent
      }
      return e()
    })
  if ((cs(t, r, n), n)) {
    let s = n.parent
    for (; s && s.parent; ) fl(s.parent.vnode) && Yc(r, t, n, s), (s = s.parent)
  }
}
function Yc(e, t, n, r) {
  const s = cs(t, e, r, !0)
  Ci(() => {
    ci(r[t], s)
  }, n)
}
function cs(e, t, n = Se, r = !1) {
  if (n) {
    const s = n[e] || (n[e] = []),
      i =
        t.__weh ||
        (t.__weh = (...o) => {
          if (n.isUnmounted) return
          Fn(), Sn(n)
          const a = it(t, n, e, o)
          return rn(), Nn(), a
        })
    return r ? s.unshift(i) : s.push(i), i
  }
}
const Tt =
    (e) =>
    (t, n = Se) =>
      (!sr || e === "sp") && cs(e, (...r) => t(...r), n),
  Gc = Tt("bm"),
  pl = Tt("m"),
  Qc = Tt("bu"),
  Jc = Tt("u"),
  Xc = Tt("bum"),
  Ci = Tt("um"),
  Zc = Tt("sp"),
  ef = Tt("rtg"),
  tf = Tt("rtc")
function nf(e, t = Se) {
  cs("ec", e, t)
}
function Ft(e, t) {
  const n = Qe
  if (n === null) return e
  const r = ds(n) || n.proxy,
    s = e.dirs || (e.dirs = [])
  for (let i = 0; i < t.length; i++) {
    let [o, a, l, d = me] = t[i]
    Z(o) && (o = { mounted: o, updated: o }), o.deep && tn(a), s.push({ dir: o, instance: r, value: a, oldValue: void 0, arg: l, modifiers: d })
  }
  return e
}
function Kt(e, t, n, r) {
  const s = e.dirs,
    i = t && t.dirs
  for (let o = 0; o < s.length; o++) {
    const a = s[o]
    i && (a.oldValue = i[o].value)
    let l = a.dir[r]
    l && (Fn(), it(l, n, 8, [e.el, a, e, t]), Nn())
  }
}
const hl = "components"
function rf(e, t) {
  return of(hl, e, !0, t) || e
}
const sf = Symbol()
function of(e, t, n = !0, r = !1) {
  const s = Qe || Se
  if (s) {
    const i = s.type
    if (e === hl) {
      const a = Ff(i, !1)
      if (a && (a === t || a === yt(t) || a === ss(yt(t)))) return i
    }
    const o = uo(s[e] || i[e], t) || uo(s.appContext[e], t)
    return !o && r ? i : o
  }
}
function uo(e, t) {
  return e && (e[t] || e[yt(t)] || e[ss(yt(t))])
}
function Ut(e, t, n, r) {
  let s
  const i = n && n[r]
  if (J(e) || Oe(e)) {
    s = new Array(e.length)
    for (let o = 0, a = e.length; o < a; o++) s[o] = t(e[o], o, void 0, i && i[o])
  } else if (typeof e == "number") {
    s = new Array(e)
    for (let o = 0; o < e; o++) s[o] = t(o + 1, o, void 0, i && i[o])
  } else if (be(e))
    if (e[Symbol.iterator]) s = Array.from(e, (o, a) => t(o, a, void 0, i && i[a]))
    else {
      const o = Object.keys(e)
      s = new Array(o.length)
      for (let a = 0, l = o.length; a < l; a++) {
        const d = o[a]
        s[a] = t(e[d], d, a, i && i[a])
      }
    }
  else s = []
  return n && (n[r] = s), s
}
const Ds = (e) => (e ? (kl(e) ? ds(e) || e.proxy : Ds(e.parent)) : null),
  Fr = Fe(Object.create(null), {
    $: (e) => e,
    $el: (e) => e.vnode.el,
    $data: (e) => e.data,
    $props: (e) => e.props,
    $attrs: (e) => e.attrs,
    $slots: (e) => e.slots,
    $refs: (e) => e.refs,
    $parent: (e) => Ds(e.parent),
    $root: (e) => Ds(e.root),
    $emit: (e) => e.emit,
    $options: (e) => Pi(e),
    $forceUpdate: (e) => e.f || (e.f = () => xi(e.update)),
    $nextTick: (e) => e.n || (e.n = as.bind(e.proxy)),
    $watch: (e) => Vc.bind(e),
  }),
  af = {
    get({ _: e }, t) {
      const { ctx: n, setupState: r, data: s, props: i, accessCache: o, type: a, appContext: l } = e
      let d
      if (t[0] !== "$") {
        const p = o[t]
        if (p !== void 0)
          switch (p) {
            case 1:
              return r[t]
            case 2:
              return s[t]
            case 4:
              return n[t]
            case 3:
              return i[t]
          }
        else {
          if (r !== me && ie(r, t)) return (o[t] = 1), r[t]
          if (s !== me && ie(s, t)) return (o[t] = 2), s[t]
          if ((d = e.propsOptions[0]) && ie(d, t)) return (o[t] = 3), i[t]
          if (n !== me && ie(n, t)) return (o[t] = 4), n[t]
          Fs && (o[t] = 0)
        }
      }
      const f = Fr[t]
      let u, c
      if (f) return t === "$attrs" && Ke(e, "get", t), f(e)
      if ((u = a.__cssModules) && (u = u[t])) return u
      if (n !== me && ie(n, t)) return (o[t] = 4), n[t]
      if (((c = l.config.globalProperties), ie(c, t))) return c[t]
    },
    set({ _: e }, t, n) {
      const { data: r, setupState: s, ctx: i } = e
      return s !== me && ie(s, t) ? ((s[t] = n), !0) : r !== me && ie(r, t) ? ((r[t] = n), !0) : ie(e.props, t) || (t[0] === "$" && t.slice(1) in e) ? !1 : ((i[t] = n), !0)
    },
    has({ _: { data: e, setupState: t, accessCache: n, ctx: r, appContext: s, propsOptions: i } }, o) {
      let a
      return !!n[o] || (e !== me && ie(e, o)) || (t !== me && ie(t, o)) || ((a = i[0]) && ie(a, o)) || ie(r, o) || ie(Fr, o) || ie(s.config.globalProperties, o)
    },
    defineProperty(e, t, n) {
      return n.get != null ? (e._.accessCache[t] = 0) : ie(n, "value") && this.set(e, t, n.value, null), Reflect.defineProperty(e, t, n)
    },
  }
let Fs = !0
function lf(e) {
  const t = Pi(e),
    n = e.proxy,
    r = e.ctx
  ;(Fs = !1), t.beforeCreate && co(t.beforeCreate, e, "bc")
  const {
    data: s,
    computed: i,
    methods: o,
    watch: a,
    provide: l,
    inject: d,
    created: f,
    beforeMount: u,
    mounted: c,
    beforeUpdate: p,
    updated: $,
    activated: b,
    deactivated: w,
    beforeDestroy: g,
    beforeUnmount: k,
    destroyed: M,
    unmounted: _,
    render: P,
    renderTracked: T,
    renderTriggered: v,
    errorCaptured: A,
    serverPrefetch: D,
    expose: Y,
    inheritAttrs: K,
    components: G,
    directives: ue,
    filters: xe,
  } = t
  if ((d && uf(d, r, null, e.appContext.config.unwrapInjectedRef), o))
    for (const X in o) {
      const ce = o[X]
      Z(ce) && (r[X] = ce.bind(n))
    }
  if (s) {
    const X = s.call(n, n)
    be(X) && (e.data = pt(X))
  }
  if (((Fs = !0), i))
    for (const X in i) {
      const ce = i[X],
        Te = Z(ce) ? ce.bind(n, n) : Z(ce.get) ? ce.get.bind(n, n) : st,
        Ye = !Z(ce) && Z(ce.set) ? ce.set.bind(n) : st,
        Me = ke({ get: Te, set: Ye })
      Object.defineProperty(r, X, { enumerable: !0, configurable: !0, get: () => Me.value, set: (Le) => (Me.value = Le) })
    }
  if (a) for (const X in a) ml(a[X], r, n, X)
  if (l) {
    const X = Z(l) ? l.call(n) : l
    Reflect.ownKeys(X).forEach((ce) => {
      Kn(ce, X[ce])
    })
  }
  f && co(f, e, "c")
  function z(X, ce) {
    J(ce) ? ce.forEach((Te) => X(Te.bind(n))) : ce && X(ce.bind(n))
  }
  if ((z(Gc, u), z(pl, c), z(Qc, p), z(Jc, $), z(qc, b), z(Kc, w), z(nf, A), z(tf, T), z(ef, v), z(Xc, k), z(Ci, _), z(Zc, D), J(Y)))
    if (Y.length) {
      const X = e.exposed || (e.exposed = {})
      Y.forEach((ce) => {
        Object.defineProperty(X, ce, { get: () => n[ce], set: (Te) => (n[ce] = Te) })
      })
    } else e.exposed || (e.exposed = {})
  P && e.render === st && (e.render = P), K != null && (e.inheritAttrs = K), G && (e.components = G), ue && (e.directives = ue)
}
function uf(e, t, n = st, r = !1) {
  J(e) && (e = Ns(e))
  for (const s in e) {
    const i = e[s]
    let o
    be(i) ? ("default" in i ? (o = Je(i.from || s, i.default, !0)) : (o = Je(i.from || s))) : (o = Je(i)),
      $e(o) && r ? Object.defineProperty(t, s, { enumerable: !0, configurable: !0, get: () => o.value, set: (a) => (o.value = a) }) : (t[s] = o)
  }
}
function co(e, t, n) {
  it(J(e) ? e.map((r) => r.bind(t.proxy)) : e.bind(t.proxy), t, n)
}
function ml(e, t, n, r) {
  const s = r.includes(".") ? cl(n, r) : () => n[r]
  if (Oe(e)) {
    const i = t[e]
    Z(i) && Ve(s, i)
  } else if (Z(e)) Ve(s, e.bind(n))
  else if (be(e))
    if (J(e)) e.forEach((i) => ml(i, t, n, r))
    else {
      const i = Z(e.handler) ? e.handler.bind(n) : t[e.handler]
      Z(i) && Ve(s, i, e)
    }
}
function Pi(e) {
  const t = e.type,
    { mixins: n, extends: r } = t,
    {
      mixins: s,
      optionsCache: i,
      config: { optionMergeStrategies: o },
    } = e.appContext,
    a = i.get(t)
  let l
  return a ? (l = a) : !s.length && !n && !r ? (l = t) : ((l = {}), s.length && s.forEach((d) => Nr(l, d, o, !0)), Nr(l, t, o)), be(t) && i.set(t, l), l
}
function Nr(e, t, n, r = !1) {
  const { mixins: s, extends: i } = t
  i && Nr(e, i, n, !0), s && s.forEach((o) => Nr(e, o, n, !0))
  for (const o in t)
    if (!(r && o === "expose")) {
      const a = cf[o] || (n && n[o])
      e[o] = a ? a(e[o], t[o]) : t[o]
    }
  return e
}
const cf = {
  data: fo,
  props: Gt,
  emits: Gt,
  methods: Gt,
  computed: Gt,
  beforeCreate: Ie,
  created: Ie,
  beforeMount: Ie,
  mounted: Ie,
  beforeUpdate: Ie,
  updated: Ie,
  beforeDestroy: Ie,
  beforeUnmount: Ie,
  destroyed: Ie,
  unmounted: Ie,
  activated: Ie,
  deactivated: Ie,
  errorCaptured: Ie,
  serverPrefetch: Ie,
  components: Gt,
  directives: Gt,
  watch: df,
  provide: fo,
  inject: ff,
}
function fo(e, t) {
  return t
    ? e
      ? function () {
          return Fe(Z(e) ? e.call(this, this) : e, Z(t) ? t.call(this, this) : t)
        }
      : t
    : e
}
function ff(e, t) {
  return Gt(Ns(e), Ns(t))
}
function Ns(e) {
  if (J(e)) {
    const t = {}
    for (let n = 0; n < e.length; n++) t[e[n]] = e[n]
    return t
  }
  return e
}
function Ie(e, t) {
  return e ? [...new Set([].concat(e, t))] : t
}
function Gt(e, t) {
  return e ? Fe(Fe(Object.create(null), e), t) : t
}
function df(e, t) {
  if (!e) return t
  if (!t) return e
  const n = Fe(Object.create(null), e)
  for (const r in t) n[r] = Ie(e[r], t[r])
  return n
}
function pf(e, t, n, r = !1) {
  const s = {},
    i = {}
  Rr(i, fs, 1), (e.propsDefaults = Object.create(null)), gl(e, t, s, i)
  for (const o in e.propsOptions[0]) o in s || (s[o] = void 0)
  n ? (e.props = r ? s : Cc(s)) : e.type.props ? (e.props = s) : (e.props = i), (e.attrs = i)
}
function hf(e, t, n, r) {
  const {
      props: s,
      attrs: i,
      vnode: { patchFlag: o },
    } = e,
    a = fe(s),
    [l] = e.propsOptions
  let d = !1
  if ((r || o > 0) && !(o & 16)) {
    if (o & 8) {
      const f = e.vnode.dynamicProps
      for (let u = 0; u < f.length; u++) {
        let c = f[u]
        if (ls(e.emitsOptions, c)) continue
        const p = t[c]
        if (l)
          if (ie(i, c)) p !== i[c] && ((i[c] = p), (d = !0))
          else {
            const $ = yt(c)
            s[$] = Ls(l, a, $, p, e, !1)
          }
        else p !== i[c] && ((i[c] = p), (d = !0))
      }
    }
  } else {
    gl(e, t, s, i) && (d = !0)
    let f
    for (const u in a) (!t || (!ie(t, u) && ((f = cn(u)) === u || !ie(t, f)))) && (l ? n && (n[u] !== void 0 || n[f] !== void 0) && (s[u] = Ls(l, a, u, void 0, e, !0)) : delete s[u])
    if (i !== a) for (const u in i) (!t || (!ie(t, u) && !0)) && (delete i[u], (d = !0))
  }
  d && Ot(e, "set", "$attrs")
}
function gl(e, t, n, r) {
  const [s, i] = e.propsOptions
  let o = !1,
    a
  if (t)
    for (let l in t) {
      if ($r(l)) continue
      const d = t[l]
      let f
      s && ie(s, (f = yt(l))) ? (!i || !i.includes(f) ? (n[f] = d) : ((a || (a = {}))[f] = d)) : ls(e.emitsOptions, l) || ((!(l in r) || d !== r[l]) && ((r[l] = d), (o = !0)))
    }
  if (i) {
    const l = fe(n),
      d = a || me
    for (let f = 0; f < i.length; f++) {
      const u = i[f]
      n[u] = Ls(s, l, u, d[u], e, !ie(d, u))
    }
  }
  return o
}
function Ls(e, t, n, r, s, i) {
  const o = e[n]
  if (o != null) {
    const a = ie(o, "default")
    if (a && r === void 0) {
      const l = o.default
      if (o.type !== Function && Z(l)) {
        const { propsDefaults: d } = s
        n in d ? (r = d[n]) : (Sn(s), (r = d[n] = l.call(null, t)), rn())
      } else r = l
    }
    o[0] && (i && !a ? (r = !1) : o[1] && (r === "" || r === cn(n)) && (r = !0))
  }
  return r
}
function vl(e, t, n = !1) {
  const r = t.propsCache,
    s = r.get(e)
  if (s) return s
  const i = e.props,
    o = {},
    a = []
  let l = !1
  if (!Z(e)) {
    const f = (u) => {
      l = !0
      const [c, p] = vl(u, t, !0)
      Fe(o, c), p && a.push(...p)
    }
    !n && t.mixins.length && t.mixins.forEach(f), e.extends && f(e.extends), e.mixins && e.mixins.forEach(f)
  }
  if (!i && !l) return be(e) && r.set(e, $n), $n
  if (J(i))
    for (let f = 0; f < i.length; f++) {
      const u = yt(i[f])
      po(u) && (o[u] = me)
    }
  else if (i)
    for (const f in i) {
      const u = yt(f)
      if (po(u)) {
        const c = i[f],
          p = (o[u] = J(c) || Z(c) ? { type: c } : c)
        if (p) {
          const $ = go(Boolean, p.type),
            b = go(String, p.type)
          ;(p[0] = $ > -1), (p[1] = b < 0 || $ < b), ($ > -1 || ie(p, "default")) && a.push(u)
        }
      }
    }
  const d = [o, a]
  return be(e) && r.set(e, d), d
}
function po(e) {
  return e[0] !== "$"
}
function ho(e) {
  const t = e && e.toString().match(/^\s*function (\w+)/)
  return t ? t[1] : e === null ? "null" : ""
}
function mo(e, t) {
  return ho(e) === ho(t)
}
function go(e, t) {
  return J(t) ? t.findIndex((n) => mo(n, e)) : Z(t) && mo(t, e) ? 0 : -1
}
const yl = (e) => e[0] === "_" || e === "$stable",
  Oi = (e) => (J(e) ? e.map(ft) : [ft(e)]),
  mf = (e, t, n) => {
    if (t._n) return t
    const r = Nc((...s) => Oi(t(...s)), n)
    return (r._c = !1), r
  },
  bl = (e, t, n) => {
    const r = e._ctx
    for (const s in e) {
      if (yl(s)) continue
      const i = e[s]
      if (Z(i)) t[s] = mf(s, i, r)
      else if (i != null) {
        const o = Oi(i)
        t[s] = () => o
      }
    }
  },
  wl = (e, t) => {
    const n = Oi(t)
    e.slots.default = () => n
  },
  gf = (e, t) => {
    if (e.vnode.shapeFlag & 32) {
      const n = t._
      n ? ((e.slots = fe(t)), Rr(t, "_", n)) : bl(t, (e.slots = {}))
    } else (e.slots = {}), t && wl(e, t)
    Rr(e.slots, fs, 1)
  },
  vf = (e, t, n) => {
    const { vnode: r, slots: s } = e
    let i = !0,
      o = me
    if (r.shapeFlag & 32) {
      const a = t._
      a ? (n && a === 1 ? (i = !1) : (Fe(s, t), !n && a === 1 && delete s._)) : ((i = !t.$stable), bl(t, s)), (o = t)
    } else t && (wl(e, t), (o = { default: 1 }))
    if (i) for (const a in s) !yl(a) && !(a in o) && delete s[a]
  }
function _l() {
  return {
    app: null,
    config: { isNativeTag: zu, performance: !1, globalProperties: {}, optionMergeStrategies: {}, errorHandler: void 0, warnHandler: void 0, compilerOptions: {} },
    mixins: [],
    components: {},
    directives: {},
    provides: Object.create(null),
    optionsCache: new WeakMap(),
    propsCache: new WeakMap(),
    emitsCache: new WeakMap(),
  }
}
let yf = 0
function bf(e, t) {
  return function (r, s = null) {
    Z(r) || (r = Object.assign({}, r)), s != null && !be(s) && (s = null)
    const i = _l(),
      o = new Set()
    let a = !1
    const l = (i.app = {
      _uid: yf++,
      _component: r,
      _props: s,
      _container: null,
      _context: i,
      _instance: null,
      version: Lf,
      get config() {
        return i.config
      },
      set config(d) {},
      use(d, ...f) {
        return o.has(d) || (d && Z(d.install) ? (o.add(d), d.install(l, ...f)) : Z(d) && (o.add(d), d(l, ...f))), l
      },
      mixin(d) {
        return i.mixins.includes(d) || i.mixins.push(d), l
      },
      component(d, f) {
        return f ? ((i.components[d] = f), l) : i.components[d]
      },
      directive(d, f) {
        return f ? ((i.directives[d] = f), l) : i.directives[d]
      },
      mount(d, f, u) {
        if (!a) {
          const c = Re(r, s)
          return (c.appContext = i), f && t ? t(c, d) : e(c, d, u), (a = !0), (l._container = d), (d.__vue_app__ = l), ds(c.component) || c.component.proxy
        }
      },
      unmount() {
        a && (e(null, l._container), delete l._container.__vue_app__)
      },
      provide(d, f) {
        return (i.provides[d] = f), l
      },
    })
    return l
  }
}
function Us(e, t, n, r, s = !1) {
  if (J(e)) {
    e.forEach((c, p) => Us(c, t && (J(t) ? t[p] : t), n, r, s))
    return
  }
  if (kr(r) && !s) return
  const i = r.shapeFlag & 4 ? ds(r.component) || r.component.proxy : r.el,
    o = s ? null : i,
    { i: a, r: l } = e,
    d = t && t.r,
    f = a.refs === me ? (a.refs = {}) : a.refs,
    u = a.setupState
  if ((d != null && d !== l && (Oe(d) ? ((f[d] = null), ie(u, d) && (u[d] = null)) : $e(d) && (d.value = null)), Z(l))) Ht(l, a, 12, [o, f])
  else {
    const c = Oe(l),
      p = $e(l)
    if (c || p) {
      const $ = () => {
        if (e.f) {
          const b = c ? f[l] : l.value
          s ? J(b) && ci(b, i) : J(b) ? b.includes(i) || b.push(i) : c ? ((f[l] = [i]), ie(u, l) && (u[l] = f[l])) : ((l.value = [i]), e.k && (f[e.k] = l.value))
        } else c ? ((f[l] = o), ie(u, l) && (u[l] = o)) : p && ((l.value = o), e.k && (f[e.k] = o))
      }
      o ? (($.id = -1), We($, n)) : $()
    }
  }
}
const We = Bc
function wf(e) {
  return _f(e)
}
function _f(e, t) {
  const n = Gu()
  n.__VUE__ = !0
  const {
      insert: r,
      remove: s,
      patchProp: i,
      createElement: o,
      createText: a,
      createComment: l,
      setText: d,
      setElementText: f,
      parentNode: u,
      nextSibling: c,
      setScopeId: p = st,
      insertStaticContent: $,
    } = e,
    b = (h, m, x, C = null, E = null, R = null, N = !1, j = null, I = !!m.dynamicChildren) => {
      if (h === m) return
      h && !Un(h, m) && ((C = F(h)), Le(h, E, R, !0), (h = null)), m.patchFlag === -2 && ((I = !1), (m.dynamicChildren = null))
      const { type: S, ref: B, shapeFlag: W } = m
      switch (S) {
        case Si:
          w(h, m, x, C)
          break
        case sn:
          g(h, m, x, C)
          break
        case Cr:
          h == null && k(m, x, C, N)
          break
        case Pe:
          G(h, m, x, C, E, R, N, j, I)
          break
        default:
          W & 1 ? P(h, m, x, C, E, R, N, j, I) : W & 6 ? ue(h, m, x, C, E, R, N, j, I) : (W & 64 || W & 128) && S.process(h, m, x, C, E, R, N, j, I, oe)
      }
      B != null && E && Us(B, h && h.ref, R, m || h, !m)
    },
    w = (h, m, x, C) => {
      if (h == null) r((m.el = a(m.children)), x, C)
      else {
        const E = (m.el = h.el)
        m.children !== h.children && d(E, m.children)
      }
    },
    g = (h, m, x, C) => {
      h == null ? r((m.el = l(m.children || "")), x, C) : (m.el = h.el)
    },
    k = (h, m, x, C) => {
      ;[h.el, h.anchor] = $(h.children, m, x, C, h.el, h.anchor)
    },
    M = ({ el: h, anchor: m }, x, C) => {
      let E
      for (; h && h !== m; ) (E = c(h)), r(h, x, C), (h = E)
      r(m, x, C)
    },
    _ = ({ el: h, anchor: m }) => {
      let x
      for (; h && h !== m; ) (x = c(h)), s(h), (h = x)
      s(m)
    },
    P = (h, m, x, C, E, R, N, j, I) => {
      ;(N = N || m.type === "svg"), h == null ? T(m, x, C, E, R, N, j, I) : D(h, m, E, R, N, j, I)
    },
    T = (h, m, x, C, E, R, N, j) => {
      let I, S
      const { type: B, props: W, shapeFlag: V, transition: Q, dirs: re } = h
      if (((I = h.el = o(h.type, R, W && W.is, W)), V & 8 ? f(I, h.children) : V & 16 && A(h.children, I, null, C, E, R && B !== "foreignObject", N, j), re && Kt(h, null, C, "created"), W)) {
        for (const he in W) he !== "value" && !$r(he) && i(I, he, null, W[he], R, h.children, C, E, L)
        "value" in W && i(I, "value", null, W.value), (S = W.onVnodeBeforeMount) && ut(S, C, h)
      }
      v(I, h, h.scopeId, N, C), re && Kt(h, null, C, "beforeMount")
      const ge = (!E || (E && !E.pendingBranch)) && Q && !Q.persisted
      ge && Q.beforeEnter(I),
        r(I, m, x),
        ((S = W && W.onVnodeMounted) || ge || re) &&
          We(() => {
            S && ut(S, C, h), ge && Q.enter(I), re && Kt(h, null, C, "mounted")
          }, E)
    },
    v = (h, m, x, C, E) => {
      if ((x && p(h, x), C)) for (let R = 0; R < C.length; R++) p(h, C[R])
      if (E) {
        let R = E.subTree
        if (m === R) {
          const N = E.vnode
          v(h, N, N.scopeId, N.slotScopeIds, E.parent)
        }
      }
    },
    A = (h, m, x, C, E, R, N, j, I = 0) => {
      for (let S = I; S < h.length; S++) {
        const B = (h[S] = j ? It(h[S]) : ft(h[S]))
        b(null, B, m, x, C, E, R, N, j)
      }
    },
    D = (h, m, x, C, E, R, N) => {
      const j = (m.el = h.el)
      let { patchFlag: I, dynamicChildren: S, dirs: B } = m
      I |= h.patchFlag & 16
      const W = h.props || me,
        V = m.props || me
      let Q
      x && Yt(x, !1), (Q = V.onVnodeBeforeUpdate) && ut(Q, x, m, h), B && Kt(m, h, x, "beforeUpdate"), x && Yt(x, !0)
      const re = E && m.type !== "foreignObject"
      if ((S ? Y(h.dynamicChildren, S, j, x, C, re, R) : N || ce(h, m, j, null, x, C, re, R, !1), I > 0)) {
        if (I & 16) K(j, m, W, V, x, C, E)
        else if ((I & 2 && W.class !== V.class && i(j, "class", null, V.class, E), I & 4 && i(j, "style", W.style, V.style, E), I & 8)) {
          const ge = m.dynamicProps
          for (let he = 0; he < ge.length; he++) {
            const Ce = ge[he],
              Xe = W[Ce],
              hn = V[Ce]
            ;(hn !== Xe || Ce === "value") && i(j, Ce, Xe, hn, E, h.children, x, C, L)
          }
        }
        I & 1 && h.children !== m.children && f(j, m.children)
      } else !N && S == null && K(j, m, W, V, x, C, E)
      ;((Q = V.onVnodeUpdated) || B) &&
        We(() => {
          Q && ut(Q, x, m, h), B && Kt(m, h, x, "updated")
        }, C)
    },
    Y = (h, m, x, C, E, R, N) => {
      for (let j = 0; j < m.length; j++) {
        const I = h[j],
          S = m[j],
          B = I.el && (I.type === Pe || !Un(I, S) || I.shapeFlag & 70) ? u(I.el) : x
        b(I, S, B, null, C, E, R, N, !0)
      }
    },
    K = (h, m, x, C, E, R, N) => {
      if (x !== C) {
        if (x !== me) for (const j in x) !$r(j) && !(j in C) && i(h, j, x[j], null, N, m.children, E, R, L)
        for (const j in C) {
          if ($r(j)) continue
          const I = C[j],
            S = x[j]
          I !== S && j !== "value" && i(h, j, S, I, N, m.children, E, R, L)
        }
        "value" in C && i(h, "value", x.value, C.value)
      }
    },
    G = (h, m, x, C, E, R, N, j, I) => {
      const S = (m.el = h ? h.el : a("")),
        B = (m.anchor = h ? h.anchor : a(""))
      let { patchFlag: W, dynamicChildren: V, slotScopeIds: Q } = m
      Q && (j = j ? j.concat(Q) : Q),
        h == null
          ? (r(S, x, C), r(B, x, C), A(m.children, x, B, E, R, N, j, I))
          : W > 0 && W & 64 && V && h.dynamicChildren
          ? (Y(h.dynamicChildren, V, x, E, R, N, j), (m.key != null || (E && m === E.subTree)) && Ei(h, m, !0))
          : ce(h, m, x, B, E, R, N, j, I)
    },
    ue = (h, m, x, C, E, R, N, j, I) => {
      ;(m.slotScopeIds = j), h == null ? (m.shapeFlag & 512 ? E.ctx.activate(m, x, C, N, I) : xe(m, x, C, E, R, N, I)) : ae(h, m, I)
    },
    xe = (h, m, x, C, E, R, N) => {
      const j = (h.component = Mf(h, C, E))
      if ((fl(h) && (j.ctx.renderer = oe), jf(j), j.asyncDep)) {
        if ((E && E.registerDep(j, z), !h.el)) {
          const I = (j.subTree = Re(sn))
          g(null, I, m, x)
        }
        return
      }
      z(j, h, m, x, E, R, N)
    },
    ae = (h, m, x) => {
      const C = (m.component = h.component)
      if (Wc(h, m, x))
        if (C.asyncDep && !C.asyncResolved) {
          X(C, m, x)
          return
        } else (C.next = m), Rc(C.update), C.update()
      else (m.el = h.el), (C.vnode = m)
    },
    z = (h, m, x, C, E, R, N) => {
      const j = () => {
          if (h.isMounted) {
            let { next: B, bu: W, u: V, parent: Q, vnode: re } = h,
              ge = B,
              he
            Yt(h, !1), B ? ((B.el = re.el), X(h, B, N)) : (B = re), W && xr(W), (he = B.props && B.props.onVnodeBeforeUpdate) && ut(he, Q, B, re), Yt(h, !0)
            const Ce = ys(h),
              Xe = h.subTree
            ;(h.subTree = Ce),
              b(Xe, Ce, u(Xe.el), F(Xe), h, E, R),
              (B.el = Ce.el),
              ge === null && Hc(h, Ce.el),
              V && We(V, E),
              (he = B.props && B.props.onVnodeUpdated) && We(() => ut(he, Q, B, re), E)
          } else {
            let B
            const { el: W, props: V } = m,
              { bm: Q, m: re, parent: ge } = h,
              he = kr(m)
            if ((Yt(h, !1), Q && xr(Q), !he && (B = V && V.onVnodeBeforeMount) && ut(B, ge, m), Yt(h, !0), W && te)) {
              const Ce = () => {
                ;(h.subTree = ys(h)), te(W, h.subTree, h, E, null)
              }
              he ? m.type.__asyncLoader().then(() => !h.isUnmounted && Ce()) : Ce()
            } else {
              const Ce = (h.subTree = ys(h))
              b(null, Ce, x, C, h, E, R), (m.el = Ce.el)
            }
            if ((re && We(re, E), !he && (B = V && V.onVnodeMounted))) {
              const Ce = m
              We(() => ut(B, ge, Ce), E)
            }
            ;(m.shapeFlag & 256 || (ge && kr(ge.vnode) && ge.vnode.shapeFlag & 256)) && h.a && We(h.a, E), (h.isMounted = !0), (m = x = C = null)
          }
        },
        I = (h.effect = new hi(j, () => xi(S), h.scope)),
        S = (h.update = () => I.run())
      ;(S.id = h.uid), Yt(h, !0), S()
    },
    X = (h, m, x) => {
      m.component = h
      const C = h.vnode.props
      ;(h.vnode = m), (h.next = null), hf(h, m.props, C, x), vf(h, m.children, x), Fn(), oo(), Nn()
    },
    ce = (h, m, x, C, E, R, N, j, I = !1) => {
      const S = h && h.children,
        B = h ? h.shapeFlag : 0,
        W = m.children,
        { patchFlag: V, shapeFlag: Q } = m
      if (V > 0) {
        if (V & 128) {
          Ye(S, W, x, C, E, R, N, j, I)
          return
        } else if (V & 256) {
          Te(S, W, x, C, E, R, N, j, I)
          return
        }
      }
      Q & 8 ? (B & 16 && L(S, E, R), W !== S && f(x, W)) : B & 16 ? (Q & 16 ? Ye(S, W, x, C, E, R, N, j, I) : L(S, E, R, !0)) : (B & 8 && f(x, ""), Q & 16 && A(W, x, C, E, R, N, j, I))
    },
    Te = (h, m, x, C, E, R, N, j, I) => {
      ;(h = h || $n), (m = m || $n)
      const S = h.length,
        B = m.length,
        W = Math.min(S, B)
      let V
      for (V = 0; V < W; V++) {
        const Q = (m[V] = I ? It(m[V]) : ft(m[V]))
        b(h[V], Q, x, null, E, R, N, j, I)
      }
      S > B ? L(h, E, R, !0, !1, W) : A(m, x, C, E, R, N, j, I, W)
    },
    Ye = (h, m, x, C, E, R, N, j, I) => {
      let S = 0
      const B = m.length
      let W = h.length - 1,
        V = B - 1
      for (; S <= W && S <= V; ) {
        const Q = h[S],
          re = (m[S] = I ? It(m[S]) : ft(m[S]))
        if (Un(Q, re)) b(Q, re, x, null, E, R, N, j, I)
        else break
        S++
      }
      for (; S <= W && S <= V; ) {
        const Q = h[W],
          re = (m[V] = I ? It(m[V]) : ft(m[V]))
        if (Un(Q, re)) b(Q, re, x, null, E, R, N, j, I)
        else break
        W--, V--
      }
      if (S > W) {
        if (S <= V) {
          const Q = V + 1,
            re = Q < B ? m[Q].el : C
          for (; S <= V; ) b(null, (m[S] = I ? It(m[S]) : ft(m[S])), x, re, E, R, N, j, I), S++
        }
      } else if (S > V) for (; S <= W; ) Le(h[S], E, R, !0), S++
      else {
        const Q = S,
          re = S,
          ge = new Map()
        for (S = re; S <= V; S++) {
          const He = (m[S] = I ? It(m[S]) : ft(m[S]))
          He.key != null && ge.set(He.key, S)
        }
        let he,
          Ce = 0
        const Xe = V - re + 1
        let hn = !1,
          Gi = 0
        const Ln = new Array(Xe)
        for (S = 0; S < Xe; S++) Ln[S] = 0
        for (S = Q; S <= W; S++) {
          const He = h[S]
          if (Ce >= Xe) {
            Le(He, E, R, !0)
            continue
          }
          let lt
          if (He.key != null) lt = ge.get(He.key)
          else
            for (he = re; he <= V; he++)
              if (Ln[he - re] === 0 && Un(He, m[he])) {
                lt = he
                break
              }
          lt === void 0 ? Le(He, E, R, !0) : ((Ln[lt - re] = S + 1), lt >= Gi ? (Gi = lt) : (hn = !0), b(He, m[lt], x, null, E, R, N, j, I), Ce++)
        }
        const Qi = hn ? $f(Ln) : $n
        for (he = Qi.length - 1, S = Xe - 1; S >= 0; S--) {
          const He = re + S,
            lt = m[He],
            Ji = He + 1 < B ? m[He + 1].el : C
          Ln[S] === 0 ? b(null, lt, x, Ji, E, R, N, j, I) : hn && (he < 0 || S !== Qi[he] ? Me(lt, x, Ji, 2) : he--)
        }
      }
    },
    Me = (h, m, x, C, E = null) => {
      const { el: R, type: N, transition: j, children: I, shapeFlag: S } = h
      if (S & 6) {
        Me(h.component.subTree, m, x, C)
        return
      }
      if (S & 128) {
        h.suspense.move(m, x, C)
        return
      }
      if (S & 64) {
        N.move(h, m, x, oe)
        return
      }
      if (N === Pe) {
        r(R, m, x)
        for (let W = 0; W < I.length; W++) Me(I[W], m, x, C)
        r(h.anchor, m, x)
        return
      }
      if (N === Cr) {
        M(h, m, x)
        return
      }
      if (C !== 2 && S & 1 && j)
        if (C === 0) j.beforeEnter(R), r(R, m, x), We(() => j.enter(R), E)
        else {
          const { leave: W, delayLeave: V, afterLeave: Q } = j,
            re = () => r(R, m, x),
            ge = () => {
              W(R, () => {
                re(), Q && Q()
              })
            }
          V ? V(R, re, ge) : ge()
        }
      else r(R, m, x)
    },
    Le = (h, m, x, C = !1, E = !1) => {
      const { type: R, props: N, ref: j, children: I, dynamicChildren: S, shapeFlag: B, patchFlag: W, dirs: V } = h
      if ((j != null && Us(j, null, x, h, !0), B & 256)) {
        m.ctx.deactivate(h)
        return
      }
      const Q = B & 1 && V,
        re = !kr(h)
      let ge
      if ((re && (ge = N && N.onVnodeBeforeUnmount) && ut(ge, m, h), B & 6)) O(h.component, x, C)
      else {
        if (B & 128) {
          h.suspense.unmount(x, C)
          return
        }
        Q && Kt(h, null, m, "beforeUnmount"),
          B & 64 ? h.type.remove(h, m, x, E, oe, C) : S && (R !== Pe || (W > 0 && W & 64)) ? L(S, m, x, !1, !0) : ((R === Pe && W & 384) || (!E && B & 16)) && L(I, m, x),
          C && pn(h)
      }
      ;((re && (ge = N && N.onVnodeUnmounted)) || Q) &&
        We(() => {
          ge && ut(ge, m, h), Q && Kt(h, null, m, "unmounted")
        }, x)
    },
    pn = (h) => {
      const { type: m, el: x, anchor: C, transition: E } = h
      if (m === Pe) {
        pr(x, C)
        return
      }
      if (m === Cr) {
        _(h)
        return
      }
      const R = () => {
        s(x), E && !E.persisted && E.afterLeave && E.afterLeave()
      }
      if (h.shapeFlag & 1 && E && !E.persisted) {
        const { leave: N, delayLeave: j } = E,
          I = () => N(x, R)
        j ? j(h.el, R, I) : I()
      } else R()
    },
    pr = (h, m) => {
      let x
      for (; h !== m; ) (x = c(h)), s(h), (h = x)
      s(m)
    },
    O = (h, m, x) => {
      const { bum: C, scope: E, update: R, subTree: N, um: j } = h
      C && xr(C),
        E.stop(),
        R && ((R.active = !1), Le(N, h, m, x)),
        j && We(j, m),
        We(() => {
          h.isUnmounted = !0
        }, m),
        m && m.pendingBranch && !m.isUnmounted && h.asyncDep && !h.asyncResolved && h.suspenseId === m.pendingId && (m.deps--, m.deps === 0 && m.resolve())
    },
    L = (h, m, x, C = !1, E = !1, R = 0) => {
      for (let N = R; N < h.length; N++) Le(h[N], m, x, C, E)
    },
    F = (h) => (h.shapeFlag & 6 ? F(h.component.subTree) : h.shapeFlag & 128 ? h.suspense.next() : c(h.anchor || h.el)),
    H = (h, m, x) => {
      h == null ? m._vnode && Le(m._vnode, null, null, !0) : b(m._vnode || null, h, m, null, null, null, x), oo(), il(), (m._vnode = h)
    },
    oe = { p: b, um: Le, m: Me, r: pn, mt: xe, mc: A, pc: ce, pbc: Y, n: F, o: e }
  let we, te
  return t && ([we, te] = t(oe)), { render: H, hydrate: we, createApp: bf(H, we) }
}
function Yt({ effect: e, update: t }, n) {
  e.allowRecurse = t.allowRecurse = n
}
function Ei(e, t, n = !1) {
  const r = e.children,
    s = t.children
  if (J(r) && J(s))
    for (let i = 0; i < r.length; i++) {
      const o = r[i]
      let a = s[i]
      a.shapeFlag & 1 && !a.dynamicChildren && ((a.patchFlag <= 0 || a.patchFlag === 32) && ((a = s[i] = It(s[i])), (a.el = o.el)), n || Ei(o, a))
    }
}
function $f(e) {
  const t = e.slice(),
    n = [0]
  let r, s, i, o, a
  const l = e.length
  for (r = 0; r < l; r++) {
    const d = e[r]
    if (d !== 0) {
      if (((s = n[n.length - 1]), e[s] < d)) {
        ;(t[r] = s), n.push(r)
        continue
      }
      for (i = 0, o = n.length - 1; i < o; ) (a = (i + o) >> 1), e[n[a]] < d ? (i = a + 1) : (o = a)
      d < e[n[i]] && (i > 0 && (t[r] = n[i - 1]), (n[i] = r))
    }
  }
  for (i = n.length, o = n[i - 1]; i-- > 0; ) (n[i] = o), (o = t[o])
  return n
}
const xf = (e) => e.__isTeleport,
  Yn = (e) => e && (e.disabled || e.disabled === ""),
  vo = (e) => typeof SVGElement < "u" && e instanceof SVGElement,
  Ws = (e, t) => {
    const n = e && e.to
    return Oe(n) ? (t ? t(n) : null) : n
  },
  kf = {
    __isTeleport: !0,
    process(e, t, n, r, s, i, o, a, l, d) {
      const {
          mc: f,
          pc: u,
          pbc: c,
          o: { insert: p, querySelector: $, createText: b, createComment: w },
        } = d,
        g = Yn(t.props)
      let { shapeFlag: k, children: M, dynamicChildren: _ } = t
      if (e == null) {
        const P = (t.el = b("")),
          T = (t.anchor = b(""))
        p(P, n, r), p(T, n, r)
        const v = (t.target = Ws(t.props, $)),
          A = (t.targetAnchor = b(""))
        v && (p(A, v), (o = o || vo(v)))
        const D = (Y, K) => {
          k & 16 && f(M, Y, K, s, i, o, a, l)
        }
        g ? D(n, T) : v && D(v, A)
      } else {
        t.el = e.el
        const P = (t.anchor = e.anchor),
          T = (t.target = e.target),
          v = (t.targetAnchor = e.targetAnchor),
          A = Yn(e.props),
          D = A ? n : T,
          Y = A ? P : v
        if (((o = o || vo(T)), _ ? (c(e.dynamicChildren, _, D, s, i, o, a), Ei(e, t, !0)) : l || u(e, t, D, Y, s, i, o, a, !1), g)) A || wr(t, n, P, d, 1)
        else if ((t.props && t.props.to) !== (e.props && e.props.to)) {
          const K = (t.target = Ws(t.props, $))
          K && wr(t, K, null, d, 0)
        } else A && wr(t, T, v, d, 1)
      }
    },
    remove(e, t, n, r, { um: s, o: { remove: i } }, o) {
      const { shapeFlag: a, children: l, anchor: d, targetAnchor: f, target: u, props: c } = e
      if ((u && i(f), (o || !Yn(c)) && (i(d), a & 16)))
        for (let p = 0; p < l.length; p++) {
          const $ = l[p]
          s($, t, n, !0, !!$.dynamicChildren)
        }
    },
    move: wr,
    hydrate: Cf,
  }
function wr(e, t, n, { o: { insert: r }, m: s }, i = 2) {
  i === 0 && r(e.targetAnchor, t, n)
  const { el: o, anchor: a, shapeFlag: l, children: d, props: f } = e,
    u = i === 2
  if ((u && r(o, t, n), (!u || Yn(f)) && l & 16)) for (let c = 0; c < d.length; c++) s(d[c], t, n, 2)
  u && r(a, t, n)
}
function Cf(e, t, n, r, s, i, { o: { nextSibling: o, parentNode: a, querySelector: l } }, d) {
  const f = (t.target = Ws(t.props, l))
  if (f) {
    const u = f._lpa || f.firstChild
    if (t.shapeFlag & 16)
      if (Yn(t.props)) (t.anchor = d(o(e), t, a(e), n, r, s, i)), (t.targetAnchor = u)
      else {
        t.anchor = o(e)
        let c = u
        for (; c; )
          if (((c = o(c)), c && c.nodeType === 8 && c.data === "teleport anchor")) {
            ;(t.targetAnchor = c), (f._lpa = t.targetAnchor && o(t.targetAnchor))
            break
          }
        d(u, t, f, n, r, s, i)
      }
  }
  return t.anchor && o(t.anchor)
}
const Nt = kf,
  Pe = Symbol(void 0),
  Si = Symbol(void 0),
  sn = Symbol(void 0),
  Cr = Symbol(void 0),
  Gn = []
let nt = null
function U(e = !1) {
  Gn.push((nt = e ? null : []))
}
function Pf() {
  Gn.pop(), (nt = Gn[Gn.length - 1] || null)
}
let rr = 1
function yo(e) {
  rr += e
}
function $l(e) {
  return (e.dynamicChildren = rr > 0 ? nt || $n : null), Pf(), rr > 0 && nt && nt.push(e), e
}
function q(e, t, n, r, s, i) {
  return $l(y(e, t, n, r, s, i, !0))
}
function Ge(e, t, n, r, s) {
  return $l(Re(e, t, n, r, s, !0))
}
function Hs(e) {
  return e ? e.__v_isVNode === !0 : !1
}
function Un(e, t) {
  return e.type === t.type && e.key === t.key
}
const fs = "__vInternal",
  xl = ({ key: e }) => (e != null ? e : null),
  Pr = ({ ref: e, ref_key: t, ref_for: n }) => (e != null ? (Oe(e) || $e(e) || Z(e) ? { i: Qe, r: e, k: t, f: !!n } : e) : null)
function y(e, t = null, n = null, r = 0, s = null, i = e === Pe ? 0 : 1, o = !1, a = !1) {
  const l = {
    __v_isVNode: !0,
    __v_skip: !0,
    type: e,
    props: t,
    key: t && xl(t),
    ref: t && Pr(t),
    scopeId: us,
    slotScopeIds: null,
    children: n,
    component: null,
    suspense: null,
    ssContent: null,
    ssFallback: null,
    dirs: null,
    transition: null,
    el: null,
    anchor: null,
    target: null,
    targetAnchor: null,
    staticCount: 0,
    shapeFlag: i,
    patchFlag: r,
    dynamicProps: s,
    dynamicChildren: null,
    appContext: null,
  }
  return a ? (Ti(l, n), i & 128 && e.normalize(l)) : n && (l.shapeFlag |= Oe(n) ? 8 : 16), rr > 0 && !o && nt && (l.patchFlag > 0 || i & 6) && l.patchFlag !== 32 && nt.push(l), l
}
const Re = Of
function Of(e, t = null, n = null, r = 0, s = null, i = !1) {
  if (((!e || e === sf) && (e = sn), Hs(e))) {
    const a = En(e, t, !0)
    return n && Ti(a, n), rr > 0 && !i && nt && (a.shapeFlag & 6 ? (nt[nt.indexOf(e)] = a) : nt.push(a)), (a.patchFlag |= -2), a
  }
  if ((Nf(e) && (e = e.__vccOpts), t)) {
    t = Ef(t)
    let { class: a, style: l } = t
    a && !Oe(a) && (t.class = es(a)), be(l) && (Ja(l) && !J(l) && (l = Fe({}, l)), (t.style = tt(l)))
  }
  const o = Oe(e) ? 1 : zc(e) ? 128 : xf(e) ? 64 : be(e) ? 4 : Z(e) ? 2 : 0
  return y(e, t, n, r, s, o, i, !0)
}
function Ef(e) {
  return e ? (Ja(e) || fs in e ? Fe({}, e) : e) : null
}
function En(e, t, n = !1) {
  const { props: r, ref: s, patchFlag: i, children: o } = e,
    a = t ? Sf(r || {}, t) : r
  return {
    __v_isVNode: !0,
    __v_skip: !0,
    type: e.type,
    props: a,
    key: a && xl(a),
    ref: t && t.ref ? (n && s ? (J(s) ? s.concat(Pr(t)) : [s, Pr(t)]) : Pr(t)) : s,
    scopeId: e.scopeId,
    slotScopeIds: e.slotScopeIds,
    children: o,
    target: e.target,
    targetAnchor: e.targetAnchor,
    staticCount: e.staticCount,
    shapeFlag: e.shapeFlag,
    patchFlag: t && e.type !== Pe ? (i === -1 ? 16 : i | 16) : i,
    dynamicProps: e.dynamicProps,
    dynamicChildren: e.dynamicChildren,
    appContext: e.appContext,
    dirs: e.dirs,
    transition: e.transition,
    component: e.component,
    suspense: e.suspense,
    ssContent: e.ssContent && En(e.ssContent),
    ssFallback: e.ssFallback && En(e.ssFallback),
    el: e.el,
    anchor: e.anchor,
  }
}
function ht(e = " ", t = 0) {
  return Re(Si, null, e, t)
}
function Ai(e, t) {
  const n = Re(Cr, null, e)
  return (n.staticCount = t), n
}
function ve(e = "", t = !1) {
  return t ? (U(), Ge(sn, null, e)) : Re(sn, null, e)
}
function ft(e) {
  return e == null || typeof e == "boolean" ? Re(sn) : J(e) ? Re(Pe, null, e.slice()) : typeof e == "object" ? It(e) : Re(Si, null, String(e))
}
function It(e) {
  return (e.el === null && e.patchFlag !== -1) || e.memo ? e : En(e)
}
function Ti(e, t) {
  let n = 0
  const { shapeFlag: r } = e
  if (t == null) t = null
  else if (J(t)) n = 16
  else if (typeof t == "object")
    if (r & 65) {
      const s = t.default
      s && (s._c && (s._d = !1), Ti(e, s()), s._c && (s._d = !0))
      return
    } else {
      n = 32
      const s = t._
      !s && !(fs in t) ? (t._ctx = Qe) : s === 3 && Qe && (Qe.slots._ === 1 ? (t._ = 1) : ((t._ = 2), (e.patchFlag |= 1024)))
    }
  else Z(t) ? ((t = { default: t, _ctx: Qe }), (n = 32)) : ((t = String(t)), r & 64 ? ((n = 16), (t = [ht(t)])) : (n = 8))
  ;(e.children = t), (e.shapeFlag |= n)
}
function Sf(...e) {
  const t = {}
  for (let n = 0; n < e.length; n++) {
    const r = e[n]
    for (const s in r)
      if (s === "class") t.class !== r.class && (t.class = es([t.class, r.class]))
      else if (s === "style") t.style = tt([t.style, r.style])
      else if (ts(s)) {
        const i = t[s],
          o = r[s]
        o && i !== o && !(J(i) && i.includes(o)) && (t[s] = i ? [].concat(i, o) : o)
      } else s !== "" && (t[s] = r[s])
  }
  return t
}
function ut(e, t, n, r = null) {
  it(e, t, 7, [n, r])
}
const Af = _l()
let Tf = 0
function Mf(e, t, n) {
  const r = e.type,
    s = (t ? t.appContext : e.appContext) || Af,
    i = {
      uid: Tf++,
      vnode: e,
      type: r,
      parent: t,
      appContext: s,
      root: null,
      next: null,
      subTree: null,
      effect: null,
      update: null,
      scope: new Qu(!0),
      render: null,
      proxy: null,
      exposed: null,
      exposeProxy: null,
      withProxy: null,
      provides: t ? t.provides : Object.create(s.provides),
      accessCache: null,
      renderCache: [],
      components: null,
      directives: null,
      propsOptions: vl(r, s),
      emitsOptions: al(r, s),
      emit: null,
      emitted: null,
      propsDefaults: me,
      inheritAttrs: r.inheritAttrs,
      ctx: me,
      data: me,
      props: me,
      attrs: me,
      slots: me,
      refs: me,
      setupState: me,
      setupContext: null,
      suspense: n,
      suspenseId: n ? n.pendingId : 0,
      asyncDep: null,
      asyncResolved: !1,
      isMounted: !1,
      isUnmounted: !1,
      isDeactivated: !1,
      bc: null,
      c: null,
      bm: null,
      m: null,
      bu: null,
      u: null,
      um: null,
      bum: null,
      da: null,
      a: null,
      rtg: null,
      rtc: null,
      ec: null,
      sp: null,
    }
  return (i.ctx = { _: i }), (i.root = t ? t.root : i), (i.emit = Fc.bind(null, i)), e.ce && e.ce(i), i
}
let Se = null
const Mi = () => Se || Qe,
  Sn = (e) => {
    ;(Se = e), e.scope.on()
  },
  rn = () => {
    Se && Se.scope.off(), (Se = null)
  }
function kl(e) {
  return e.vnode.shapeFlag & 4
}
let sr = !1
function jf(e, t = !1) {
  sr = t
  const { props: n, children: r } = e.vnode,
    s = kl(e)
  pf(e, n, s, t), gf(e, r)
  const i = s ? Rf(e, t) : void 0
  return (sr = !1), i
}
function Rf(e, t) {
  const n = e.type
  ;(e.accessCache = Object.create(null)), (e.proxy = bi(new Proxy(e.ctx, af)))
  const { setup: r } = n
  if (r) {
    const s = (e.setupContext = r.length > 1 ? Df(e) : null)
    Sn(e), Fn()
    const i = Ht(r, e, 0, [e.props, s])
    if ((Nn(), rn(), Fa(i))) {
      if ((i.then(rn, rn), t))
        return i
          .then((o) => {
            bo(e, o, t)
          })
          .catch((o) => {
            os(o, e, 0)
          })
      e.asyncDep = i
    } else bo(e, i, t)
  } else Cl(e, t)
}
function bo(e, t, n) {
  Z(t) ? (e.type.__ssrInlineRender ? (e.ssrRender = t) : (e.render = t)) : be(t) && (e.setupState = tl(t)), Cl(e, n)
}
let wo
function Cl(e, t, n) {
  const r = e.type
  if (!e.render) {
    if (!t && wo && !r.render) {
      const s = r.template || Pi(e).template
      if (s) {
        const { isCustomElement: i, compilerOptions: o } = e.appContext.config,
          { delimiters: a, compilerOptions: l } = r,
          d = Fe(Fe({ isCustomElement: i, delimiters: a }, o), l)
        r.render = wo(s, d)
      }
    }
    e.render = r.render || st
  }
  Sn(e), Fn(), lf(e), Nn(), rn()
}
function If(e) {
  return new Proxy(e.attrs, {
    get(t, n) {
      return Ke(e, "get", "$attrs"), t[n]
    },
  })
}
function Df(e) {
  const t = (r) => {
    e.exposed = r || {}
  }
  let n
  return {
    get attrs() {
      return n || (n = If(e))
    },
    slots: e.slots,
    emit: e.emit,
    expose: t,
  }
}
function ds(e) {
  if (e.exposed)
    return (
      e.exposeProxy ||
      (e.exposeProxy = new Proxy(tl(bi(e.exposed)), {
        get(t, n) {
          if (n in t) return t[n]
          if (n in Fr) return Fr[n](e)
        },
      }))
    )
}
function Ff(e, t = !0) {
  return Z(e) ? e.displayName || e.name : e.name || (t && e.__name)
}
function Nf(e) {
  return Z(e) && "__vccOpts" in e
}
const ke = (e, t) => Tc(e, t, sr)
function An(e, t, n) {
  const r = arguments.length
  return r === 2 ? (be(t) && !J(t) ? (Hs(t) ? Re(e, null, [t]) : Re(e, t)) : Re(e, null, t)) : (r > 3 ? (n = Array.prototype.slice.call(arguments, 2)) : r === 3 && Hs(n) && (n = [n]), Re(e, t, n))
}
const Lf = "3.2.40",
  Uf = "http://www.w3.org/2000/svg",
  Xt = typeof document < "u" ? document : null,
  _o = Xt && Xt.createElement("template"),
  Wf = {
    insert: (e, t, n) => {
      t.insertBefore(e, n || null)
    },
    remove: (e) => {
      const t = e.parentNode
      t && t.removeChild(e)
    },
    createElement: (e, t, n, r) => {
      const s = t ? Xt.createElementNS(Uf, e) : Xt.createElement(e, n ? { is: n } : void 0)
      return e === "select" && r && r.multiple != null && s.setAttribute("multiple", r.multiple), s
    },
    createText: (e) => Xt.createTextNode(e),
    createComment: (e) => Xt.createComment(e),
    setText: (e, t) => {
      e.nodeValue = t
    },
    setElementText: (e, t) => {
      e.textContent = t
    },
    parentNode: (e) => e.parentNode,
    nextSibling: (e) => e.nextSibling,
    querySelector: (e) => Xt.querySelector(e),
    setScopeId(e, t) {
      e.setAttribute(t, "")
    },
    insertStaticContent(e, t, n, r, s, i) {
      const o = n ? n.previousSibling : t.lastChild
      if (s && (s === i || s.nextSibling)) for (; t.insertBefore(s.cloneNode(!0), n), !(s === i || !(s = s.nextSibling)); );
      else {
        _o.innerHTML = r ? `<svg>${e}</svg>` : e
        const a = _o.content
        if (r) {
          const l = a.firstChild
          for (; l.firstChild; ) a.appendChild(l.firstChild)
          a.removeChild(l)
        }
        t.insertBefore(a, n)
      }
      return [o ? o.nextSibling : t.firstChild, n ? n.previousSibling : t.lastChild]
    },
  }
function Hf(e, t, n) {
  const r = e._vtc
  r && (t = (t ? [t, ...r] : [...r]).join(" ")), t == null ? e.removeAttribute("class") : n ? e.setAttribute("class", t) : (e.className = t)
}
function zf(e, t, n) {
  const r = e.style,
    s = Oe(n)
  if (n && !s) {
    for (const i in n) zs(r, i, n[i])
    if (t && !Oe(t)) for (const i in t) n[i] == null && zs(r, i, "")
  } else {
    const i = r.display
    s ? t !== n && (r.cssText = n) : t && e.removeAttribute("style"), "_vod" in e && (r.display = i)
  }
}
const $o = /\s*!important$/
function zs(e, t, n) {
  if (J(n)) n.forEach((r) => zs(e, t, r))
  else if ((n == null && (n = ""), t.startsWith("--"))) e.setProperty(t, n)
  else {
    const r = Bf(e, t)
    $o.test(n) ? e.setProperty(cn(r), n.replace($o, ""), "important") : (e[r] = n)
  }
}
const xo = ["Webkit", "Moz", "ms"],
  bs = {}
function Bf(e, t) {
  const n = bs[t]
  if (n) return n
  let r = yt(t)
  if (r !== "filter" && r in e) return (bs[t] = r)
  r = ss(r)
  for (let s = 0; s < xo.length; s++) {
    const i = xo[s] + r
    if (i in e) return (bs[t] = i)
  }
  return t
}
const ko = "http://www.w3.org/1999/xlink"
function Vf(e, t, n, r, s) {
  if (r && t.startsWith("xlink:")) n == null ? e.removeAttributeNS(ko, t.slice(6, t.length)) : e.setAttributeNS(ko, t, n)
  else {
    const i = Lu(t)
    n == null || (i && !Ra(n)) ? e.removeAttribute(t) : e.setAttribute(t, i ? "" : n)
  }
}
function qf(e, t, n, r, s, i, o) {
  if (t === "innerHTML" || t === "textContent") {
    r && o(r, s, i), (e[t] = n == null ? "" : n)
    return
  }
  if (t === "value" && e.tagName !== "PROGRESS" && !e.tagName.includes("-")) {
    e._value = n
    const l = n == null ? "" : n
    ;(e.value !== l || e.tagName === "OPTION") && (e.value = l), n == null && e.removeAttribute(t)
    return
  }
  let a = !1
  if (n === "" || n == null) {
    const l = typeof e[t]
    l === "boolean" ? (n = Ra(n)) : n == null && l === "string" ? ((n = ""), (a = !0)) : l === "number" && ((n = 0), (a = !0))
  }
  try {
    e[t] = n
  } catch {}
  a && e.removeAttribute(t)
}
const [Pl, Kf] = (() => {
  let e = Date.now,
    t = !1
  if (typeof window < "u") {
    Date.now() > document.createEvent("Event").timeStamp && (e = performance.now.bind(performance))
    const n = navigator.userAgent.match(/firefox\/(\d+)/i)
    t = !!(n && Number(n[1]) <= 53)
  }
  return [e, t]
})()
let Bs = 0
const Yf = Promise.resolve(),
  Gf = () => {
    Bs = 0
  },
  Qf = () => Bs || (Yf.then(Gf), (Bs = Pl()))
function bn(e, t, n, r) {
  e.addEventListener(t, n, r)
}
function Jf(e, t, n, r) {
  e.removeEventListener(t, n, r)
}
function Xf(e, t, n, r, s = null) {
  const i = e._vei || (e._vei = {}),
    o = i[t]
  if (r && o) o.value = r
  else {
    const [a, l] = Zf(t)
    if (r) {
      const d = (i[t] = ed(r, s))
      bn(e, a, d, l)
    } else o && (Jf(e, a, o, l), (i[t] = void 0))
  }
}
const Co = /(?:Once|Passive|Capture)$/
function Zf(e) {
  let t
  if (Co.test(e)) {
    t = {}
    let r
    for (; (r = e.match(Co)); ) (e = e.slice(0, e.length - r[0].length)), (t[r[0].toLowerCase()] = !0)
  }
  return [e[2] === ":" ? e.slice(3) : cn(e.slice(2)), t]
}
function ed(e, t) {
  const n = (r) => {
    const s = r.timeStamp || Pl()
    ;(Kf || s >= n.attached - 1) && it(td(r, n.value), t, 5, [r])
  }
  return (n.value = e), (n.attached = Qf()), n
}
function td(e, t) {
  if (J(t)) {
    const n = e.stopImmediatePropagation
    return (
      (e.stopImmediatePropagation = () => {
        n.call(e), (e._stopped = !0)
      }),
      t.map((r) => (s) => !s._stopped && r && r(s))
    )
  } else return t
}
const Po = /^on[a-z]/,
  nd = (e, t, n, r, s = !1, i, o, a, l) => {
    t === "class"
      ? Hf(e, r, s)
      : t === "style"
      ? zf(e, n, r)
      : ts(t)
      ? ui(t) || Xf(e, t, n, r, o)
      : (t[0] === "." ? ((t = t.slice(1)), !0) : t[0] === "^" ? ((t = t.slice(1)), !1) : rd(e, t, r, s))
      ? qf(e, t, r, i, o, a, l)
      : (t === "true-value" ? (e._trueValue = r) : t === "false-value" && (e._falseValue = r), Vf(e, t, r, s))
  }
function rd(e, t, n, r) {
  return r
    ? !!(t === "innerHTML" || t === "textContent" || (t in e && Po.test(t) && Z(n)))
    : t === "spellcheck" || t === "draggable" || t === "translate" || t === "form" || (t === "list" && e.tagName === "INPUT") || (t === "type" && e.tagName === "TEXTAREA") || (Po.test(t) && Oe(n))
    ? !1
    : t in e
}
const Oo = (e) => {
  const t = e.props["onUpdate:modelValue"] || !1
  return J(t) ? (n) => xr(t, n) : t
}
function sd(e) {
  e.target.composing = !0
}
function Eo(e) {
  const t = e.target
  t.composing && ((t.composing = !1), t.dispatchEvent(new Event("input")))
}
const Lt = {
    created(e, { modifiers: { lazy: t, trim: n, number: r } }, s) {
      e._assign = Oo(s)
      const i = r || (s.props && s.props.type === "number")
      bn(e, t ? "change" : "input", (o) => {
        if (o.target.composing) return
        let a = e.value
        n && (a = a.trim()), i && (a = As(a)), e._assign(a)
      }),
        n &&
          bn(e, "change", () => {
            e.value = e.value.trim()
          }),
        t || (bn(e, "compositionstart", sd), bn(e, "compositionend", Eo), bn(e, "change", Eo))
    },
    mounted(e, { value: t }) {
      e.value = t == null ? "" : t
    },
    beforeUpdate(e, { value: t, modifiers: { lazy: n, trim: r, number: s } }, i) {
      if (((e._assign = Oo(i)), e.composing || (document.activeElement === e && e.type !== "range" && (n || (r && e.value.trim() === t) || ((s || e.type === "number") && As(e.value) === t))))) return
      const o = t == null ? "" : t
      e.value !== o && (e.value = o)
    },
  },
  id = { esc: "escape", space: " ", up: "arrow-up", left: "arrow-left", right: "arrow-right", down: "arrow-down", delete: "backspace" },
  Ol = (e, t) => (n) => {
    if (!("key" in n)) return
    const r = cn(n.key)
    if (t.some((s) => s === r || id[s] === r)) return e(n)
  },
  od = Fe({ patchProp: nd }, Wf)
let So
function ad() {
  return So || (So = wf(od))
}
const ld = (...e) => {
  const t = ad().createApp(...e),
    { mount: n } = t
  return (
    (t.mount = (r) => {
      const s = ud(r)
      if (!s) return
      const i = t._component
      !Z(i) && !i.render && !i.template && (i.template = s.innerHTML), (s.innerHTML = "")
      const o = n(s, !1, s instanceof SVGElement)
      return s instanceof Element && (s.removeAttribute("v-cloak"), s.setAttribute("data-v-app", "")), o
    }),
    t
  )
}
function ud(e) {
  return Oe(e) ? document.querySelector(e) : e
}
/*!
 * vue-router v4.1.5
 * (c) 2022 Eduardo San Martin Morote
 * @license MIT
 */ const wn = typeof window < "u"
function cd(e) {
  return e.__esModule || e[Symbol.toStringTag] === "Module"
}
const pe = Object.assign
function ws(e, t) {
  const n = {}
  for (const r in t) {
    const s = t[r]
    n[r] = at(s) ? s.map(e) : e(s)
  }
  return n
}
const Qn = () => {},
  at = Array.isArray,
  fd = /\/$/,
  dd = (e) => e.replace(fd, "")
function _s(e, t, n = "/") {
  let r,
    s = {},
    i = "",
    o = ""
  const a = t.indexOf("#")
  let l = t.indexOf("?")
  return (
    a < l && a >= 0 && (l = -1),
    l > -1 && ((r = t.slice(0, l)), (i = t.slice(l + 1, a > -1 ? a : t.length)), (s = e(i))),
    a > -1 && ((r = r || t.slice(0, a)), (o = t.slice(a, t.length))),
    (r = gd(r != null ? r : t, n)),
    { fullPath: r + (i && "?") + i + o, path: r, query: s, hash: o }
  )
}
function pd(e, t) {
  const n = t.query ? e(t.query) : ""
  return t.path + (n && "?") + n + (t.hash || "")
}
function Ao(e, t) {
  return !t || !e.toLowerCase().startsWith(t.toLowerCase()) ? e : e.slice(t.length) || "/"
}
function hd(e, t, n) {
  const r = t.matched.length - 1,
    s = n.matched.length - 1
  return r > -1 && r === s && Tn(t.matched[r], n.matched[s]) && El(t.params, n.params) && e(t.query) === e(n.query) && t.hash === n.hash
}
function Tn(e, t) {
  return (e.aliasOf || e) === (t.aliasOf || t)
}
function El(e, t) {
  if (Object.keys(e).length !== Object.keys(t).length) return !1
  for (const n in e) if (!md(e[n], t[n])) return !1
  return !0
}
function md(e, t) {
  return at(e) ? To(e, t) : at(t) ? To(t, e) : e === t
}
function To(e, t) {
  return at(t) ? e.length === t.length && e.every((n, r) => n === t[r]) : e.length === 1 && e[0] === t
}
function gd(e, t) {
  if (e.startsWith("/")) return e
  if (!e) return t
  const n = t.split("/"),
    r = e.split("/")
  let s = n.length - 1,
    i,
    o
  for (i = 0; i < r.length; i++)
    if (((o = r[i]), o !== "."))
      if (o === "..") s > 1 && s--
      else break
  return n.slice(0, s).join("/") + "/" + r.slice(i - (i === r.length ? 1 : 0)).join("/")
}
var ir
;(function (e) {
  ;(e.pop = "pop"), (e.push = "push")
})(ir || (ir = {}))
var Jn
;(function (e) {
  ;(e.back = "back"), (e.forward = "forward"), (e.unknown = "")
})(Jn || (Jn = {}))
function vd(e) {
  if (!e)
    if (wn) {
      const t = document.querySelector("base")
      ;(e = (t && t.getAttribute("href")) || "/"), (e = e.replace(/^\w+:\/\/[^\/]+/, ""))
    } else e = "/"
  return e[0] !== "/" && e[0] !== "#" && (e = "/" + e), dd(e)
}
const yd = /^[^#]+#/
function bd(e, t) {
  return e.replace(yd, "#") + t
}
function wd(e, t) {
  const n = document.documentElement.getBoundingClientRect(),
    r = e.getBoundingClientRect()
  return { behavior: t.behavior, left: r.left - n.left - (t.left || 0), top: r.top - n.top - (t.top || 0) }
}
const ps = () => ({ left: window.pageXOffset, top: window.pageYOffset })
function _d(e) {
  let t
  if ("el" in e) {
    const n = e.el,
      r = typeof n == "string" && n.startsWith("#"),
      s = typeof n == "string" ? (r ? document.getElementById(n.slice(1)) : document.querySelector(n)) : n
    if (!s) return
    t = wd(s, e)
  } else t = e
  "scrollBehavior" in document.documentElement.style ? window.scrollTo(t) : window.scrollTo(t.left != null ? t.left : window.pageXOffset, t.top != null ? t.top : window.pageYOffset)
}
function Mo(e, t) {
  return (history.state ? history.state.position - t : -1) + e
}
const Vs = new Map()
function $d(e, t) {
  Vs.set(e, t)
}
function xd(e) {
  const t = Vs.get(e)
  return Vs.delete(e), t
}
let kd = () => location.protocol + "//" + location.host
function Sl(e, t) {
  const { pathname: n, search: r, hash: s } = t,
    i = e.indexOf("#")
  if (i > -1) {
    let a = s.includes(e.slice(i)) ? e.slice(i).length : 1,
      l = s.slice(a)
    return l[0] !== "/" && (l = "/" + l), Ao(l, "")
  }
  return Ao(n, e) + r + s
}
function Cd(e, t, n, r) {
  let s = [],
    i = [],
    o = null
  const a = ({ state: c }) => {
    const p = Sl(e, location),
      $ = n.value,
      b = t.value
    let w = 0
    if (c) {
      if (((n.value = p), (t.value = c), o && o === $)) {
        o = null
        return
      }
      w = b ? c.position - b.position : 0
    } else r(p)
    s.forEach((g) => {
      g(n.value, $, { delta: w, type: ir.pop, direction: w ? (w > 0 ? Jn.forward : Jn.back) : Jn.unknown })
    })
  }
  function l() {
    o = n.value
  }
  function d(c) {
    s.push(c)
    const p = () => {
      const $ = s.indexOf(c)
      $ > -1 && s.splice($, 1)
    }
    return i.push(p), p
  }
  function f() {
    const { history: c } = window
    !c.state || c.replaceState(pe({}, c.state, { scroll: ps() }), "")
  }
  function u() {
    for (const c of i) c()
    ;(i = []), window.removeEventListener("popstate", a), window.removeEventListener("beforeunload", f)
  }
  return window.addEventListener("popstate", a), window.addEventListener("beforeunload", f), { pauseListeners: l, listen: d, destroy: u }
}
function jo(e, t, n, r = !1, s = !1) {
  return { back: e, current: t, forward: n, replaced: r, position: window.history.length, scroll: s ? ps() : null }
}
function Pd(e) {
  const { history: t, location: n } = window,
    r = { value: Sl(e, n) },
    s = { value: t.state }
  s.value || i(r.value, { back: null, current: r.value, forward: null, position: t.length - 1, replaced: !0, scroll: null }, !0)
  function i(l, d, f) {
    const u = e.indexOf("#"),
      c = u > -1 ? (n.host && document.querySelector("base") ? e : e.slice(u)) + l : kd() + e + l
    try {
      t[f ? "replaceState" : "pushState"](d, "", c), (s.value = d)
    } catch (p) {
      console.error(p), n[f ? "replace" : "assign"](c)
    }
  }
  function o(l, d) {
    const f = pe({}, t.state, jo(s.value.back, l, s.value.forward, !0), d, { position: s.value.position })
    i(l, f, !0), (r.value = l)
  }
  function a(l, d) {
    const f = pe({}, s.value, t.state, { forward: l, scroll: ps() })
    i(f.current, f, !0)
    const u = pe({}, jo(r.value, l, null), { position: f.position + 1 }, d)
    i(l, u, !1), (r.value = l)
  }
  return { location: r, state: s, push: a, replace: o }
}
function Od(e) {
  e = vd(e)
  const t = Pd(e),
    n = Cd(e, t.state, t.location, t.replace)
  function r(i, o = !0) {
    o || n.pauseListeners(), history.go(i)
  }
  const s = pe({ location: "", base: e, go: r, createHref: bd.bind(null, e) }, t, n)
  return Object.defineProperty(s, "location", { enumerable: !0, get: () => t.location.value }), Object.defineProperty(s, "state", { enumerable: !0, get: () => t.state.value }), s
}
function Ed(e) {
  return (e = location.host ? e || location.pathname + location.search : ""), e.includes("#") || (e += "#"), Od(e)
}
function Sd(e) {
  return typeof e == "string" || (e && typeof e == "object")
}
function Al(e) {
  return typeof e == "string" || typeof e == "symbol"
}
const jt = { path: "/", name: void 0, params: {}, query: {}, hash: "", fullPath: "/", matched: [], meta: {}, redirectedFrom: void 0 },
  Tl = Symbol("")
var Ro
;(function (e) {
  ;(e[(e.aborted = 4)] = "aborted"), (e[(e.cancelled = 8)] = "cancelled"), (e[(e.duplicated = 16)] = "duplicated")
})(Ro || (Ro = {}))
function Mn(e, t) {
  return pe(new Error(), { type: e, [Tl]: !0 }, t)
}
function _t(e, t) {
  return e instanceof Error && Tl in e && (t == null || !!(e.type & t))
}
const Io = "[^/]+?",
  Ad = { sensitive: !1, strict: !1, start: !0, end: !0 },
  Td = /[.+*?^${}()[\]/\\]/g
function Md(e, t) {
  const n = pe({}, Ad, t),
    r = []
  let s = n.start ? "^" : ""
  const i = []
  for (const d of e) {
    const f = d.length ? [] : [90]
    n.strict && !d.length && (s += "/")
    for (let u = 0; u < d.length; u++) {
      const c = d[u]
      let p = 40 + (n.sensitive ? 0.25 : 0)
      if (c.type === 0) u || (s += "/"), (s += c.value.replace(Td, "\\$&")), (p += 40)
      else if (c.type === 1) {
        const { value: $, repeatable: b, optional: w, regexp: g } = c
        i.push({ name: $, repeatable: b, optional: w })
        const k = g || Io
        if (k !== Io) {
          p += 10
          try {
            new RegExp(`(${k})`)
          } catch (_) {
            throw new Error(`Invalid custom RegExp for param "${$}" (${k}): ` + _.message)
          }
        }
        let M = b ? `((?:${k})(?:/(?:${k}))*)` : `(${k})`
        u || (M = w && d.length < 2 ? `(?:/${M})` : "/" + M), w && (M += "?"), (s += M), (p += 20), w && (p += -8), b && (p += -20), k === ".*" && (p += -50)
      }
      f.push(p)
    }
    r.push(f)
  }
  if (n.strict && n.end) {
    const d = r.length - 1
    r[d][r[d].length - 1] += 0.7000000000000001
  }
  n.strict || (s += "/?"), n.end ? (s += "$") : n.strict && (s += "(?:/|$)")
  const o = new RegExp(s, n.sensitive ? "" : "i")
  function a(d) {
    const f = d.match(o),
      u = {}
    if (!f) return null
    for (let c = 1; c < f.length; c++) {
      const p = f[c] || "",
        $ = i[c - 1]
      u[$.name] = p && $.repeatable ? p.split("/") : p
    }
    return u
  }
  function l(d) {
    let f = "",
      u = !1
    for (const c of e) {
      ;(!u || !f.endsWith("/")) && (f += "/"), (u = !1)
      for (const p of c)
        if (p.type === 0) f += p.value
        else if (p.type === 1) {
          const { value: $, repeatable: b, optional: w } = p,
            g = $ in d ? d[$] : ""
          if (at(g) && !b) throw new Error(`Provided param "${$}" is an array but it is not repeatable (* or + modifiers)`)
          const k = at(g) ? g.join("/") : g
          if (!k)
            if (w) c.length < 2 && (f.endsWith("/") ? (f = f.slice(0, -1)) : (u = !0))
            else throw new Error(`Missing required param "${$}"`)
          f += k
        }
    }
    return f || "/"
  }
  return { re: o, score: r, keys: i, parse: a, stringify: l }
}
function jd(e, t) {
  let n = 0
  for (; n < e.length && n < t.length; ) {
    const r = t[n] - e[n]
    if (r) return r
    n++
  }
  return e.length < t.length ? (e.length === 1 && e[0] === 40 + 40 ? -1 : 1) : e.length > t.length ? (t.length === 1 && t[0] === 40 + 40 ? 1 : -1) : 0
}
function Rd(e, t) {
  let n = 0
  const r = e.score,
    s = t.score
  for (; n < r.length && n < s.length; ) {
    const i = jd(r[n], s[n])
    if (i) return i
    n++
  }
  if (Math.abs(s.length - r.length) === 1) {
    if (Do(r)) return 1
    if (Do(s)) return -1
  }
  return s.length - r.length
}
function Do(e) {
  const t = e[e.length - 1]
  return e.length > 0 && t[t.length - 1] < 0
}
const Id = { type: 0, value: "" },
  Dd = /[a-zA-Z0-9_]/
function Fd(e) {
  if (!e) return [[]]
  if (e === "/") return [[Id]]
  if (!e.startsWith("/")) throw new Error(`Invalid path "${e}"`)
  function t(p) {
    throw new Error(`ERR (${n})/"${d}": ${p}`)
  }
  let n = 0,
    r = n
  const s = []
  let i
  function o() {
    i && s.push(i), (i = [])
  }
  let a = 0,
    l,
    d = "",
    f = ""
  function u() {
    !d ||
      (n === 0
        ? i.push({ type: 0, value: d })
        : n === 1 || n === 2 || n === 3
        ? (i.length > 1 && (l === "*" || l === "+") && t(`A repeatable param (${d}) must be alone in its segment. eg: '/:ids+.`),
          i.push({ type: 1, value: d, regexp: f, repeatable: l === "*" || l === "+", optional: l === "*" || l === "?" }))
        : t("Invalid state to consume buffer"),
      (d = ""))
  }
  function c() {
    d += l
  }
  for (; a < e.length; ) {
    if (((l = e[a++]), l === "\\" && n !== 2)) {
      ;(r = n), (n = 4)
      continue
    }
    switch (n) {
      case 0:
        l === "/" ? (d && u(), o()) : l === ":" ? (u(), (n = 1)) : c()
        break
      case 4:
        c(), (n = r)
        break
      case 1:
        l === "(" ? (n = 2) : Dd.test(l) ? c() : (u(), (n = 0), l !== "*" && l !== "?" && l !== "+" && a--)
        break
      case 2:
        l === ")" ? (f[f.length - 1] == "\\" ? (f = f.slice(0, -1) + l) : (n = 3)) : (f += l)
        break
      case 3:
        u(), (n = 0), l !== "*" && l !== "?" && l !== "+" && a--, (f = "")
        break
      default:
        t("Unknown state")
        break
    }
  }
  return n === 2 && t(`Unfinished custom RegExp for param "${d}"`), u(), o(), s
}
function Nd(e, t, n) {
  const r = Md(Fd(e.path), n),
    s = pe(r, { record: e, parent: t, children: [], alias: [] })
  return t && !s.record.aliasOf == !t.record.aliasOf && t.children.push(s), s
}
function Ld(e, t) {
  const n = [],
    r = new Map()
  t = Lo({ strict: !1, end: !0, sensitive: !1 }, t)
  function s(f) {
    return r.get(f)
  }
  function i(f, u, c) {
    const p = !c,
      $ = Ud(f)
    $.aliasOf = c && c.record
    const b = Lo(t, f),
      w = [$]
    if ("alias" in f) {
      const M = typeof f.alias == "string" ? [f.alias] : f.alias
      for (const _ of M) w.push(pe({}, $, { components: c ? c.record.components : $.components, path: _, aliasOf: c ? c.record : $ }))
    }
    let g, k
    for (const M of w) {
      const { path: _ } = M
      if (u && _[0] !== "/") {
        const P = u.record.path,
          T = P[P.length - 1] === "/" ? "" : "/"
        M.path = u.record.path + (_ && T + _)
      }
      if (((g = Nd(M, u, b)), c ? c.alias.push(g) : ((k = k || g), k !== g && k.alias.push(g), p && f.name && !No(g) && o(f.name)), $.children)) {
        const P = $.children
        for (let T = 0; T < P.length; T++) i(P[T], g, c && c.children[T])
      }
      ;(c = c || g), l(g)
    }
    return k
      ? () => {
          o(k)
        }
      : Qn
  }
  function o(f) {
    if (Al(f)) {
      const u = r.get(f)
      u && (r.delete(f), n.splice(n.indexOf(u), 1), u.children.forEach(o), u.alias.forEach(o))
    } else {
      const u = n.indexOf(f)
      u > -1 && (n.splice(u, 1), f.record.name && r.delete(f.record.name), f.children.forEach(o), f.alias.forEach(o))
    }
  }
  function a() {
    return n
  }
  function l(f) {
    let u = 0
    for (; u < n.length && Rd(f, n[u]) >= 0 && (f.record.path !== n[u].record.path || !Ml(f, n[u])); ) u++
    n.splice(u, 0, f), f.record.name && !No(f) && r.set(f.record.name, f)
  }
  function d(f, u) {
    let c,
      p = {},
      $,
      b
    if ("name" in f && f.name) {
      if (((c = r.get(f.name)), !c)) throw Mn(1, { location: f })
      ;(b = c.record.name),
        (p = pe(
          Fo(
            u.params,
            c.keys.filter((k) => !k.optional).map((k) => k.name)
          ),
          f.params &&
            Fo(
              f.params,
              c.keys.map((k) => k.name)
            )
        )),
        ($ = c.stringify(p))
    } else if ("path" in f) ($ = f.path), (c = n.find((k) => k.re.test($))), c && ((p = c.parse($)), (b = c.record.name))
    else {
      if (((c = u.name ? r.get(u.name) : n.find((k) => k.re.test(u.path))), !c)) throw Mn(1, { location: f, currentLocation: u })
      ;(b = c.record.name), (p = pe({}, u.params, f.params)), ($ = c.stringify(p))
    }
    const w = []
    let g = c
    for (; g; ) w.unshift(g.record), (g = g.parent)
    return { name: b, path: $, params: p, matched: w, meta: Hd(w) }
  }
  return e.forEach((f) => i(f)), { addRoute: i, resolve: d, removeRoute: o, getRoutes: a, getRecordMatcher: s }
}
function Fo(e, t) {
  const n = {}
  for (const r of t) r in e && (n[r] = e[r])
  return n
}
function Ud(e) {
  return {
    path: e.path,
    redirect: e.redirect,
    name: e.name,
    meta: e.meta || {},
    aliasOf: void 0,
    beforeEnter: e.beforeEnter,
    props: Wd(e),
    children: e.children || [],
    instances: {},
    leaveGuards: new Set(),
    updateGuards: new Set(),
    enterCallbacks: {},
    components: "components" in e ? e.components || null : e.component && { default: e.component },
  }
}
function Wd(e) {
  const t = {},
    n = e.props || !1
  if ("component" in e) t.default = n
  else for (const r in e.components) t[r] = typeof n == "boolean" ? n : n[r]
  return t
}
function No(e) {
  for (; e; ) {
    if (e.record.aliasOf) return !0
    e = e.parent
  }
  return !1
}
function Hd(e) {
  return e.reduce((t, n) => pe(t, n.meta), {})
}
function Lo(e, t) {
  const n = {}
  for (const r in e) n[r] = r in t ? t[r] : e[r]
  return n
}
function Ml(e, t) {
  return t.children.some((n) => n === e || Ml(e, n))
}
const jl = /#/g,
  zd = /&/g,
  Bd = /\//g,
  Vd = /=/g,
  qd = /\?/g,
  Rl = /\+/g,
  Kd = /%5B/g,
  Yd = /%5D/g,
  Il = /%5E/g,
  Gd = /%60/g,
  Dl = /%7B/g,
  Qd = /%7C/g,
  Fl = /%7D/g,
  Jd = /%20/g
function ji(e) {
  return encodeURI("" + e)
    .replace(Qd, "|")
    .replace(Kd, "[")
    .replace(Yd, "]")
}
function Xd(e) {
  return ji(e).replace(Dl, "{").replace(Fl, "}").replace(Il, "^")
}
function qs(e) {
  return ji(e).replace(Rl, "%2B").replace(Jd, "+").replace(jl, "%23").replace(zd, "%26").replace(Gd, "`").replace(Dl, "{").replace(Fl, "}").replace(Il, "^")
}
function Zd(e) {
  return qs(e).replace(Vd, "%3D")
}
function ep(e) {
  return ji(e).replace(jl, "%23").replace(qd, "%3F")
}
function tp(e) {
  return e == null ? "" : ep(e).replace(Bd, "%2F")
}
function Lr(e) {
  try {
    return decodeURIComponent("" + e)
  } catch {}
  return "" + e
}
function np(e) {
  const t = {}
  if (e === "" || e === "?") return t
  const r = (e[0] === "?" ? e.slice(1) : e).split("&")
  for (let s = 0; s < r.length; ++s) {
    const i = r[s].replace(Rl, " "),
      o = i.indexOf("="),
      a = Lr(o < 0 ? i : i.slice(0, o)),
      l = o < 0 ? null : Lr(i.slice(o + 1))
    if (a in t) {
      let d = t[a]
      at(d) || (d = t[a] = [d]), d.push(l)
    } else t[a] = l
  }
  return t
}
function Uo(e) {
  let t = ""
  for (let n in e) {
    const r = e[n]
    if (((n = Zd(n)), r == null)) {
      r !== void 0 && (t += (t.length ? "&" : "") + n)
      continue
    }
    ;(at(r) ? r.map((i) => i && qs(i)) : [r && qs(r)]).forEach((i) => {
      i !== void 0 && ((t += (t.length ? "&" : "") + n), i != null && (t += "=" + i))
    })
  }
  return t
}
function rp(e) {
  const t = {}
  for (const n in e) {
    const r = e[n]
    r !== void 0 && (t[n] = at(r) ? r.map((s) => (s == null ? null : "" + s)) : r == null ? r : "" + r)
  }
  return t
}
const sp = Symbol(""),
  Wo = Symbol(""),
  Ri = Symbol(""),
  Nl = Symbol(""),
  Ks = Symbol("")
function Wn() {
  let e = []
  function t(r) {
    return (
      e.push(r),
      () => {
        const s = e.indexOf(r)
        s > -1 && e.splice(s, 1)
      }
    )
  }
  function n() {
    e = []
  }
  return { add: t, list: () => e, reset: n }
}
function Dt(e, t, n, r, s) {
  const i = r && (r.enterCallbacks[s] = r.enterCallbacks[s] || [])
  return () =>
    new Promise((o, a) => {
      const l = (u) => {
          u === !1 ? a(Mn(4, { from: n, to: t })) : u instanceof Error ? a(u) : Sd(u) ? a(Mn(2, { from: t, to: u })) : (i && r.enterCallbacks[s] === i && typeof u == "function" && i.push(u), o())
        },
        d = e.call(r && r.instances[s], t, n, l)
      let f = Promise.resolve(d)
      e.length < 3 && (f = f.then(l)), f.catch((u) => a(u))
    })
}
function $s(e, t, n, r) {
  const s = []
  for (const i of e)
    for (const o in i.components) {
      let a = i.components[o]
      if (!(t !== "beforeRouteEnter" && !i.instances[o]))
        if (ip(a)) {
          const d = (a.__vccOpts || a)[t]
          d && s.push(Dt(d, n, r, i, o))
        } else {
          let l = a()
          s.push(() =>
            l.then((d) => {
              if (!d) return Promise.reject(new Error(`Couldn't resolve component "${o}" at "${i.path}"`))
              const f = cd(d) ? d.default : d
              i.components[o] = f
              const c = (f.__vccOpts || f)[t]
              return c && Dt(c, n, r, i, o)()
            })
          )
        }
    }
  return s
}
function ip(e) {
  return typeof e == "object" || "displayName" in e || "props" in e || "__vccOpts" in e
}
function Ho(e) {
  const t = Je(Ri),
    n = Je(Nl),
    r = ke(() => t.resolve(gt(e.to))),
    s = ke(() => {
      const { matched: l } = r.value,
        { length: d } = l,
        f = l[d - 1],
        u = n.matched
      if (!f || !u.length) return -1
      const c = u.findIndex(Tn.bind(null, f))
      if (c > -1) return c
      const p = zo(l[d - 2])
      return d > 1 && zo(f) === p && u[u.length - 1].path !== p ? u.findIndex(Tn.bind(null, l[d - 2])) : c
    }),
    i = ke(() => s.value > -1 && up(n.params, r.value.params)),
    o = ke(() => s.value > -1 && s.value === n.matched.length - 1 && El(n.params, r.value.params))
  function a(l = {}) {
    return lp(l) ? t[gt(e.replace) ? "replace" : "push"](gt(e.to)).catch(Qn) : Promise.resolve()
  }
  return { route: r, href: ke(() => r.value.href), isActive: i, isExactActive: o, navigate: a }
}
const op = ur({
    name: "RouterLink",
    compatConfig: { MODE: 3 },
    props: { to: { type: [String, Object], required: !0 }, replace: Boolean, activeClass: String, exactActiveClass: String, custom: Boolean, ariaCurrentValue: { type: String, default: "page" } },
    useLink: Ho,
    setup(e, { slots: t }) {
      const n = pt(Ho(e)),
        { options: r } = Je(Ri),
        s = ke(() => ({ [Bo(e.activeClass, r.linkActiveClass, "router-link-active")]: n.isActive, [Bo(e.exactActiveClass, r.linkExactActiveClass, "router-link-exact-active")]: n.isExactActive }))
      return () => {
        const i = t.default && t.default(n)
        return e.custom ? i : An("a", { "aria-current": n.isExactActive ? e.ariaCurrentValue : null, href: n.href, onClick: n.navigate, class: s.value }, i)
      }
    },
  }),
  ap = op
function lp(e) {
  if (!(e.metaKey || e.altKey || e.ctrlKey || e.shiftKey) && !e.defaultPrevented && !(e.button !== void 0 && e.button !== 0)) {
    if (e.currentTarget && e.currentTarget.getAttribute) {
      const t = e.currentTarget.getAttribute("target")
      if (/\b_blank\b/i.test(t)) return
    }
    return e.preventDefault && e.preventDefault(), !0
  }
}
function up(e, t) {
  for (const n in t) {
    const r = t[n],
      s = e[n]
    if (typeof r == "string") {
      if (r !== s) return !1
    } else if (!at(s) || s.length !== r.length || r.some((i, o) => i !== s[o])) return !1
  }
  return !0
}
function zo(e) {
  return e ? (e.aliasOf ? e.aliasOf.path : e.path) : ""
}
const Bo = (e, t, n) => (e != null ? e : t != null ? t : n),
  cp = ur({
    name: "RouterView",
    inheritAttrs: !1,
    props: { name: { type: String, default: "default" }, route: Object },
    compatConfig: { MODE: 3 },
    setup(e, { attrs: t, slots: n }) {
      const r = Je(Ks),
        s = ke(() => e.route || r.value),
        i = Je(Wo, 0),
        o = ke(() => {
          let d = gt(i)
          const { matched: f } = s.value
          let u
          for (; (u = f[d]) && !u.components; ) d++
          return d
        }),
        a = ke(() => s.value.matched[o.value])
      Kn(
        Wo,
        ke(() => o.value + 1)
      ),
        Kn(sp, a),
        Kn(Ks, s)
      const l = ne()
      return (
        Ve(
          () => [l.value, a.value, e.name],
          ([d, f, u], [c, p, $]) => {
            f && ((f.instances[u] = d), p && p !== f && d && d === c && (f.leaveGuards.size || (f.leaveGuards = p.leaveGuards), f.updateGuards.size || (f.updateGuards = p.updateGuards))),
              d && f && (!p || !Tn(f, p) || !c) && (f.enterCallbacks[u] || []).forEach((b) => b(d))
          },
          { flush: "post" }
        ),
        () => {
          const d = s.value,
            f = e.name,
            u = a.value,
            c = u && u.components[f]
          if (!c) return Vo(n.default, { Component: c, route: d })
          const p = u.props[f],
            $ = p ? (p === !0 ? d.params : typeof p == "function" ? p(d) : p) : null,
            w = An(
              c,
              pe({}, $, t, {
                onVnodeUnmounted: (g) => {
                  g.component.isUnmounted && (u.instances[f] = null)
                },
                ref: l,
              })
            )
          return Vo(n.default, { Component: w, route: d }) || w
        }
      )
    },
  })
function Vo(e, t) {
  if (!e) return null
  const n = e(t)
  return n.length === 1 ? n[0] : n
}
const Ll = cp
function fp(e) {
  const t = Ld(e.routes, e),
    n = e.parseQuery || np,
    r = e.stringifyQuery || Uo,
    s = e.history,
    i = Wn(),
    o = Wn(),
    a = Wn(),
    l = Za(jt)
  let d = jt
  wn && e.scrollBehavior && "scrollRestoration" in history && (history.scrollRestoration = "manual")
  const f = ws.bind(null, (O) => "" + O),
    u = ws.bind(null, tp),
    c = ws.bind(null, Lr)
  function p(O, L) {
    let F, H
    return Al(O) ? ((F = t.getRecordMatcher(O)), (H = L)) : (H = O), t.addRoute(H, F)
  }
  function $(O) {
    const L = t.getRecordMatcher(O)
    L && t.removeRoute(L)
  }
  function b() {
    return t.getRoutes().map((O) => O.record)
  }
  function w(O) {
    return !!t.getRecordMatcher(O)
  }
  function g(O, L) {
    if (((L = pe({}, L || l.value)), typeof O == "string")) {
      const h = _s(n, O, L.path),
        m = t.resolve({ path: h.path }, L),
        x = s.createHref(h.fullPath)
      return pe(h, m, { params: c(m.params), hash: Lr(h.hash), redirectedFrom: void 0, href: x })
    }
    let F
    if ("path" in O) F = pe({}, O, { path: _s(n, O.path, L.path).path })
    else {
      const h = pe({}, O.params)
      for (const m in h) h[m] == null && delete h[m]
      ;(F = pe({}, O, { params: u(O.params) })), (L.params = u(L.params))
    }
    const H = t.resolve(F, L),
      oe = O.hash || ""
    H.params = f(c(H.params))
    const we = pd(r, pe({}, O, { hash: Xd(oe), path: H.path })),
      te = s.createHref(we)
    return pe({ fullPath: we, hash: oe, query: r === Uo ? rp(O.query) : O.query || {} }, H, { redirectedFrom: void 0, href: te })
  }
  function k(O) {
    return typeof O == "string" ? _s(n, O, l.value.path) : pe({}, O)
  }
  function M(O, L) {
    if (d !== O) return Mn(8, { from: L, to: O })
  }
  function _(O) {
    return v(O)
  }
  function P(O) {
    return _(pe(k(O), { replace: !0 }))
  }
  function T(O) {
    const L = O.matched[O.matched.length - 1]
    if (L && L.redirect) {
      const { redirect: F } = L
      let H = typeof F == "function" ? F(O) : F
      return (
        typeof H == "string" && ((H = H.includes("?") || H.includes("#") ? (H = k(H)) : { path: H }), (H.params = {})), pe({ query: O.query, hash: O.hash, params: "path" in H ? {} : O.params }, H)
      )
    }
  }
  function v(O, L) {
    const F = (d = g(O)),
      H = l.value,
      oe = O.state,
      we = O.force,
      te = O.replace === !0,
      h = T(F)
    if (h) return v(pe(k(h), { state: typeof h == "object" ? pe({}, oe, h.state) : oe, force: we, replace: te }), L || F)
    const m = F
    m.redirectedFrom = L
    let x
    return (
      !we && hd(r, H, F) && ((x = Mn(16, { to: m, from: H })), Ye(H, H, !0, !1)),
      (x ? Promise.resolve(x) : D(m, H))
        .catch((C) => (_t(C) ? (_t(C, 2) ? C : Te(C)) : X(C, m, H)))
        .then((C) => {
          if (C) {
            if (_t(C, 2)) return v(pe({ replace: te }, k(C.to), { state: typeof C.to == "object" ? pe({}, oe, C.to.state) : oe, force: we }), L || m)
          } else C = K(m, H, !0, te, oe)
          return Y(m, H, C), C
        })
    )
  }
  function A(O, L) {
    const F = M(O, L)
    return F ? Promise.reject(F) : Promise.resolve()
  }
  function D(O, L) {
    let F
    const [H, oe, we] = dp(O, L)
    F = $s(H.reverse(), "beforeRouteLeave", O, L)
    for (const h of H)
      h.leaveGuards.forEach((m) => {
        F.push(Dt(m, O, L))
      })
    const te = A.bind(null, O, L)
    return (
      F.push(te),
      mn(F)
        .then(() => {
          F = []
          for (const h of i.list()) F.push(Dt(h, O, L))
          return F.push(te), mn(F)
        })
        .then(() => {
          F = $s(oe, "beforeRouteUpdate", O, L)
          for (const h of oe)
            h.updateGuards.forEach((m) => {
              F.push(Dt(m, O, L))
            })
          return F.push(te), mn(F)
        })
        .then(() => {
          F = []
          for (const h of O.matched)
            if (h.beforeEnter && !L.matched.includes(h))
              if (at(h.beforeEnter)) for (const m of h.beforeEnter) F.push(Dt(m, O, L))
              else F.push(Dt(h.beforeEnter, O, L))
          return F.push(te), mn(F)
        })
        .then(() => (O.matched.forEach((h) => (h.enterCallbacks = {})), (F = $s(we, "beforeRouteEnter", O, L)), F.push(te), mn(F)))
        .then(() => {
          F = []
          for (const h of o.list()) F.push(Dt(h, O, L))
          return F.push(te), mn(F)
        })
        .catch((h) => (_t(h, 8) ? h : Promise.reject(h)))
    )
  }
  function Y(O, L, F) {
    for (const H of a.list()) H(O, L, F)
  }
  function K(O, L, F, H, oe) {
    const we = M(O, L)
    if (we) return we
    const te = L === jt,
      h = wn ? history.state : {}
    F && (H || te ? s.replace(O.fullPath, pe({ scroll: te && h && h.scroll }, oe)) : s.push(O.fullPath, oe)), (l.value = O), Ye(O, L, F, te), Te()
  }
  let G
  function ue() {
    G ||
      (G = s.listen((O, L, F) => {
        if (!pr.listening) return
        const H = g(O),
          oe = T(H)
        if (oe) {
          v(pe(oe, { replace: !0 }), H).catch(Qn)
          return
        }
        d = H
        const we = l.value
        wn && $d(Mo(we.fullPath, F.delta), ps()),
          D(H, we)
            .catch((te) =>
              _t(te, 12)
                ? te
                : _t(te, 2)
                ? (v(te.to, H)
                    .then((h) => {
                      _t(h, 20) && !F.delta && F.type === ir.pop && s.go(-1, !1)
                    })
                    .catch(Qn),
                  Promise.reject())
                : (F.delta && s.go(-F.delta, !1), X(te, H, we))
            )
            .then((te) => {
              ;(te = te || K(H, we, !1)), te && (F.delta && !_t(te, 8) ? s.go(-F.delta, !1) : F.type === ir.pop && _t(te, 20) && s.go(-1, !1)), Y(H, we, te)
            })
            .catch(Qn)
      }))
  }
  let xe = Wn(),
    ae = Wn(),
    z
  function X(O, L, F) {
    Te(O)
    const H = ae.list()
    return H.length ? H.forEach((oe) => oe(O, L, F)) : console.error(O), Promise.reject(O)
  }
  function ce() {
    return z && l.value !== jt
      ? Promise.resolve()
      : new Promise((O, L) => {
          xe.add([O, L])
        })
  }
  function Te(O) {
    return z || ((z = !O), ue(), xe.list().forEach(([L, F]) => (O ? F(O) : L())), xe.reset()), O
  }
  function Ye(O, L, F, H) {
    const { scrollBehavior: oe } = e
    if (!wn || !oe) return Promise.resolve()
    const we = (!F && xd(Mo(O.fullPath, 0))) || ((H || !F) && history.state && history.state.scroll) || null
    return as()
      .then(() => oe(O, L, we))
      .then((te) => te && _d(te))
      .catch((te) => X(te, O, L))
  }
  const Me = (O) => s.go(O)
  let Le
  const pn = new Set(),
    pr = {
      currentRoute: l,
      listening: !0,
      addRoute: p,
      removeRoute: $,
      hasRoute: w,
      getRoutes: b,
      resolve: g,
      options: e,
      push: _,
      replace: P,
      go: Me,
      back: () => Me(-1),
      forward: () => Me(1),
      beforeEach: i.add,
      beforeResolve: o.add,
      afterEach: a.add,
      onError: ae.add,
      isReady: ce,
      install(O) {
        const L = this
        O.component("RouterLink", ap),
          O.component("RouterView", Ll),
          (O.config.globalProperties.$router = L),
          Object.defineProperty(O.config.globalProperties, "$route", { enumerable: !0, get: () => gt(l) }),
          wn && !Le && l.value === jt && ((Le = !0), _(s.location).catch((oe) => {}))
        const F = {}
        for (const oe in jt) F[oe] = ke(() => l.value[oe])
        O.provide(Ri, L), O.provide(Nl, pt(F)), O.provide(Ks, l)
        const H = O.unmount
        pn.add(O),
          (O.unmount = function () {
            pn.delete(O), pn.size < 1 && ((d = jt), G && G(), (G = null), (l.value = jt), (Le = !1), (z = !1)), H()
          })
      },
    }
  return pr
}
function mn(e) {
  return e.reduce((t, n) => t.then(() => n()), Promise.resolve())
}
function dp(e, t) {
  const n = [],
    r = [],
    s = [],
    i = Math.max(t.matched.length, e.matched.length)
  for (let o = 0; o < i; o++) {
    const a = t.matched[o]
    a && (e.matched.find((d) => Tn(d, a)) ? r.push(a) : n.push(a))
    const l = e.matched[o]
    l && (t.matched.find((d) => Tn(d, l)) || s.push(l))
  }
  return [n, r, s]
}
const pp = {
    __name: "App",
    setup(e) {
      return (
        localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)
          ? document.documentElement.classList.add("dark")
          : document.documentElement.classList.remove("dark"),
        (t, n) => (U(), Ge(gt(Ll)))
      )
    },
  },
  Ul = ["__key", "__init", "__shim", "__original", "__index", "__prevKey"]
function hs() {
  return Math.random().toString(36).substring(2, 15)
}
function hp(e, t) {
  const n = e instanceof Set ? e : new Set(e)
  return t && t.forEach((r) => n.add(r)), [...n]
}
function ee(e, t) {
  return Object.prototype.hasOwnProperty.call(e, t)
}
function vt(e, t, n = !0, r = ["__key"]) {
  if (e === t) return !0
  if (typeof t == "object" && typeof e == "object") {
    if (e instanceof Map || e instanceof Set || e instanceof Date || e === null || t === null || Object.keys(e).length !== Object.keys(t).length) return !1
    for (const s of r) if ((s in e || s in t) && e[s] !== t[s]) return !1
    for (const s in e) if (!(s in t) || (e[s] !== t[s] && !n) || (n && !vt(e[s], t[s], n, r))) return !1
    return !0
  }
  return !1
}
function or(e) {
  const t = typeof e
  if (t === "number") return !1
  if (e === void 0) return !0
  if (t === "string") return e === ""
  if (t === "object") {
    if (e === null) return !0
    for (const n in e) return !1
    return !(e instanceof RegExp || e instanceof Date)
  }
  return !1
}
function mp(e) {
  return e.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")
}
function gp(e) {
  const t = `^${mp(e)}$`,
    n = { MM: "(0[1-9]|1[012])", M: "([1-9]|1[012])", DD: "([012][0-9]|3[01])", D: "([012]?[0-9]|3[01])", YYYY: "\\d{4}", YY: "\\d{2}" },
    r = Object.keys(n)
  return new RegExp(r.reduce((s, i) => s.replace(i, n[i]), t))
}
function Ys(e) {
  return Object.prototype.toString.call(e) === "[object Object]"
}
function Gs(e) {
  return Ys(e) || Array.isArray(e)
}
function on(e) {
  if (Ys(e) === !1 || e.__FKNode__ || e.__POJO__ === !1) return !1
  const t = e.constructor
  if (t === void 0) return !0
  const n = t.prototype
  return !(Ys(n) === !1 || n.hasOwnProperty("isPrototypeOf") === !1)
}
function an(e, t, n = !1, r = !1) {
  if (t === null) return null
  const s = {}
  if (typeof t == "string") return t
  for (const i in e)
    if (ee(t, i) && (t[i] !== void 0 || !r)) {
      if (n && Array.isArray(e[i]) && Array.isArray(t[i])) {
        s[i] = e[i].concat(t[i])
        continue
      }
      if (t[i] === void 0) continue
      on(e[i]) && on(t[i]) ? (s[i] = an(e[i], t[i], n, r)) : (s[i] = t[i])
    } else s[i] = e[i]
  for (const i in t) !ee(s, i) && t[i] !== void 0 && (s[i] = t[i])
  return s
}
function vp(e) {
  if ((e[0] !== '"' && e[0] !== "'") || e[0] !== e[e.length - 1]) return !1
  const t = e[0]
  for (let n = 1; n < e.length; n++) if (e[n] === t && (n === 1 || e[n - 1] !== "\\") && n !== e.length - 1) return !1
  return !0
}
function yp(e) {
  if (!e.length) return ""
  let t = "",
    n = ""
  for (let r = 0; r < e.length; r++) {
    const s = e.charAt(r)
    ;(s !== "\\" || n === "\\") && (t += s), (n = s)
  }
  return t
}
function gn(...e) {
  return e.reduce((t, n) => {
    const { value: r, name: s, modelValue: i, config: o, plugins: a, ...l } = n
    return Object.assign(t, l)
  }, {})
}
function bp(e) {
  const t = []
  let n = "",
    r = 0,
    s = "",
    i = ""
  for (let o = 0; o < e.length; o++) {
    const a = e.charAt(o)
    a === s && i !== "\\" ? (s = "") : (a === "'" || a === '"') && !s && i !== "\\" ? (s = a) : a === "(" && !s ? r++ : a === ")" && !s && r--,
      a === "," && !s && r === 0 ? (t.push(n), (n = "")) : (a !== " " || s) && (n += a),
      (i = a)
  }
  return n && t.push(n), t
}
function qo(e, t) {
  const n = {},
    r = t.filter((i) => i instanceof RegExp),
    s = new Set(t)
  for (const i in e) !s.has(i) && !r.some((o) => o.test(i)) && (n[i] = e[i])
  return n
}
function Ko(e, t) {
  const n = {},
    r = t.filter((s) => s instanceof RegExp)
  return (
    t.forEach((s) => {
      s instanceof RegExp || (n[s] = e[s])
    }),
    Object.keys(e).forEach((s) => {
      r.some((i) => i.test(s)) && (n[s] = e[s])
    }),
    n
  )
}
function Cn(e) {
  return e.replace(/-([a-z0-9])/gi, (t, n) => n.toUpperCase())
}
function Ii(e) {
  return e
    .replace(/([a-z0-9])([A-Z])/g, (t, n, r) => n + "-" + r.toLowerCase())
    .replace(" ", "-")
    .toLowerCase()
}
function Yo(e, t = Ul) {
  if (e !== null && typeof e == "object") {
    let n
    if ((Array.isArray(e) ? (n = [...e]) : on(e) && (n = { ...e }), n)) return _p(e, n, t), n
  }
  return e
}
function jn(e, t = Ul) {
  if (e === null || e instanceof RegExp || e instanceof Date || e instanceof Map || e instanceof Set || (typeof File == "function" && e instanceof File)) return e
  let n
  Array.isArray(e) ? (n = e.map((r) => (typeof r == "object" ? jn(r, t) : r))) : (n = Object.keys(e).reduce((r, s) => ((r[s] = typeof e[s] == "object" ? jn(e[s], t) : e[s]), r), {}))
  for (const r of t) r in e && Object.defineProperty(n, r, { enumerable: !1, value: e[r] })
  return n
}
function Ct(e) {
  return typeof e == "object" ? jn(e) : e
}
function wp(e, t) {
  if (!e || typeof e != "object") return null
  const n = t.split(".")
  let r = e
  for (const s in n) {
    const i = n[s]
    if ((ee(r, i) && (r = r[i]), +s === n.length - 1)) return r
    if (!r || typeof r != "object") return null
  }
  return null
}
function kt(e) {
  return e !== void 0 && e !== "false" && e !== !1 ? !0 : void 0
}
function ar(e) {
  return Object.isFrozen(e) ? e : Object.defineProperty(e, "__init", { enumerable: !1, value: !0 })
}
function Wl(e) {
  return e
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .toLowerCase()
    .replace(/[^a-z0-9]/g, " ")
    .trim()
    .replace(/\s+/g, "-")
}
function _p(e, t, n) {
  for (const r of n) r in e && Object.defineProperty(t, r, { enumerable: !1, value: e[r] })
  return t
}
function Di() {
  const e = []
  let t = 0
  const n = (s) => e.push(s),
    r = (s) => {
      const i = e[t]
      return typeof i == "function" ? i(s, (o) => (t++, r(o === void 0 ? s : o))) : ((t = 0), s)
    }
  return (
    (n.dispatch = r),
    (n.unshift = (s) => e.unshift(s)),
    (n.remove = (s) => {
      const i = e.indexOf(s)
      i > -1 && e.splice(i, 1)
    }),
    n
  )
}
function Hl() {
  const e = new Map(),
    t = new Map()
  let n
  const r = (s, i) => {
    if (n) {
      n.set(i.name, [s, i])
      return
    }
    e.has(i.name) &&
      e.get(i.name).forEach((o) => {
        ;(i.origin === s || o.modifiers.includes("deep")) && o.listener(i)
      }),
      i.bubble && s.bubble(i)
  }
  return (
    (r.on = (s, i) => {
      const [o, ...a] = s.split("."),
        l = i.receipt || hs(),
        d = { modifiers: a, event: o, listener: i, receipt: l }
      return e.has(o) ? e.get(o).push(d) : e.set(o, [d]), t.has(l) ? t.get(l).push(o) : t.set(l, [o]), l
    }),
    (r.off = (s) => {
      var i
      t.has(s) &&
        ((i = t.get(s)) === null ||
          i === void 0 ||
          i.forEach((o) => {
            const a = e.get(o)
            Array.isArray(a) &&
              e.set(
                o,
                a.filter((l) => l.receipt !== s)
              )
          }),
        t.delete(s))
    }),
    (r.pause = (s) => {
      n || (n = new Map()), s && s.walk((i) => i._e.pause())
    }),
    (r.play = (s) => {
      if (!n) return
      const i = n
      ;(n = void 0), i.forEach(([o, a]) => r(o, a)), s && s.walk((o) => o._e.play())
    }),
    r
  )
}
function $p(e, t, n, r, s = !0) {
  return t._e(e, { payload: r, name: n, bubble: s, origin: e }), e
}
function xp(e, t, n) {
  return fr(e.parent) && e.parent._e(e.parent, n), e
}
function kp(e, t, n, r) {
  return t._e.on(n, r)
}
function Cp(e, t, n) {
  return t._e.off(n), e
}
const Fi = Di()
Fi((e, t) => (e.message || (e.message = String(`E${e.code}`)), t(e)))
const Ni = Di()
Ni((e, t) => {
  e.message || (e.message = String(`W${e.code}`))
  const n = t(e)
  return console && typeof console.warn == "function" && console.warn(n.message), n
})
function fn(e, t = {}) {
  Ni.dispatch({ code: e, data: t })
}
function qe(e, t = {}) {
  throw Error(Fi.dispatch({ code: e, data: t }).message)
}
function ot(e, t) {
  const n = { blocking: !1, key: hs(), meta: {}, type: "state", visible: !0, ...e }
  return t && n.value && n.meta.localize !== !1 && ((n.value = t.t(n)), (n.meta.locale = t.config.locale)), n
}
const Go = { apply: Tp, set: Op, remove: zl, filter: Sp, reduce: Ap, release: Rp, touch: Ep }
function Pp(e = !1) {
  const t = {}
  let n,
    r = e,
    s = []
  const i = new Map()
  let o
  const a = new Proxy(t, {
    get(...l) {
      const [d, f] = l
      return f === "buffer" ? r : f === "_b" ? s : f === "_m" ? i : f === "_r" ? o : ee(Go, f) ? Go[f].bind(null, t, a, n) : Reflect.get(...l)
    },
    set(l, d, f) {
      return d === "_n" ? ((n = f), o === "__n" && Bl(n, a), !0) : d === "_b" ? ((s = f), !0) : d === "buffer" ? ((r = f), !0) : d === "_r" ? ((o = f), !0) : (qe(101, n), !1)
    },
  })
  return a
}
function Op(e, t, n, r) {
  if (t.buffer) return t._b.push([[r]]), t
  if (e[r.key] !== r) {
    if (typeof r.value == "string" && r.meta.localize !== !1) {
      const i = r.value
      ;(r.value = n.t(r)), r.value !== i && (r.meta.locale = n.props.locale)
    }
    const s = `message-${ee(e, r.key) ? "updated" : "added"}`
    ;(e[r.key] = Object.freeze(n.hook.message.dispatch(r))), n.emit(s, r)
  }
  return t
}
function Ep(e, t) {
  for (const n in e) {
    const r = { ...e[n] }
    t.set(r)
  }
}
function zl(e, t, n, r) {
  if (ee(e, r)) {
    const s = e[r]
    delete e[r], n.emit("message-removed", s)
  }
  return t.buffer === !0 && (t._b = t._b.filter((s) => ((s[0] = s[0].filter((i) => i.key !== r)), s[1] || s[0].length))), t
}
function Sp(e, t, n, r, s) {
  for (const i in e) {
    const o = e[i]
    ;(!s || o.type === s) && !r(o) && zl(e, t, n, i)
  }
}
function Ap(e, t, n, r, s) {
  for (const i in e) {
    const o = e[i]
    s = r(s, o)
  }
  return s
}
function Tp(e, t, n, r, s) {
  if (Array.isArray(r)) {
    if (t.buffer) {
      t._b.push([r, s])
      return
    }
    const i = new Set(r.map((o) => (t.set(o), o.key)))
    typeof s == "string" ? t.filter((o) => o.type !== s || i.has(o.key)) : typeof s == "function" && t.filter((o) => !s(o) || i.has(o.key))
  } else
    for (const i in r) {
      const o = n.at(i)
      o ? o.store.apply(r[i], s) : jp(n, t, i, r[i], s)
    }
}
function Mp(e, ...t) {
  const n = `${e.name}-set`,
    r = (s) => ot({ key: Wl(s), type: "error", value: s, meta: { source: n, autoClear: !0 } })
  return t
    .filter((s) => !!s)
    .map((s) => {
      if ((typeof s == "string" && (s = [s]), Array.isArray(s))) return s.map((i) => r(i))
      {
        const i = {}
        for (const o in s) Array.isArray(s[o]) ? (i[o] = s[o].map((a) => r(a))) : (i[o] = [r(s[o])])
        return i
      }
    })
}
function jp(e, t, n, r, s) {
  var i
  const o = t._m
  o.has(n) || o.set(n, []), t._r || (t._r = Bl(e, t)), (i = o.get(n)) === null || i === void 0 || i.push([r, s])
}
function Bl(e, t) {
  return e.on("child.deep", ({ payload: n }) => {
    t._m.forEach((r, s) => {
      e.at(s) === n &&
        (r.forEach(([i, o]) => {
          n.store.apply(i, o)
        }),
        t._m.delete(s))
    }),
      t._m.size === 0 && t._r && (e.off(t._r), (t._r = void 0))
  })
}
function Rp(e, t) {
  ;(t.buffer = !1), t._b.forEach(([n, r]) => t.apply(n, r)), (t._b = [])
}
function Ip() {
  const e = {}
  let t
  return {
    count: (...n) => Dp(t, e, ...n),
    init(n) {
      ;(t = n), n.on("message-added.deep", Qo(e, 1)), n.on("message-removed.deep", Qo(e, -1))
    },
    merge: (n) => Jo(t, e, n),
    settled(n) {
      return ee(e, n) ? e[n].promise : Promise.resolve()
    },
    unmerge: (n) => Jo(t, e, n, !0),
    value(n) {
      return ee(e, n) ? e[n].count : 0
    },
  }
}
function Dp(e, t, n, r, s = 0) {
  if (((r = Fp(r || n)), !ee(t, n))) {
    const i = { condition: r, count: 0, name: n, node: e, promise: Promise.resolve(), resolve: () => {} }
    ;(t[n] = i),
      (s = e.store.reduce((o, a) => o + i.condition(a) * 1, s)),
      e.each((o) => {
        o.ledger.count(i.name, i.condition), (s += o.ledger.value(i.name))
      })
  }
  return Vl(t[n], s).promise
}
function Fp(e) {
  return typeof e == "function" ? e : (t) => t.type === e
}
function Vl(e, t) {
  const n = e.count,
    r = e.count + t
  return (
    (e.count = r),
    n === 0 && r !== 0
      ? (e.node.emit(`unsettled:${e.name}`, e.count, !1), (e.promise = new Promise((s) => (e.resolve = s))))
      : n !== 0 && r === 0 && (e.node.emit(`settled:${e.name}`, e.count, !1), e.resolve()),
    e.node.emit(`count:${e.name}`, e.count, !1),
    e
  )
}
function Qo(e, t) {
  return (n) => {
    for (const r in e) {
      const s = e[r]
      s.condition(n.payload) && Vl(s, t)
    }
  }
}
function Jo(e, t, n, r = !1) {
  for (const s in t) {
    const i = t[s].condition
    r || n.ledger.count(s, i)
    const o = n.ledger.value(s) * (r ? -1 : 1)
    if (!!e)
      do e.ledger.count(s, i, o), (e = e.parent)
      while (e)
  }
}
const Li = new Map(),
  Or = new Map(),
  Ui = Hl(),
  Np = []
function Lp(e) {
  e.props.id && (Li.set(e.props.id, e), Or.set(e, e.props.id), Ui(e, { payload: e, name: e.props.id, bubble: !1, origin: e }))
}
function Up(e) {
  if (Or.has(e)) {
    const t = Or.get(e)
    Or.delete(e), Li.delete(t), Ui(e, { payload: null, name: t, bubble: !1, origin: e })
  }
}
function cr(e) {
  return Li.get(e)
}
function Wp(e, t) {
  Np.push(Ui.on(e, t))
}
function Qs(e, t, n) {
  let r = !0
  return t in e.config._t ? (r = !1) : e.emit(`config:${t}`, n, !1), t in e.props || (e.emit("prop", { prop: t, value: n }), e.emit(`prop:${t}`, n)), r
}
function Hp(e = {}) {
  const t = new Set(),
    n = { ...e, _add: (s) => t.add(s), _rm: (s) => s.remove(s) }
  return new Proxy(n, {
    set(s, i, o, a) {
      return typeof i == "string" && t.forEach((l) => Qs(l, i, o)), Reflect.set(s, i, o, a)
    },
  })
}
function ql(e) {
  const t = document.getElementById(e)
  if (t instanceof HTMLFormElement) {
    const n = new Event("submit", { cancelable: !0, bubbles: !0 })
    t.dispatchEvent(n)
    return
  }
  fn(151, e)
}
function zp(e) {
  const t = (n) => {
    for (const r in n.store) {
      const s = n.store[r]
      s.type === "error" || (s.type === "ui" && r === "incomplete") ? n.store.remove(r) : s.type === "state" && n.store.set({ ...s, value: !1 })
    }
  }
  t(e), e.walk(t)
}
function Kl(e, t) {
  const n = typeof e == "string" ? cr(e) : e
  if (n) {
    const r = (i) => Ct(i.props.initial) || (i.type === "group" ? {} : i.type === "list" ? [] : void 0)
    n._e.pause(n), n.input(Ct(t) || r(n), !1), n.walk((i) => i.input(r(i), !1))
    const s = r(n)
    return n.input(typeof s == "object" ? Ct(t) || ar(s) : s, !1), n._e.play(n), zp(n), n.emit("reset", n), n
  }
  fn(152, e)
}
const Bp = { delimiter: ".", delay: 0, locale: "en", rootClasses: (e) => ({ [`formkit-${Ii(e)}`]: !0 }) },
  Yl = Symbol("index"),
  Js = Symbol("removed"),
  Xs = Symbol("moved"),
  Gl = Symbol("inserted")
function Vp(e) {
  return e.type === "list" && Array.isArray(e._value)
}
function fr(e) {
  return e && typeof e == "object" && e.__FKNode__ === !0
}
const Er = (e, t, n) => {
    qe(102, [e, n])
  },
  qp = {
    _c: le(ph, Er, !1),
    add: le(ih),
    addProps: le(sh),
    address: le(mh, Er, !1),
    at: le(gh),
    bubble: le(xp),
    clearErrors: le(kh),
    calm: le(th),
    config: le(!1),
    define: le(rh),
    disturb: le(eh),
    destroy: le(nh),
    hydrate: le(Zp),
    index: le(dh, fh, !1),
    input: le(Jl),
    each: le(lh),
    emit: le($p),
    find: le(yh),
    on: le(kp),
    off: le(Cp),
    parent: le(!1, oh),
    plugins: le(!1),
    remove: le(ah),
    root: le(wh, Er, !1),
    reset: le(xh),
    resetConfig: le(ch),
    setErrors: le(eu),
    submit: le($h),
    t: le(_h),
    use: le(Wi),
    name: le(hh, !1, !1),
    walk: le(uh),
  }
function Kp() {
  return new Map(Object.entries(qp))
}
function le(e, t, n = !0) {
  return { get: e ? (r, s) => (n ? (...i) => e(r, s, ...i) : e(r, s)) : !1, set: t !== void 0 ? t : Er.bind(null) }
}
function Yp() {
  const e = new Map()
  return new Proxy(e, {
    get(t, n) {
      return e.has(n) || e.set(n, Di()), e.get(n)
    },
  })
}
let Gp = 0,
  Qp = 0
function Jp(e) {
  var t, n
  return ((t = e.parent) === null || t === void 0 ? void 0 : t.type) === "list" ? Yl : e.name || `${((n = e.props) === null || n === void 0 ? void 0 : n.type) || "input"}_${++Gp}`
}
function Ql(e) {
  return e.type === "group" ? ar(e.value && typeof e.value == "object" && !Array.isArray(e.value) ? e.value : {}) : e.type === "list" ? ar(Array.isArray(e.value) ? e.value : []) : e.value
}
function Jl(e, t, n, r = !0) {
  return (
    (t._value = Xp(e, e.hook.input.dispatch(n))),
    e.emit("input", t._value),
    t.isSettled && e.disturb(),
    r ? (t._tmo && clearTimeout(t._tmo), (t._tmo = setTimeout(Ur, e.props.delay, e, t))) : Ur(e, t),
    t.settled
  )
}
function Xp(e, t) {
  switch (e.type) {
    case "input":
      break
    case "group":
      ;(!t || typeof t != "object") && qe(107, [e, t])
      break
    case "list":
      Array.isArray(t) || qe(108, [e, t])
      break
  }
  return t
}
function Ur(e, t, n = !0, r = !0) {
  ;(t._value = t.value = e.hook.commit.dispatch(t._value)), e.type !== "input" && r && e.hydrate(), e.emit("commit", t.value), n && e.calm()
}
function Xl(e, { name: t, value: n, from: r }) {
  if (!Object.isFrozen(e._value)) {
    if (Vp(e)) {
      const s = n === Js ? [] : n === Xs && typeof r == "number" ? e._value.splice(r, 1) : [n]
      e._value.splice(t, n === Xs || r === Gl ? 0 : 1, ...s)
      return
    }
    n !== Js ? (e._value[t] = n) : delete e._value[t]
  }
}
function Zp(e, t) {
  const n = t._value
  return (
    t.children.forEach((r) => {
      if (typeof n == "object")
        if (r.name in n) {
          const s = r.type !== "input" || (n[r.name] && typeof n[r.name] == "object") ? ar(n[r.name]) : n[r.name]
          r.input(s, !1)
        } else
          (e.type !== "list" || typeof r.name == "number") && Xl(t, { name: r.name, value: r.value }),
            n.__init || (r.type === "group" ? r.input({}, !1) : r.type === "list" ? r.input([], !1) : r.input(void 0, !1))
    }),
    e
  )
}
function eh(e, t) {
  var n
  return (
    t._d <= 0 &&
      ((t.isSettled = !1),
      e.emit("settled", !1, !1),
      (t.settled = new Promise((r) => {
        t._resolve = r
      })),
      e.parent && ((n = e.parent) === null || n === void 0 || n.disturb())),
    t._d++,
    e
  )
}
function th(e, t, n) {
  var r
  if (n !== void 0 && e.type !== "input") return Xl(t, n), Ur(e, t, !0, !1)
  t._d > 0 && t._d--,
    t._d === 0 && ((t.isSettled = !0), e.emit("settled", !0, !1), e.parent && ((r = e.parent) === null || r === void 0 || r.calm({ name: e.name, value: t.value })), t._resolve && t._resolve(t.value))
}
function nh(e, t) {
  e.emit("destroying", e), e.store.filter(() => !1), e.parent && e.parent.remove(e), Up(e), (t._value = t.value = void 0), e.emit("destroyed", e)
}
function rh(e, t, n) {
  ;(t.type = n.type),
    (t.props.definition = jn(n)),
    (t.value = t._value = Ql({ type: e.type, value: t.value })),
    n.forceTypeProp && (e.props.type && (e.props.originalType = e.props.type), (t.props.type = n.forceTypeProp)),
    n.family && (t.props.family = n.family),
    n.features && n.features.forEach((r) => r(e)),
    n.props && e.addProps(n.props),
    e.emit("defined", n)
}
function sh(e, t, n) {
  var r
  if (e.props.attrs) {
    const s = { ...e.props.attrs }
    e.props._emit = !1
    for (const o in s) {
      const a = Cn(o)
      n.includes(a) && ((e.props[a] = s[o]), delete s[o])
    }
    const i = Ct(t._value)
    ;(e.props.initial = e.type !== "input" ? ar(i) : i),
      (e.props._emit = !0),
      (e.props.attrs = s),
      e.props.definition && (e.props.definition.props = [...(((r = e.props.definition) === null || r === void 0 ? void 0 : r.props) || []), ...n])
  }
  return e.emit("added-props", n), e
}
function ih(e, t, n, r) {
  if (
    (e.type === "input" && qe(100, e),
    n.parent && n.parent !== e && n.parent.remove(n),
    t.children.includes(n) ||
      (r !== void 0 && e.type === "list"
        ? (t.children.splice(r, 0, n), Array.isArray(e.value) && e.value.length < t.children.length && e.disturb().calm({ name: r, value: n.value, from: Gl }))
        : t.children.push(n),
      n.isSettled || e.disturb()),
    n.parent !== e)
  ) {
    if (((n.parent = e), n.parent !== e)) return e.remove(n), n.parent.add(n), e
  } else n.use(e.plugins)
  return Ur(e, t, !1), e.ledger.merge(n), e.emit("child", n), e
}
function oh(e, t, n, r) {
  return fr(r)
    ? (e.parent && e.parent !== r && e.parent.remove(e), (t.parent = r), e.resetConfig(), r.children.includes(e) ? e.use(r.plugins) : r.add(e), !0)
    : r === null
    ? ((t.parent = null), !0)
    : !1
}
function ah(e, t, n) {
  const r = t.children.indexOf(n)
  if (r !== -1) {
    n.isSettled && e.disturb(), t.children.splice(r, 1)
    let s = kt(n.props.preserve),
      i = n.parent
    for (; s === void 0 && i; ) (s = kt(i.props.preserve)), (i = i.parent)
    s ? e.calm() : e.calm({ name: e.type === "list" ? r : n.name, value: Js }), (n.parent = null), (n.config._rmn = n)
  }
  return e.ledger.unmerge(n), e
}
function lh(e, t, n) {
  t.children.forEach((r) => n(r))
}
function uh(e, t, n, r = !1) {
  t.children.forEach((s) => {
    ;(n(s) !== !1 || !r) && s.walk(n)
  })
}
function ch(e, t) {
  const n = e.parent || void 0
  ;(t.config = Zl(e.config._t, n)), e.walk((r) => r.resetConfig())
}
function Wi(e, t, n, r = !0, s = !0) {
  return Array.isArray(n) || n instanceof Set
    ? (n.forEach((i) => Wi(e, t, i)), e)
    : (t.plugins.has(n) || (s && typeof n.library == "function" && n.library(e), r && n(e) !== !1 && (t.plugins.add(n), e.children.forEach((i) => i.use(n)))), e)
}
function fh(e, t, n, r) {
  if (fr(e.parent)) {
    const s = e.parent.children,
      i = r >= s.length ? s.length - 1 : r < 0 ? 0 : r,
      o = s.indexOf(e)
    return o === -1 ? !1 : (s.splice(o, 1), s.splice(i, 0, e), (e.parent.children = s), e.parent.type === "list" && e.parent.disturb().calm({ name: i, value: Xs, from: o }), !0)
  }
  return !1
}
function dh(e) {
  if (e.parent) {
    const t = [...e.parent.children].indexOf(e)
    return t === -1 ? e.parent.children.length : t
  }
  return -1
}
function ph(e, t) {
  return t
}
function hh(e, t) {
  var n
  return ((n = e.parent) === null || n === void 0 ? void 0 : n.type) === "list" ? e.index : t.name !== Yl ? t.name : e.index
}
function mh(e, t) {
  return t.parent ? t.parent.address.concat([e.name]) : [e.name]
}
function gh(e, t, n) {
  const r = typeof n == "string" ? n.split(e.config.delimiter) : n
  if (!r.length) return
  const s = r[0]
  let i = e.parent
  for (i || (String(r[0]) === String(e.name) && r.shift(), (i = e)), s === "$parent" && r.shift(); i && r.length; ) {
    const o = r.shift()
    switch (o) {
      case "$root":
        i = e.root
        break
      case "$parent":
        i = i.parent
        break
      case "$self":
        i = e
        break
      default:
        i = i.children.find((a) => String(a.name) === String(o)) || vh(i, o)
    }
  }
  return i || void 0
}
function vh(e, t) {
  const n = String(t).match(/^(find)\((.*)\)$/)
  if (n) {
    const [, r, s] = n,
      i = s.split(",").map((o) => o.trim())
    switch (r) {
      case "find":
        return e.find(i[0], i[1])
      default:
        return
    }
  }
}
function yh(e, t, n, r) {
  return bh(e, n, r)
}
function bh(e, t, n = "name") {
  const r = typeof n == "string" ? (i) => i[n] == t : n,
    s = [e]
  for (; s.length; ) {
    const i = s.shift()
    if (r(i, t)) return i
    s.push(...i.children)
  }
}
function wh(e) {
  let t = e
  for (; t.parent; ) t = t.parent
  return t
}
function Zl(e = {}, t) {
  let n
  return new Proxy(e, {
    get(...r) {
      const s = r[1]
      if (s === "_t") return e
      const i = Reflect.get(...r)
      if (i !== void 0) return i
      if (t) {
        const o = t.config[s]
        if (o !== void 0) return o
      }
      if (e.rootConfig && typeof s == "string") {
        const o = e.rootConfig[s]
        if (o !== void 0) return o
      }
      return s === "delay" && (n == null ? void 0 : n.type) === "input" ? 20 : Bp[s]
    },
    set(...r) {
      const s = r[1],
        i = r[2]
      if (s === "_n") return (n = i), e.rootConfig && e.rootConfig._add(n), !0
      if (s === "_rmn") return e.rootConfig && e.rootConfig._rm(n), (n = void 0), !0
      if (!vt(e[s], i, !1)) {
        const o = Reflect.set(...r)
        return n && (n.emit(`config:${s}`, i, !1), Qs(n, s, i), n.walk((a) => Qs(a, s, i), !0)), o
      }
      return !0
    },
  })
}
function _h(e, t, n, r = "ui") {
  const s = typeof n == "string" ? { key: n, value: n, type: r } : n,
    i = e.hook.text.dispatch(s)
  return e.emit("text", i, !1), i.value
}
function $h(e) {
  const t = e.name
  do {
    if (e.props.isForm === !0) break
    e.parent || qe(106, t), (e = e.parent)
  } while (e)
  e.props.id && ql(e.props.id)
}
function xh(e, t, n) {
  return Kl(e, n)
}
function eu(e, t, n, r) {
  const s = `${e.name}-set`,
    i = e.hook.setErrors.dispatch({ localErrors: n, childErrors: r })
  return (
    Mp(e, i.localErrors, i.childErrors).forEach((o) => {
      e.store.apply(o, (a) => a.meta.source === s)
    }),
    e
  )
}
function kh(e, t, n = !0, r) {
  return (
    eu(e, t, []),
    n &&
      ((r = r || `${e.name}-set`),
      e.walk((s) => {
        s.store.filter((i) => !(i.type === "error" && i.meta && i.meta.source === r))
      })),
    e
  )
}
function Ch(e) {
  return ee(e.props, "id") || (e.props.id = `input_${Qp++}`), e
}
function Ph(e) {
  const t = { initial: typeof e == "object" ? Ct(e) : e }
  let n,
    r = !0
  return new Proxy(t, {
    get(...s) {
      const [i, o] = s
      if (ee(t, o)) return Reflect.get(...s)
      if (n && typeof o == "string" && n.config[o] !== void 0) return n.config[o]
    },
    set(s, i, o, a) {
      if (i === "_n") return (n = o), !0
      if (i === "_emit") return (r = o), !0
      const { prop: l, value: d } = n.hook.prop.dispatch({ prop: i, value: o })
      if (!vt(t[l], d, !1) || typeof d == "object") {
        const f = Reflect.set(s, l, d, a)
        return r && (n.emit("prop", { prop: l, value: d }), typeof l == "string" && n.emit(`prop:${l}`, d)), f
      }
      return !0
    },
  })
}
function Oh(e, t) {
  if (e.props.definition) return e.define(e.props.definition)
  for (const n of t) {
    if (e.props.definition) return
    typeof n.library == "function" && n.library(e)
  }
}
function Eh(e) {
  const t = Ql(e),
    n = Zl(e.config || {}, e.parent)
  return {
    _d: 0,
    _e: Hl(),
    _resolve: !1,
    _tmo: !1,
    _value: t,
    children: hp(e.children || []),
    config: n,
    hook: Yp(),
    isCreated: !1,
    isSettled: !0,
    ledger: Ip(),
    name: Jp(e),
    parent: e.parent || null,
    plugins: new Set(),
    props: Ph(t),
    settled: Promise.resolve(t),
    store: Pp(!0),
    traps: Kp(),
    type: e.type || "input",
    value: t,
  }
}
function Sh(e, t) {
  var n
  if (
    (e.ledger.init((e.store._n = e.props._n = e.config._n = e)),
    (e.props._emit = !1),
    t.props && Object.assign(e.props, t.props),
    (e.props._emit = !0),
    Oh(e, new Set([...(t.plugins || []), ...(e.parent ? e.parent.plugins : [])])),
    t.plugins)
  )
    for (const r of t.plugins) Wi(e, e._c, r, !0, !1)
  return (
    Ch(e),
    e.each((r) => e.add(r)),
    e.parent && e.parent.add(e, t.index),
    e.type === "input" && e.children.length && qe(100, e),
    Jl(e, e._c, e._value, !1),
    e.store.release(),
    !((n = t.props) === null || n === void 0) && n.id && Lp(e),
    e.emit("created", e),
    (e.isCreated = !0),
    e
  )
}
function Ah(e) {
  const t = e || {},
    n = Eh(t),
    r = new Proxy(n, {
      get(...s) {
        const [, i] = s
        if (i === "__FKNode__") return !0
        const o = n.traps.get(i)
        return o && o.get ? o.get(r, n) : Reflect.get(...s)
      },
      set(...s) {
        const [, i, o] = s,
          a = n.traps.get(i)
        return a && a.set ? a.set(r, n, i, o) : Reflect.set(...s)
      },
    })
  return Sh(r, t)
}
function Zs(e) {
  return typeof e != "string" && ee(e, "$el")
}
function ei(e) {
  return typeof e != "string" && ee(e, "$cmp")
}
function _n(e) {
  return !e || typeof e == "string" ? !1 : ee(e, "if") && ee(e, "then")
}
function Th(e) {
  return typeof e != "string" && "$formkit" in e
}
function Mh(e) {
  if (typeof e == "string") return { $el: "text", children: e }
  if (Th(e)) {
    const { $formkit: t, for: n, if: r, children: s, bind: i, ...o } = e
    return Object.assign({ $cmp: "FormKit", props: { ...o, type: t } }, r ? { if: r } : {}, n ? { for: n } : {}, s ? { children: s } : {}, i ? { bind: i } : {})
  }
  return e
}
function Ze(e) {
  let t
  const n = new Set(),
    r = function (w, g) {
      return typeof w == "function" ? w(g) : w
    },
    s = [
      { "&&": (b, w, g) => r(b, g) && r(w, g), "||": (b, w, g) => r(b, g) || r(w, g) },
      {
        "===": (b, w, g) => r(b, g) === r(w, g),
        "!==": (b, w, g) => r(b, g) !== r(w, g),
        "==": (b, w, g) => r(b, g) == r(w, g),
        "!=": (b, w, g) => r(b, g) != r(w, g),
        ">=": (b, w, g) => r(b, g) >= r(w, g),
        "<=": (b, w, g) => r(b, g) <= r(w, g),
        ">": (b, w, g) => r(b, g) > r(w, g),
        "<": (b, w, g) => r(b, g) < r(w, g),
      },
      { "+": (b, w, g) => r(b, g) + r(w, g), "-": (b, w, g) => r(b, g) - r(w, g) },
      { "*": (b, w, g) => r(b, g) * r(w, g), "/": (b, w, g) => r(b, g) / r(w, g), "%": (b, w, g) => r(b, g) % r(w, g) },
    ],
    i = s.reduce((b, w) => b.concat(Object.keys(w)), []),
    o = new Set(i.map((b) => b.charAt(0)))
  function a(b, w, g, k) {
    const M = b.filter((_) => _.startsWith(w))
    return M.length ? M.find((_) => (k.length >= g + _.length && k.substring(g, g + _.length) === _ ? _ : !1)) : !1
  }
  function l(b, w, g = 1) {
    let k = g ? w.substring(b + 1).trim() : w.substring(0, b).trim()
    if (!k.length) return -1
    if (!g) {
      const _ = k.split("").reverse(),
        P = _.findIndex((T) => o.has(T))
      k = _.slice(P).join("")
    }
    const M = k[0]
    return s.findIndex((_) => {
      const P = Object.keys(_)
      return !!a(P, M, 0, k)
    })
  }
  function d(b, w) {
    let g = ""
    const k = w.length
    let M = 0
    for (let _ = b; _ < k; _++) {
      const P = w.charAt(_)
      if (P === "(") M++
      else if (P === ")") M--
      else if (M === 0 && P === " ") continue
      if (M === 0 && a(i, P, _, w)) return [g, _ - 1]
      g += P
    }
    return [g, w.length - 1]
  }
  function f(b, w = 0) {
    const g = s[w],
      k = b.length,
      M = Object.keys(g)
    let _ = 0,
      P = !1,
      T = null,
      v = "",
      A = null,
      D,
      Y = "",
      K = "",
      G = "",
      ue = "",
      xe = 0
    const ae = (z, X) => {
      z ? (G += X) : (v += X)
    }
    for (let z = 0; z < k; z++)
      if (((Y = K), (K = b.charAt(z)), (K === "'" || K === '"') && Y !== "\\" && ((_ === 0 && !P) || (_ && !ue)))) {
        _ ? (ue = K) : (P = K), ae(_, K)
        continue
      } else if ((P && (K !== P || Y === "\\")) || (ue && (K !== ue || Y === "\\"))) {
        ae(_, K)
        continue
      } else if (P === K) {
        ;(P = !1), ae(_, K)
        continue
      } else if (ue === K) {
        ;(ue = !1), ae(_, K)
        continue
      } else {
        if (K === " ") continue
        if (K === "(") _ === 0 ? (xe = z) : (G += K), _++
        else if (K === ")")
          if ((_--, _ === 0)) {
            const X = typeof v == "string" && v.startsWith("$") ? v : void 0,
              ce = X && b.charAt(z + 1) === "."
            let Te = ""
            ce && ([Te, z] = d(z + 2, b))
            const Ye = T ? w : l(xe, b, 0),
              Me = l(z, b)
            Ye === -1 && Me === -1
              ? (v = u(G, -1, X, Te))
              : T && (Ye >= Me || Me === -1) && w === Ye
              ? ((A = T.bind(null, u(G, -1, X, Te))), (T = null), (v = ""))
              : Me > Ye && w === Me
              ? (v = u(G, -1, X, Te))
              : (v += `(${G})${ce ? `.${Te}` : ""}`),
              (G = "")
          } else G += K
        else if (_ === 0 && (D = a(M, K, z, b))) {
          z === 0 && qe(103, [D, b]),
            (z += D.length - 1),
            z === b.length - 1 && qe(104, [D, b]),
            T ? v && ((A = T.bind(null, u(v, w))), (T = g[D].bind(null, A)), (v = "")) : A ? ((T = g[D].bind(null, u(A, w))), (A = null)) : ((T = g[D].bind(null, u(v, w))), (v = ""))
          continue
        } else ae(_, K)
      }
    return v && T && (T = T.bind(null, u(v, w))), (T = !T && A ? A : T), !T && v && ((T = (z, X) => (typeof z == "function" ? z(X) : z)), (T = T.bind(null, u(v, w)))), !T && !v && qe(105, b), T
  }
  function u(b, w, g, k) {
    if (g) {
      const M = u(g, s.length)
      let _,
        P = k ? Ze(`$${k}`) : !1
      if (typeof M == "function") {
        const T = bp(String(b)).map((v) => u(v, -1))
        return (v) => {
          const A = M(v)
          return typeof A != "function"
            ? (fn(150, g), A)
            : ((_ = A(...T.map((D) => (typeof D == "function" ? D(v) : D)))),
              P &&
                (P = P.provide((D) => {
                  const Y = t(D)
                  return D.reduce((G, ue) => {
                    if (ue === k || (k == null ? void 0 : k.startsWith(`${ue}(`))) {
                      const ae = wp(_, ue)
                      G[ue] = () => ae
                    } else G[ue] = Y[ue]
                    return G
                  }, {})
                })),
              P ? P() : _)
        }
      }
    } else if (typeof b == "string") {
      if (b === "true") return !0
      if (b === "false") return !1
      if (b === "undefined") return
      if (vp(b)) return yp(b.substring(1, b.length - 1))
      if (!isNaN(+b)) return Number(b)
      if (w < s.length - 1) return f(b, w + 1)
      if (b.startsWith("$")) {
        const M = b.substring(1)
        return (
          n.add(M),
          function (P) {
            return M in P ? P[M]() : void 0
          }
        )
      }
      return b
    }
    return b
  }
  const c = f(e.startsWith("$:") ? e.substring(2) : e),
    p = Array.from(n)
  function $(b) {
    return (t = b), Object.assign(c.bind(null, b(p)), { provide: $ })
  }
  return Object.assign(c, { provide: $ })
}
function Sr(e, t, n) {
  return n ? (typeof n == "string" ? n.split(" ").reduce((s, i) => Object.assign(s, { [i]: !0 }), {}) : typeof n == "function" ? Sr(e, t, n(t, e)) : n) : {}
}
function jh(e, t, ...n) {
  const r = n.reduce((s, i) => {
    if (!i) return s
    const { $reset: o, ...a } = i
    return o ? a : Object.assign(s, a)
  }, {})
  return (
    Object.keys(e.hook.classes.dispatch({ property: t, classes: r }).classes)
      .filter((s) => r[s])
      .join(" ") || null
  )
}
function Rh(e, t, n) {
  const r = cr(e)
  r ? r.setErrors(t, n) : fn(651, e)
}
function Ih(e, t = !0) {
  const n = cr(e)
  n ? n.clearErrors(t) : fn(652, e)
}
const Wr = "1.0.0-beta.11"
function Dh(...e) {
  const t = e.reduce((r, s) => an(r, s), {}),
    n = () => {}
  return (
    (n.library = function (r) {
      const s = Cn(r.props.type)
      ee(t, s) && r.define(t[s])
    }),
    n
  )
}
function Fh(e) {
  let t = 1
  return Array.isArray(e)
    ? e.map((n) =>
        typeof n == "string" || typeof n == "number"
          ? { label: String(n), value: String(n) }
          : (typeof n == "object" && "value" in n && typeof n.value != "string" && Object.assign(n, { value: `__mask_${t++}`, __original: n.value }), n)
      )
    : Object.keys(e).map((n) => ({ label: e[n], value: n }))
}
function ln(e, t) {
  if (Array.isArray(e)) {
    for (const n of e) if (t == n.value) return "__original" in n ? n.__original : n.value
  }
  return t
}
function Rn(e, t) {
  return e == t ? !0 : on(e) && on(t) ? vt(e, t) : !1
}
function Hi(e) {
  e.hook.prop((t, n) => (t.prop === "options" && (typeof t.value == "function" ? ((e.props.optionsLoader = t.value), (t.value = [])) : (t.value = Fh(t.value))), n(t)))
}
const dn = se(
    "outer",
    () => ({
      $el: "div",
      attrs: {
        key: "$id",
        "data-family": "$family || undefined",
        "data-type": "$type",
        "data-multiple": '$attrs.multiple || ($type != "select" && $options != undefined) || undefined',
        "data-disabled": "$disabled || undefined",
        "data-complete": "$state.complete || undefined",
        "data-invalid": "$state.valid === false && $state.validationVisible || undefined",
        "data-errors": "$state.errors || undefined",
        "data-submitted": "$state.submitted || undefined",
        "data-prefix-icon": "$_rawPrefixIcon !== undefined || undefined",
        "data-suffix-icon": "$_rawSuffixIcon !== undefined || undefined",
        "data-prefix-icon-click": "$onPrefixIconClick !== undefined || undefined",
        "data-suffix-icon-click": "$onSuffixIconClick !== undefined || undefined",
      },
    }),
    !0
  ),
  Bt = se("inner", "div"),
  dr = se("wrapper", "div"),
  ms = se("label", () => ({ $el: "label", if: "$label", attrs: { for: "$id" } })),
  Vt = se("messages", () => ({ $el: "ul", if: "$fns.length($messages)" })),
  qt = se("message", () => ({ $el: "li", for: ["message", "$messages"], attrs: { key: "$message.key", id: "$id + '-' + $message.key", "data-message-type": "$message.type" } })),
  Et = se("prefix", null),
  St = se("suffix", null),
  At = se("help", () => ({ $el: "div", if: "$help", attrs: { id: '$: "help-" + $id' } })),
  tu = se("fieldset", () => ({ $el: "fieldset", attrs: { id: "$id", "aria-describedby": { if: "$help", then: '$: "help-" + $id', else: void 0 } } })),
  Hr = se("decorator", () => ({ $el: "span", attrs: { "aria-hidden": "true" } })),
  zr = se("input", () => ({
    $el: "input",
    bind: "$attrs",
    attrs: {
      type: "$type",
      name: "$node.props.altName || $node.name",
      disabled: "$option.attrs.disabled || $disabled",
      onInput: "$handlers.toggleChecked",
      checked: "$fns.eq($_value, $onValue)",
      onBlur: "$handlers.blur",
      value: "$: true",
      id: "$id",
      "aria-describedby": { if: "$options.length", then: { if: "$option.help", then: '$: "help-" + $option.attrs.id', else: void 0 }, else: { if: "$help", then: '$: "help-" + $id', else: void 0 } },
    },
  })),
  nu = se("legend", () => ({ $el: "legend", if: "$label" })),
  ru = se("option", () => ({ $el: "li", for: ["option", "$options"], attrs: { "data-disabled": "$option.attrs.disabled || $disabled" } })),
  su = se("options", "ul"),
  Br = se("wrapper", () => ({ $el: "label", attrs: { "data-disabled": { if: "$options.length", then: void 0, else: "$disabled || undefined" } } })),
  iu = se("optionHelp", () => ({ $el: "div", if: "$option.help", attrs: { id: '$: "help-" + $option.attrs.id' } })),
  Vr = se("label", "span"),
  Nh = se("input", () => ({ $el: "button", bind: "$attrs", attrs: { type: "$type", disabled: "$disabled", name: "$node.name", id: "$id" } })),
  Lh = se("default", null),
  Uh = se("input", () => ({
    $el: "input",
    bind: "$attrs",
    attrs: { type: "file", disabled: "$disabled", name: "$node.name", onChange: "$handlers.files", onBlur: "$handlers.blur", id: "$id", "aria-describedby": "$describedBy" },
  })),
  Wh = se("fileItem", () => ({ $el: "li", for: ["file", "$value"] })),
  Hh = se("fileList", () => ({ $el: "ul", if: "$value.length", attrs: { "data-has-multiple": { if: "$value.length > 1", then: "true" } } })),
  zh = se("fileName", () => ({ $el: "span", attrs: { class: "$classes.fileName" } })),
  Xo = se("fileRemove", () => ({ $el: "button", attrs: { onClick: "$handlers.resetFiles" } })),
  Bh = se("noFiles", () => ({ $el: "span", if: "$value.length == 0" })),
  Vh = se("form", () => ({ $el: "form", bind: "$attrs", attrs: { id: "$id", name: "$node.name", onSubmit: "$handlers.submit", "data-loading": "$state.loading || undefined" } }), !0),
  qh = se("actions", () => ({ $el: "div", if: "$actions" })),
  Kh = se("submit", () => ({ $cmp: "FormKit", bind: "$submitAttrs", props: { ignore: !0, type: "submit", disabled: "$disabled", label: "$submitLabel" } })),
  ou = se("input", () => ({
    $el: "input",
    bind: "$attrs",
    attrs: { type: "$type", disabled: "$disabled", name: "$node.name", onInput: "$handlers.DOMInput", onBlur: "$handlers.blur", value: "$_value", id: "$id", "aria-describedby": "$describedBy" },
  })),
  au = se("wrapper", null, !0),
  Yh = se("input", () => ({
    $el: "select",
    bind: "$attrs",
    attrs: {
      id: "$id",
      "data-placeholder": { if: "$placeholder", then: { if: "$value", then: void 0, else: "true" } },
      disabled: "$disabled",
      class: "$classes.input",
      name: "$node.name",
      onChange: "$handlers.onChange",
      onInput: "$handlers.selectInput",
      onBlur: "$handlers.blur",
      "aria-describedby": "$describedBy",
    },
  })),
  Gh = se("option", () => ({
    $el: "option",
    for: ["option", "$options"],
    bind: "$option.attrs",
    attrs: { class: "$classes.option", value: "$option.value", selected: "$fns.isSelected($option.value)" },
  })),
  Qh = () => ({ $el: null, if: "$options.length", for: ["option", "$options"], children: "$slots.option" }),
  Jh = se("input", () => ({
    $el: "textarea",
    bind: "$attrs",
    attrs: { disabled: "$disabled", name: "$node.name", onInput: "$handlers.DOMInput", onBlur: "$handlers.blur", value: "$_value", id: "$id", "aria-describedby": "$describedBy" },
    children: "$initialValue",
  })),
  Ae = (e, t) =>
    se(`${e}Icon`, () => {
      const n = `_raw${e.charAt(0).toUpperCase()}${e.slice(1)}Icon`
      return {
        if: `$${e}Icon && $${n}`,
        $el: `${t || "span"}`,
        attrs: { class: `$classes.${e}Icon + " formkit-icon"`, innerHTML: `$${n}`, onClick: `$handlers.iconClick(${e})`, for: { if: `${t === "label"}`, then: "$id" } },
      }
    })()
function lu(e) {
  return function (t, n) {
    return (
      t.prop === "options" &&
        Array.isArray(t.value) &&
        ((t.value = t.value.map((r) => {
          var s
          return !((s = r.attrs) === null || s === void 0) && s.id ? r : an(r, { attrs: { id: `${e.name}-option-${Ii(String(r.value))}` } })
        })),
        e.props.type === "checkbox" &&
          !Array.isArray(e.value) &&
          (e.isCreated
            ? e.input([], !1)
            : e.on("created", () => {
                Array.isArray(e.value) || e.input([], !1)
              }))),
      n(t)
    )
  }
}
function Xh(e, t) {
  const n = t.target
  if (n instanceof HTMLInputElement) {
    const r = Array.isArray(e.props.options) ? ln(e.props.options, n.value) : n.value
    Array.isArray(e.props.options) && e.props.options.length
      ? Array.isArray(e._value)
        ? e._value.some((s) => Rn(r, s))
          ? e.input(e._value.filter((s) => !Rn(r, s)))
          : e.input([...e._value, r])
        : e.input([r])
      : n.checked
      ? e.input(e.props.onValue)
      : e.input(e.props.offValue)
  }
}
function Zh(e, t) {
  var n, r
  return (n = e.context) === null || n === void 0 || n.value, (r = e.context) === null || r === void 0 || r._value, Array.isArray(e._value) ? e._value.some((s) => Rn(ln(e.props.options, t), s)) : !1
}
function em(e) {
  e.on("created", () => {
    var t, n
    !((t = e.context) === null || t === void 0) && t.handlers && (e.context.handlers.toggleChecked = Xh.bind(null, e)),
      !((n = e.context) === null || n === void 0) && n.fns && (e.context.fns.isChecked = Zh.bind(null, e)),
      ee(e.props, "onValue") || (e.props.onValue = !0),
      ee(e.props, "offValue") || (e.props.offValue = !1)
  }),
    e.hook.prop(lu(e))
}
function zi(e) {
  e.on("created", () => {
    e.props.disabled = kt(e.props.disabled)
  }),
    e.hook.prop(({ prop: t, value: n }, r) => ((n = t === "disabled" ? kt(n) : n), r({ prop: t, value: n }))),
    e.on("prop:disabled", ({ payload: t }) => {
      e.config.disabled = kt(t)
    }),
    e.on("created", () => {
      e.config.disabled = kt(e.props.disabled)
    })
}
function Ar(e, t) {
  return (n) => {
    n.store.set(ot({ key: e, type: "ui", value: t || e, meta: { localize: !0, i18nArgs: [n] } }))
  }
}
const Zo = typeof window < "u"
function uu(e) {
  e.target instanceof HTMLElement && e.target.hasAttribute("data-file-hover") && e.target.removeAttribute("data-file-hover")
}
function ea(e, t) {
  t.target instanceof HTMLInputElement ? e === "dragover" && t.target.setAttribute("data-file-hover", "true") : t.preventDefault(), e === "drop" && uu(t)
}
function tm(e) {
  Ar("noFiles", "Select file")(e),
    Ar("removeAll", "Remove all")(e),
    Ar("remove")(e),
    Zo &&
      (window._FormKit_File_Drop ||
        (window.addEventListener("dragover", ea.bind(null, "dragover")),
        window.addEventListener("drop", ea.bind(null, "drop")),
        window.addEventListener("dragleave", uu),
        (window._FormKit_File_Drop = !0))),
    e.hook.input((t, n) => n(Array.isArray(t) ? t : [])),
    e.on("created", () => {
      Array.isArray(e.value) || e.input([], !1),
        e.context &&
          ((e.context.handlers.resetFiles = (t) => {
            if ((t.preventDefault(), e.input([]), e.props.id && Zo)) {
              const n = document.getElementById(e.props.id)
              n && (n.value = "")
            }
          }),
          (e.context.handlers.files = (t) => {
            var n, r
            const s = []
            if (t.target instanceof HTMLInputElement && t.target.files) {
              for (let i = 0; i < t.target.files.length; i++) {
                let o
                ;(o = t.target.files.item(i)) && s.push({ name: o.name, file: o })
              }
              e.input(s)
            }
            e.context && (e.context.files = s),
              typeof ((n = e.props.attrs) === null || n === void 0 ? void 0 : n.onChange) == "function" && ((r = e.props.attrs) === null || r === void 0 || r.onChange(t))
          }))
    })
}
async function nm(e, t) {
  if (
    (t.preventDefault(),
    await e.settled,
    e.walk((n) => {
      n.store.set(ot({ key: "submitted", value: !0, visible: !1 }))
    }),
    typeof e.props.onSubmitRaw == "function" && e.props.onSubmitRaw(t, e),
    e.ledger.value("blocking"))
  )
    typeof e.props.onSubmitInvalid == "function" && e.props.onSubmitInvalid(e),
      e.props.incompleteMessage !== !1 &&
        e.store.set(
          ot({
            blocking: !1,
            key: "incomplete",
            meta: { localize: e.props.incompleteMessage === void 0, i18nArgs: [{ node: e }], showAsMessage: !0 },
            type: "ui",
            value: e.props.incompleteMessage || "Form incomplete.",
          })
        )
  else if (typeof e.props.onSubmit == "function") {
    const n = e.props.onSubmit(e.hook.submit.dispatch(jn(e.value)), e)
    if (n instanceof Promise) {
      const r = e.props.disabled === void 0 && e.props.submitBehavior !== "live"
      r && (e.props.disabled = !0), e.store.set(ot({ key: "loading", value: !0, visible: !1 })), await n, r && (e.props.disabled = !1), e.store.remove("loading")
    }
  } else t.target instanceof HTMLFormElement && t.target.submit()
}
function rm(e) {
  ;(e.props.isForm = !0),
    e.on("created", () => {
      var t
      !((t = e.context) === null || t === void 0) && t.handlers && (e.context.handlers.submit = nm.bind(null, e)), ee(e.props, "actions") || (e.props.actions = !0)
    }),
    e.on("settled:blocking", () => e.store.remove("incomplete"))
}
function sm(e) {
  e.props.ignore === void 0 && ((e.props.ignore = !0), (e.parent = null))
}
function im(e) {
  e.on("created", () => {
    e.context && (e.context.initialValue = e.value || "")
  })
}
function om(e, t) {
  t.target instanceof HTMLInputElement && e.input(ln(e.props.options, t.target.value))
}
function am(e, t) {
  var n, r
  return (n = e.context) === null || n === void 0 || n.value, (r = e.context) === null || r === void 0 || r._value, Rn(ln(e.props.options, t), e._value)
}
function lm(e) {
  e.on("created", () => {
    var t, n
    Array.isArray(e.props.options) || fn(350, e),
      !((t = e.context) === null || t === void 0) && t.handlers && (e.context.handlers.toggleChecked = om.bind(null, e)),
      !((n = e.context) === null || n === void 0) && n.fns && (e.context.fns.isChecked = am.bind(null, e))
  }),
    e.hook.prop(lu(e))
}
function um(e, t) {
  e.context && e.context.value
  const n = ln(e.props.options, t)
  return Array.isArray(e._value) ? e._value.some((r) => Rn(r, n)) : (e.value === void 0 && !t) || Rn(n, e._value)
}
async function cm(e, t) {
  var n
  typeof ((n = e.props.attrs) === null || n === void 0 ? void 0 : n.onChange) == "function" && (await new Promise((r) => setTimeout(r, 0)), await e.settled, e.props.attrs.onChange(t))
}
function fm(e, t) {
  const n = t.target,
    r = n.hasAttribute("multiple") ? Array.from(n.selectedOptions).map((s) => ln(e.props.options, s.value)) : ln(e.props.options, n.value)
  e.input(r)
}
function ta(e, t) {
  return e.some((n) => n.attrs && n.attrs["data-is-placeholder"]) ? e : [{ label: t, value: "", attrs: { hidden: !0, disabled: !0, "data-is-placeholder": "true" } }, ...e]
}
function dm(e) {
  e.on("created", () => {
    var t, n, r
    const s = kt((t = e.props.attrs) === null || t === void 0 ? void 0 : t.multiple)
    !s &&
      e.props.placeholder &&
      Array.isArray(e.props.options) &&
      (e.hook.prop(({ prop: i, value: o }, a) => (i === "options" && (o = ta(o, e.props.placeholder)), a({ prop: i, value: o }))), (e.props.options = ta(e.props.options, e.props.placeholder))),
      s
        ? e.value === void 0 && e.input([], !1)
        : e.context &&
          !e.context.options &&
          ((e.props.attrs = Object.assign({}, e.props.attrs, { value: e._value })),
          e.on("input", ({ payload: i }) => {
            e.props.attrs = Object.assign({}, e.props.attrs, { value: i })
          })),
      !((n = e.context) === null || n === void 0) && n.handlers && ((e.context.handlers.selectInput = fm.bind(null, e)), (e.context.handlers.onChange = cm.bind(null, e))),
      !((r = e.context) === null || r === void 0) && r.fns && (e.context.fns.isSelected = um.bind(null, e))
  }),
    e.hook.input((t, n) => {
      var r, s, i
      return (
        !e.props.placeholder &&
          t === void 0 &&
          Array.isArray((r = e.props) === null || r === void 0 ? void 0 : r.options) &&
          e.props.options.length &&
          !kt((i = (s = e.props) === null || s === void 0 ? void 0 : s.attrs) === null || i === void 0 ? void 0 : i.multiple) &&
          (t = "__original" in e.props.options[0] ? e.props.options[0].__original : e.props.options[0].value),
        n(t)
      )
    })
}
function Pn(e, t) {
  return (n) => {
    n.props[`${e}Icon`] === void 0 && (n.props[`${e}Icon`] = `default:${t}`)
  }
}
function qr(e) {
  return typeof e == "object" && ("$el" in e || "$cmp" in e || "$formkit" in e)
}
function ti(e) {
  return !!(_n(e) && e.if && e.if.startsWith("$slots.") && typeof e.then == "string" && e.then.startsWith("$slots.") && "else" in e)
}
function Vn(e, t = {}) {
  return typeof e == "string" ? (qr(t) || typeof t == "string" ? t : e) : Array.isArray(e) ? (qr(t) ? t : e) : an(e, t)
}
function se(e, t, n = !1) {
  return (...r) => {
    const s = (i) => {
      const o = !t || typeof t == "string" ? { $el: t } : t()
      return (
        (Zs(o) || ei(o)) &&
          (o.meta || (o.meta = { section: e }),
          r.length && !o.children && (o.children = [...r.map((a) => (typeof a == "string" ? a : a(i)))]),
          Zs(o) && (o.attrs = { class: `$classes.${e}`, ...(o.attrs || {}) })),
        { if: `$slots.${e}`, then: `$slots.${e}`, else: e in i ? Vn(o, i[e]) : o }
      )
    }
    return n ? cu(s) : s
  }
}
function cu(e) {
  return (t) => [e(t)]
}
function Be(e, t, n) {
  return (r) => {
    const s = t(r)
    if (n || (qr(s) && "if" in s) || ti(s)) {
      const i = { if: e, then: s }
      return n && (i.else = n(r)), i
    } else ti(s) ? Object.assign(s.else, { if: e }) : qr(s) && Object.assign(s, { if: e })
    return s
  }
}
function fu(e, t) {
  return (n) => {
    const r = e({})
    return ti(r) ? (Array.isArray(r.else) || (r.else = Vn(Vn(r.else, t), n)), r) : Vn(Vn(r, t), n)
  }
}
function pm(e) {
  return cu(e)
}
const na = {
    schema: dn(Vt(qt("$message.value")), dr(Nh(Ae("prefix"), Et(), Lh("$label || $ui.submit.value"), St(), Ae("suffix"))), At("$help")),
    type: "input",
    family: "button",
    props: [],
    features: [Ar("submit"), sm],
  },
  hm = {
    schema: dn(
      Be(
        "$options == undefined",
        Br(Bt(Et(), zr(), Hr(Ae("decorator")), St()), Be("$label", Vr("$label"))),
        tu(
          nu("$label"),
          At("$help"),
          su(
            ru(
              Br(
                Bt(Et(), fu(zr(), { bind: "$option.attrs", attrs: { id: "$option.attrs.id", value: "$option.value", checked: "$fns.isChecked($option.value)" } }), Hr(Ae("decorator")), St()),
                Be("$option.label", Vr("$option.label"))
              ),
              iu("$option.help")
            )
          )
        )
      ),
      Be("$options == undefined && $help", At("$help")),
      Vt(qt("$message.value"))
    ),
    type: "input",
    family: "box",
    props: ["options", "onValue", "offValue", "optionsLoader"],
    features: [Hi, em, Pn("decorator", "checkboxDecorator")],
  },
  mm = {
    schema: dn(
      dr(
        ms("$label"),
        Bt(
          Ae("prefix", "label"),
          Et(),
          Uh(),
          Hh(Wh(Ae("fileItem"), zh("$file.name"), Be("$value.length === 1", Xo(Ae("fileRemove"), "$ui.remove.value")))),
          Be("$value.length > 1", Xo("$ui.removeAll.value")),
          Bh(Ae("noFiles"), "$ui.noFiles.value"),
          St(),
          Ae("suffix")
        )
      ),
      At("$help"),
      Vt(qt("$message.value"))
    ),
    type: "input",
    family: "text",
    props: [],
    features: [tm, Pn("fileItem", "fileItem"), Pn("fileRemove", "fileRemove"), Pn("noFiles", "noFiles")],
  },
  gm = {
    schema: Vh("$slots.default", Vt(qt("$message.value")), qh(Kh())),
    type: "group",
    props: ["actions", "submit", "submitLabel", "submitAttrs", "submitBehavior", "incompleteMessage"],
    features: [rm, zi],
  },
  vm = { schema: au("$slots.default"), type: "group", props: [], features: [zi] },
  ym = { schema: pm(ou()), type: "input", props: [], features: [] },
  bm = { schema: au("$slots.default"), type: "list", props: [], features: [zi] },
  wm = {
    schema: dn(
      Be(
        "$options == undefined",
        Br(Bt(Et(), zr(), Hr(Ae("decorator")), St()), Be("$label", Vr("$label"))),
        tu(
          nu("$label"),
          At("$help"),
          su(
            ru(
              Br(
                Bt(Et(), fu(zr(), { bind: "$option.attrs", attrs: { id: "$option.attrs.id", value: "$option.value", checked: "$fns.isChecked($option.value)" } }), Hr(Ae("decorator")), St()),
                Be("$option.label", Vr("$option.label"))
              ),
              iu("$option.help")
            )
          )
        )
      ),
      Be("$options === undefined && $help", At("$help")),
      Vt(qt("$message.value"))
    ),
    type: "input",
    family: "box",
    props: ["options", "onValue", "offValue", "optionsLoader"],
    features: [Hi, lm, Pn("decorator", "radioDecorator")],
  },
  _m = {
    schema: dn(
      dr(
        ms("$label"),
        Bt(
          Ae("prefix"),
          Et(),
          Yh(Be("$slots.default", () => "$slots.default", Be("$slots.option", Qh, Gh("$option.label")))),
          Be("$attrs.multiple !== undefined", () => "", Ae("select")),
          St(),
          Ae("suffix")
        )
      ),
      At("$help"),
      Vt(qt("$message.value"))
    ),
    type: "input",
    props: ["options", "placeholder", "optionsLoader"],
    features: [Hi, dm, Pn("select", "select")],
  },
  $m = { schema: dn(dr(ms("$label"), Bt(Ae("prefix", "label"), Et(), Jh(), St(), Ae("suffix"))), At("$help"), Vt(qt("$message.value"))), type: "input", props: [], features: [im] },
  Ue = { schema: dn(dr(ms("$label"), Bt(Ae("prefix", "label"), Et(), ou(), St(), Ae("suffix"))), At("$help"), Vt(qt("$message.value"))), type: "input", family: "text", props: [], features: [] }
var xm = Object.freeze({
  __proto__: null,
  button: na,
  submit: na,
  checkbox: hm,
  file: mm,
  form: gm,
  group: vm,
  hidden: ym,
  list: bm,
  radio: wm,
  select: _m,
  textarea: $m,
  text: Ue,
  color: Ue,
  date: Ue,
  datetimeLocal: Ue,
  email: Ue,
  month: Ue,
  number: Ue,
  password: Ue,
  search: Ue,
  tel: Ue,
  time: Ue,
  url: Ue,
  week: Ue,
  range: Ue,
})
const du = function ({ value: t }) {
  return ["yes", "on", "1", 1, !0, "true"].includes(t)
}
du.skipEmpty = !1
const km = function ({ value: e }, t = !1) {
    const n = Date.parse(t || new Date()),
      r = Date.parse(String(e))
    return isNaN(r) ? !1 : r > n
  },
  Cm = function ({ value: e }, t = "default") {
    const n = { default: /^[a-zA-ZÀ-ÖØ-öø-ÿĄąĆćČčĎďĘęĚěŁłŃńŇňŘřŚśŠšŤťŮůŹźŻŽžż]+$/, latin: /^[a-zA-Z]+$/ },
      r = ee(n, t) ? t : "default"
    return n[r].test(String(e))
  },
  Pm = function ({ value: e }, t = "default") {
    const n = { default: /^[a-zA-ZÀ-ÖØ-öø-ÿĄąĆćČčĎďĘęĚěŁłŃńŇňŘřŚśŠšŤťŮůŹźŻŽžż ]+$/, latin: /^[a-zA-Z ]+$/ },
      r = ee(n, t) ? t : "default"
    return n[r].test(String(e))
  },
  Om = function ({ value: e }, t = "default") {
    const n = { default: /^[a-zA-Z0-9À-ÖØ-öø-ÿĄąĆćĘęŁłŃńŚśŹźŻż]+$/, latin: /^[a-zA-Z0-9]+$/ },
      r = ee(n, t) ? t : "default"
    return n[r].test(String(e))
  },
  Em = function ({ value: e }, t = !1) {
    const n = Date.parse(t || new Date()),
      r = Date.parse(String(e))
    return isNaN(r) ? !1 : r < n
  },
  Sm = function ({ value: t }, n, r) {
    if (!isNaN(t) && !isNaN(n) && !isNaN(r)) {
      const s = 1 * t
      ;(n = Number(n)), (r = Number(r))
      const [i, o] = n <= r ? [n, r] : [r, n]
      return s >= 1 * i && s <= 1 * o
    }
    return !1
  },
  ra = /(_confirm(?:ed)?)$/,
  Am = function (t, n, r = "loose") {
    var s
    n || (n = ra.test(t.name) ? t.name.replace(ra, "") : `${t.name}_confirm`)
    const i = (s = t.at(n)) === null || s === void 0 ? void 0 : s.value
    return r === "strict" ? t.value === i : t.value == i
  },
  Tm = function ({ value: t }, n, r) {
    ;(n = n instanceof Date ? n.getTime() : Date.parse(n)), (r = r instanceof Date ? r.getTime() : Date.parse(r))
    const s = t instanceof Date ? t.getTime() : Date.parse(String(t))
    if (n && !r) (r = n), (n = Date.now())
    else if (!n || !s) return !1
    return s >= n && s <= r
  },
  Mm = function ({ value: t }, n) {
    return n && typeof n == "string" ? gp(n).test(String(t)) : !isNaN(Date.parse(String(t)))
  },
  jm = function ({ value: t }) {
    return /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(String(t))
  },
  Rm = function ({ value: t }, ...n) {
    return typeof t == "string" && n.length ? n.some((r) => t.endsWith(r)) : typeof t == "string" && n.length === 0
  },
  Im = function ({ value: t }, ...n) {
    return n.some((r) => (typeof r == "object" ? vt(r, t) : r == t))
  },
  Dm = function ({ value: t }, n = 0, r = 1 / 0) {
    ;(n = parseInt(n)), (r = isNaN(parseInt(r)) ? 1 / 0 : parseInt(r))
    const s = n <= r ? n : r,
      i = r >= n ? r : n
    if (typeof t == "string" || Array.isArray(t)) return t.length >= s && t.length <= i
    if (t && typeof t == "object") {
      const o = Object.keys(t).length
      return o >= s && o <= i
    }
    return !1
  },
  Fm = function ({ value: t }, ...n) {
    return n.some((r) => (typeof r == "string" && r.substr(0, 1) === "/" && r.substr(-1) === "/" && (r = new RegExp(r.substr(1, r.length - 2))), r instanceof RegExp ? r.test(String(t)) : r === t))
  },
  Nm = function ({ value: t }, n = 10) {
    return Array.isArray(t) ? t.length <= n : Number(t) <= Number(n)
  },
  Lm = function ({ value: t }, n = 1) {
    return Array.isArray(t) ? t.length >= n : Number(t) >= Number(n)
  },
  Um = function ({ value: t }, ...n) {
    return !n.some((r) => (typeof r == "object" ? vt(r, t) : r === t))
  },
  Wm = function ({ value: t }) {
    return !isNaN(t)
  },
  pu = function ({ value: t }, n = "default") {
    return n === "trim" && typeof t == "string" ? !or(t.trim()) : !or(t)
  }
pu.skipEmpty = !1
const Hm = function ({ value: t }, ...n) {
    return typeof t == "string" && n.length ? n.some((r) => t.startsWith(r)) : typeof t == "string" && n.length === 0
  },
  zm = function ({ value: t }, ...n) {
    try {
      const r = n.length ? n : ["http:", "https:"],
        s = new URL(String(t))
      return r.includes(s.protocol)
    } catch {
      return !1
    }
  },
  Bm = Object.freeze(
    Object.defineProperty(
      {
        __proto__: null,
        accepted: du,
        alpha: Cm,
        alpha_spaces: Pm,
        alphanumeric: Om,
        between: Sm,
        confirm: Am,
        date_after: km,
        date_before: Em,
        date_between: Tm,
        date_format: Mm,
        email: jm,
        ends_with: Rm,
        is: Im,
        length: Dm,
        matches: Fm,
        max: Nm,
        min: Lm,
        not: Um,
        number: Wm,
        required: pu,
        starts_with: Hm,
        url: zm,
      },
      Symbol.toStringTag,
      { value: "Module" }
    )
  ),
  hu = new WeakSet()
function Kr(e, t) {
  const n = t || Object.assign(new Map(), { active: !1 }),
    r = new Map(),
    s = function (f) {
      var u
      !n.active || (n.has(e) || n.set(e, new Set()), (u = n.get(e)) === null || u === void 0 || u.add(f))
    },
    i = function (f) {
      return new Proxy(f, {
        get(...u) {
          return typeof u[1] == "string" && s(`prop:${u[1]}`), Reflect.get(...u)
        },
      })
    },
    o = function (f) {
      return new Proxy(f, {
        get(...u) {
          return u[1] === "value" ? (c) => (s(`count:${c}`), f.value(c)) : Reflect.get(...u)
        },
      })
    },
    a = function (f, u) {
      return fr(f) ? Kr(f, n) : (u === "value" && s("commit"), u === "props" ? i(f) : u === "ledger" ? o(f) : f)
    },
    { proxy: l, revoke: d } = Proxy.revocable(e, {
      get(...f) {
        switch (f[1]) {
          case "deps":
            return n
          case "watch":
            return (c) => vu(l, c)
          case "observe":
            return () => {
              const c = new Map(n)
              return n.clear(), (n.active = !0), c
            }
          case "stopObserve":
            return () => {
              const c = new Map(n)
              return (n.active = !1), c
            }
          case "receipts":
            return r
          case "kill":
            return () => {
              gu(r), hu.add(f[2]), d()
            }
        }
        const u = Reflect.get(...f)
        return typeof u == "function"
          ? (...c) => {
              const p = u(...c)
              return a(p, f[1])
            }
          : a(u, f[1])
      },
    })
  return l
}
function mu(e, [t, n], r) {
  t.forEach((s, i) => {
    s.forEach((o) => {
      e.receipts.has(i) || e.receipts.set(i, {}), e.receipts.set(i, Object.assign(e.receipts.get(i), { [o]: i.on(o, r) }))
    })
  }),
    n.forEach((s, i) => {
      s.forEach((o) => {
        if (e.receipts.has(i)) {
          const a = e.receipts.get(i)
          a && ee(a, o) && (i.off(a[o]), delete a[o], e.receipts.set(i, a))
        }
      })
    })
}
function gu(e) {
  e.forEach((t, n) => {
    for (const r in t) n.off(t[r])
  })
}
async function vu(e, t) {
  const n = new Map(e.deps)
  e.observe()
  const r = t(e)
  r instanceof Promise && (await r)
  const s = e.stopObserve()
  mu(e, yu(n, s), () => vu(e, t))
}
function yu(e, t) {
  const n = new Map(),
    r = new Map()
  return (
    t.forEach((s, i) => {
      if (!e.has(i)) n.set(i, s)
      else {
        const o = new Set(),
          a = e.get(i)
        s.forEach((l) => !(a != null && a.has(l)) && o.add(l)), n.set(i, o)
      }
    }),
    e.forEach((s, i) => {
      if (!t.has(i)) r.set(i, s)
      else {
        const o = new Set(),
          a = t.get(i)
        s.forEach((l) => !(a != null && a.has(l)) && o.add(l)), r.set(i, o)
      }
    }),
    [n, r]
  )
}
function Vm(e) {
  return hu.has(e)
}
const sa = ot({ type: "state", blocking: !0, visible: !1, value: !0, key: "validating" })
function qm(e = {}) {
  return function (n) {
    const r = Object.assign({}, e, n.props.validationRules)
    let s = Kr(n)
    const i = { input: hs(), rerun: null, isPassing: !0 }
    let o = Ct(n.props.validation)
    n.on("prop:validation", ({ payload: a }) => {
      vt(o, a) || ((o = Ct(a)), gu(s.receipts), n.store.filter(() => !1, "validation"), (n.props.parsedRules = oa(a, r)), s.kill(), (s = Kr(n)), ni(s, n.props.parsedRules, i))
    }),
      (n.props.parsedRules = oa(o, r)),
      ni(s, n.props.parsedRules, i)
  }
}
function ni(e, t, n) {
  Vm(e) ||
    ((n.input = hs()),
    (n.isPassing = !0),
    e.store.filter((r) => !r.meta.removeImmediately, "validation"),
    t.forEach((r) => r.debounce && clearTimeout(r.timer)),
    t.length &&
      (e.store.set(sa),
      ri(0, t, e, n, !1, () => {
        e.store.remove(sa.key)
      })))
}
function ri(e, t, n, r, s, i) {
  const o = t[e]
  if (!o) return i()
  const a = r.input
  o.state = null
  function l(d, f) {
    ;(r.isPassing = r.isPassing && !!f), (o.queued = !1)
    const u = n.stopObserve()
    mu(n, yu(o.deps, u), () => {
      ;(o.queued = !0), r.rerun && clearTimeout(r.rerun), (r.rerun = setTimeout(ni, 0, n, t, r))
    }),
      (o.deps = u),
      r.input === a && ((o.state = f), f === !1 ? Gm(n, o, s || d) : Ym(n, o), t.length > e + 1 ? ri(e + 1, t, n, r, s || d, i) : i())
  }
  ;(!or(n.value) || !o.skipEmpty) && (r.isPassing || o.force)
    ? o.queued
      ? Km(o, n, (d) => {
          d instanceof Promise ? d.then((f) => l(!0, f)) : l(!1, d)
        })
      : ri(e + 1, t, n, r, s, i)
    : (or(n.value) && o.skipEmpty && r.isPassing && (n.observe(), n.value), l(!1, null))
}
function Km(e, t, n) {
  e.debounce
    ? (e.timer = setTimeout(() => {
        t.observe(), n(e.rule(t, ...e.args))
      }, e.debounce))
    : (t.observe(), n(e.rule(t, ...e.args)))
}
function Ym(e, t) {
  const n = `rule_${t.name}`
  ee(e.store, n) && e.store.remove(n)
}
function Gm(e, t, n) {
  const r = Jm(e, t),
    s = Qm(e, t, r),
    i = ot({ blocking: t.blocking, key: `rule_${t.name}`, meta: { messageKey: t.name, removeImmediately: n, localize: !s, i18nArgs: r }, type: "validation", value: s || "This field is not valid." })
  return e.store.set(i), i
}
function Qm(e, t, n) {
  const r = e.props.validationMessages && ee(e.props.validationMessages, t.name) ? e.props.validationMessages[t.name] : void 0
  return typeof r == "function" ? r(...n) : r
}
function Jm(e, t) {
  return [{ node: e, name: Xm(e), args: t.args }]
}
function Xm(e) {
  return typeof e.props.validationLabel == "function" ? e.props.validationLabel(e) : e.props.validationLabel || e.props.label || e.props.name || String(e.name)
}
const bu = "(?:[\\*+?()0-9]+)",
  wu = "[a-zA-Z][a-zA-Z0-9_]+",
  Zm = new RegExp(`^(${bu}?${wu})(?:\\:(.*)+)?$`, "i"),
  eg = new RegExp(`^(${bu})(${wu})$`, "i"),
  tg = /([\*+?]+)?(\(\d+\))([\*+?]+)?/,
  ia = /\(\d+\)/,
  ng = { blocking: !0, debounce: 0, force: !1, skipEmpty: !0, name: "" }
function oa(e, t) {
  return e
    ? (typeof e == "string" ? rg(e) : jn(e)).reduce((r, s) => {
        let i = s.shift()
        const o = {}
        if (typeof i == "string") {
          const [a, l] = ig(i)
          ee(t, a) && ((i = t[a]), Object.assign(o, l))
        }
        return typeof i == "function" && r.push({ rule: i, args: s, timer: 0, state: null, queued: !0, deps: new Map(), ...ng, ...og(o, i) }), r
      }, [])
    : []
}
function rg(e) {
  return e.split("|").reduce((t, n) => {
    const r = sg(n)
    return r && t.push(r), t
  }, [])
}
function sg(e) {
  const t = e.trim()
  if (t) {
    const n = t.match(Zm)
    if (n && typeof n[1] == "string") {
      const r = n[1].trim(),
        s = n[2] && typeof n[2] == "string" ? n[2].split(",").map((i) => i.trim()) : []
      return [r, ...s]
    }
  }
  return !1
}
function ig(e) {
  const t = e.match(eg)
  if (!t) return [e, { name: e }]
  const n = { "*": { force: !0 }, "+": { skipEmpty: !1 }, "?": { blocking: !1 } },
    [, r, s] = t,
    i = ia.test(r) ? r.match(tg) || [] : [, r]
  return [
    s,
    [i[1], i[2], i[3]].reduce((o, a) => (a && (ia.test(a) ? (o.debounce = parseInt(a.substr(1, a.length - 1))) : a.split("").forEach((l) => ee(n, l) && Object.assign(o, n[l]))), o), { name: s }),
  ]
}
function og(e, t) {
  return e.name || (e.name = t.ruleName || t.name), ["skipEmpty", "force", "debounce", "blocking"].reduce((n, r) => (ee(t, r) && !ee(n, r) && Object.assign(n, { [r]: t[r] }), n), e)
}
function ye(e) {
  return e[0].toUpperCase() + e.substr(1)
}
function aa(e, t = "or") {
  return e.reduce((n, r, s) => ((n += r), s <= e.length - 2 && e.length > 2 && (n += ", "), s === e.length - 2 && (n += `${e.length === 2 ? " " : ""}${t} `), n), "")
}
function _r(e) {
  const t = typeof e == "string" ? new Date(Date.parse(e)) : e
  return t instanceof Date ? new Intl.DateTimeFormat(void 0, { dateStyle: "medium" }).format(t) : "(unknown)"
}
function ag(e, t) {
  return Number(e) >= Number(t) ? [t, e] : [e, t]
}
const lg = {
    add: "Add",
    remove: "Remove",
    removeAll: "Remove all",
    incomplete: "Sorry, not all fields are filled out correctly.",
    submit: "Submit",
    noFiles: "No file chosen",
    moveUp: "Move up",
    moveDown: "Move down",
    isLoading: "Loading...",
    loadMore: "Load more",
  },
  ug = {
    accepted({ name: e }) {
      return `Please accept the ${e}.`
    },
    date_after({ name: e, args: t }) {
      return Array.isArray(t) && t.length ? `${ye(e)} must be after ${_r(t[0])}.` : `${ye(e)} must be in the future.`
    },
    alpha({ name: e }) {
      return `${ye(e)} can only contain alphabetical characters.`
    },
    alphanumeric({ name: e }) {
      return `${ye(e)} can only contain letters and numbers.`
    },
    alpha_spaces({ name: e }) {
      return `${ye(e)} can only contain letters and spaces.`
    },
    date_before({ name: e, args: t }) {
      return Array.isArray(t) && t.length ? `${ye(e)} must be before ${_r(t[0])}.` : `${ye(e)} must be in the past.`
    },
    between({ name: e, args: t }) {
      if (isNaN(t[0]) || isNaN(t[1])) return "This field was configured incorrectly and can\u2019t be submitted."
      const [n, r] = ag(t[0], t[1])
      return `${ye(e)} must be between ${n} and ${r}.`
    },
    confirm({ name: e }) {
      return `${ye(e)} does not match.`
    },
    date_format({ name: e, args: t }) {
      return Array.isArray(t) && t.length ? `${ye(e)} is not a valid date, please use the format ${t[0]}` : "This field was configured incorrectly and can\u2019t be submitted"
    },
    date_between({ name: e, args: t }) {
      return `${ye(e)} must be between ${_r(t[0])} and ${_r(t[1])}`
    },
    email: "Please enter a valid email address.",
    ends_with({ name: e, args: t }) {
      return `${ye(e)} doesn\u2019t end with ${aa(t)}.`
    },
    is({ name: e }) {
      return `${ye(e)} is not an allowed value.`
    },
    length({ name: e, args: [t = 0, n = 1 / 0] }) {
      const r = Number(t) <= Number(n) ? t : n,
        s = Number(n) >= Number(t) ? n : t
      return r == 1 && s === 1 / 0
        ? `${ye(e)} must be at least one character.`
        : r == 0 && s
        ? `${ye(e)} must be less than or equal to ${s} characters.`
        : r && s === 1 / 0
        ? `${ye(e)} must be greater than or equal to ${r} characters.`
        : `${ye(e)} must be between ${r} and ${s} characters.`
    },
    matches({ name: e }) {
      return `${ye(e)} is not an allowed value.`
    },
    max({ name: e, node: { value: t }, args: n }) {
      return Array.isArray(t) ? `Cannot have more than ${n[0]} ${e}.` : `${ye(e)} must be less than or equal to ${n[0]}.`
    },
    mime({ name: e, args: t }) {
      return t[0] ? `${ye(e)} must be of the type: ${t[0]}` : "No file formats allowed."
    },
    min({ name: e, node: { value: t }, args: n }) {
      return Array.isArray(t) ? `Cannot have less than ${n[0]} ${e}.` : `${ye(e)} must be at least ${n[0]}.`
    },
    not({ name: e, node: { value: t } }) {
      return `\u201C${t}\u201D is not an allowed ${e}.`
    },
    number({ name: e }) {
      return `${ye(e)} must be a number.`
    },
    required({ name: e }) {
      return `${ye(e)} is required.`
    },
    starts_with({ name: e, args: t }) {
      return `${ye(e)} doesn\u2019t start with ${aa(t)}.`
    },
    url() {
      return "Please include a valid url."
    },
  }
var cg = Object.freeze({ __proto__: null, ui: lg, validation: ug })
function fg(e) {
  return function (n) {
    let r = la(n.config.locale, e),
      s = r ? e[r] : {}
    n.on("prop:locale", ({ payload: i }) => {
      ;(r = la(i, e)), (s = r ? e[r] : {}), n.store.touch()
    }),
      n.on("prop:label", () => n.store.touch()),
      n.on("prop:validationLabel", () => n.store.touch()),
      n.hook.text((i, o) => {
        var a, l
        const d = ((a = i.meta) === null || a === void 0 ? void 0 : a.messageKey) || i.key
        if (ee(s, i.type) && ee(s[i.type], d)) {
          const f = s[i.type][d]
          typeof f == "function" ? (i.value = Array.isArray((l = i.meta) === null || l === void 0 ? void 0 : l.i18nArgs) ? f(...i.meta.i18nArgs) : f(i)) : (i.value = f)
        }
        return o(i)
      })
  }
}
function la(e, t) {
  if (ee(t, e)) return e
  const [n] = e.split("-")
  if (ee(t, n)) return n
  for (const r in t) return r
  return !1
}
let rt,
  ct = null,
  Yr,
  _u = !1,
  qn = !1
const dg = new Promise((e) => {
    Yr = () => {
      ;(_u = !0), e()
    }
  }),
  Pt = typeof window < "u" && typeof fetch < "u"
rt = Pt ? getComputedStyle(document.documentElement) : void 0
const Zt = {},
  xs = {}
function pg(e, t, n, r) {
  t && Object.assign(Zt, t), Pt && !qn && (rt == null ? void 0 : rt.getPropertyValue("--formkit-theme")) ? (Yr(), (qn = !0)) : e && !qn && Pt ? hg(e) : !qn && Pt && Yr()
  const s = function (o) {
    var a, l
    o.addProps(["iconLoader", "iconLoaderUrl"]),
      (o.props.iconHandler = Xn(
        !((a = o.props) === null || a === void 0) && a.iconLoader ? o.props.iconLoader : r,
        !((l = o.props) === null || l === void 0) && l.iconLoaderUrl ? o.props.iconLoaderUrl : n
      )),
      vg(o, o.props.iconHandler),
      o.on("created", () => {
        var d
        !((d = o == null ? void 0 : o.context) === null || d === void 0) &&
          d.handlers &&
          (o.context.handlers.iconClick = (f) => {
            const u = `on${f.charAt(0).toUpperCase()}${f.slice(1)}IconClick`,
              c = o.props[u]
            if (c && typeof c == "function") return (p) => c(o, p)
          })
      })
  }
  return (s.iconHandler = Xn(r, n)), s
}
function hg(e) {
  if (
    !(!e || !Pt || typeof getComputedStyle != "function") &&
    ((qn = !0),
    (ct = document.getElementById("formkit-theme")),
    e &&
      Pt &&
      ((!(rt != null && rt.getPropertyValue("--formkit-theme")) && !ct) || ((ct == null ? void 0 : ct.getAttribute("data-theme")) && (ct == null ? void 0 : ct.getAttribute("data-theme")) !== e)))
  ) {
    const n = `https://cdn.jsdelivr.net/npm/@formkit/themes@${Wr.startsWith("__") ? "latest" : Wr}/dist/${e}/theme.css`,
      r = document.createElement("link")
    ;(r.type = "text/css"),
      (r.rel = "stylesheet"),
      (r.id = "formkit-theme"),
      r.setAttribute("data-theme", e),
      (r.onload = () => {
        ;(rt = getComputedStyle(document.documentElement)), Yr()
      }),
      document.head.appendChild(r),
      (r.href = n),
      ct && ct.remove()
  }
}
function Xn(e, t) {
  return (n) => {
    if (typeof n == "boolean") return
    if (n.startsWith("<svg")) return n
    if (typeof n != "string") return
    const r = Zt[n],
      s = n.startsWith("default:")
    n = s ? n.split(":")[1] : n
    let i
    if (r || n in Zt) return Zt[n]
    if (!xs[n]) {
      if (((i = mg(n)), (i = Pt && typeof i > "u" ? Promise.resolve(i) : i), i instanceof Promise))
        xs[n] = i.then((o) => (!o && typeof n == "string" && !s ? (i = typeof e == "function" ? e(n) : gg(n, t)) : o)).then((o) => (typeof n == "string" && (Zt[s ? `default:${n}` : n] = o), o))
      else if (typeof i == "string") return (Zt[s ? `default:${n}` : n] = i), i
    }
    return xs[n]
  }
}
function mg(e) {
  if (!!Pt) return _u ? ua(e) : dg.then(() => ua(e))
}
function ua(e) {
  const t = rt == null ? void 0 : rt.getPropertyValue(`--fk-icon-${e}`)
  if (t) {
    const n = atob(t)
    if (n.startsWith("<svg")) return (Zt[e] = n), n
  }
}
function gg(e, t) {
  const n = Wr.startsWith("__") ? "latest" : Wr,
    r = typeof t == "function" ? t(e) : `https://cdn.jsdelivr.net/npm/@formkit/icons@${n}/dist/icons/${e}.svg`
  if (!!Pt)
    return fetch(`${r}`)
      .then(async (s) => {
        const i = await s.text()
        if (i.startsWith("<svg")) return i
      })
      .catch((s) => {
        console.error(s)
      })
}
function vg(e, t) {
  const n = /^[a-zA-Z-]+(?:-icon|Icon)$/
  Object.keys(e.props)
    .filter((s) => n.test(s))
    .forEach((s) => yg(e, t, s))
}
function yg(e, t, n) {
  const r = e.props[n],
    s = t(r),
    i = `_raw${n.charAt(0).toUpperCase()}${n.slice(1)}`,
    o = `on${n.charAt(0).toUpperCase()}${n.slice(1)}Click`
  if ((e.addProps([i, o]), e.on(`prop:${n}`, bg), s instanceof Promise))
    return s.then((a) => {
      e.props[i] = a
    })
  e.props[i] = s
}
function bg(e) {
  var t
  const n = e.origin,
    r = e.payload,
    s = (t = n == null ? void 0 : n.props) === null || t === void 0 ? void 0 : t.iconHandler,
    i = e.name.split(":")[1],
    o = `_raw${i.charAt(0).toUpperCase()}${i.slice(1)}`
  if (s && typeof s == "function") {
    const a = s(r)
    if (a instanceof Promise)
      return a.then((l) => {
        n.props[o] = l
      })
    n.props[o] = a
  }
}
let Bi = !1
const ca = {
    100: ({ data: e }) => `Only groups, lists, and forms can have children (${e.name}).`,
    101: ({ data: e }) => `You cannot directly modify the store (${e.name}). See: https://formkit.com/advanced/core#message-store`,
    102: ({ data: [e, t] }) => `You cannot directly assign node.${t} (${e.name})`,
    103: ({ data: [e] }) => `Schema expressions cannot start with an operator (${e})`,
    104: ({ data: [e, t] }) => `Schema expressions cannot end with an operator (${e} in "${t}")`,
    105: ({ data: e }) => `Invalid schema expression: ${e}`,
    106: ({ data: e }) => `Cannot submit because (${e}) is not in a form.`,
    107: ({ data: [e, t] }) => `Cannot set ${e.name} to non object value: ${t}`,
    108: ({ data: [e, t] }) => `Cannot set ${e.name} to non array value: ${t}`,
    300: ({ data: [e] }) => `Cannot set behavior prop to overscroll (on ${e.name} input) when options prop is a function.`,
    600: ({ data: e }) => `Unknown input type${typeof e.props.type == "string" ? ' "' + e.props.type + '"' : ""} ("${e.name}")`,
    601: ({ data: e }) => `Input definition${typeof e.props.type == "string" ? ' "' + e.props.type + '"' : ""} is missing a schema or component property (${e.name}).`,
  },
  fa = {
    150: ({ data: e }) => `Schema function "${e}()" is not a valid function.`,
    151: ({ data: e }) => `No form element with id: ${e}`,
    152: ({ data: e }) => `No input element with id: ${e}`,
    350: ({ data: e }) => `Invalid options prop for radio input (${e.name}). See https://formkit.com/inputs/radio`,
    650: 'Schema "$get()" must use the id of an input to access.',
    651: ({ data: e }) => `Cannot setErrors() on "${e}" because no such id exists.`,
    652: ({ data: e }) => `Cannot clearErrors() on "${e}" because no such id exists.`,
    800: ({ data: e }) => `${e} is deprecated.`,
  },
  wg = (e, t) => {
    if (e.code in ca) {
      const n = ca[e.code]
      e.message = typeof n == "function" ? n(e) : n
    }
    return t(e)
  }
Bi || Fi(wg)
const _g = (e, t) => {
  if (e.code in fa) {
    const n = fa[e.code]
    e.message = typeof n == "function" ? n(e) : n
  }
  return t(e)
}
Bi || Ni(_g)
Bi = !0
const ks = {}
let De
const en = new Map(),
  $g = "__raw__",
  xg = /[a-zA-Z0-9\-][cC]lass$/
function kg(e, t) {
  const n = ne(null)
  if (e === "get") {
    const s = {}
    return (n.value = Cg.bind(null, s)), n
  }
  const r = e.split(".")
  return xt(() => (n.value = Vi(t, r))), n
}
function Vi(e, t) {
  if (Array.isArray(e)) {
    for (const s of e) {
      const i = s !== !1 && Vi(s, t)
      if (i !== void 0) return i
    }
    return
  }
  let n,
    r = e
  for (const s in t) {
    const i = t[s]
    if (typeof r != "object" || r === null) {
      n = void 0
      break
    }
    const o = r[i]
    if (Number(s) === t.length - 1 && o !== void 0) {
      n = o
      break
    }
    r = o
  }
  return n
}
function Cg(e, t) {
  if (typeof t != "string") return fn(650)
  if ((t in e || (e[t] = ne(void 0)), e[t].value === void 0)) {
    e[t].value = null
    const n = cr(t)
    n && (e[t].value = n.context),
      Wp(t, ({ payload: r }) => {
        e[t].value = fr(r) ? r.context : r
      })
  }
  return e[t].value
}
function da(e, t) {
  function n(u, c) {
    const p = f(Ze(c.if), { if: !0 }),
      $ = l(u, c.then),
      b = c.else ? l(u, c.else) : null
    return [p, $, b]
  }
  function r(u, c) {
    var p, $
    const b = f(Ze(u.if))
    let w = () => c,
      g = () => c
    return (
      typeof u.then == "object"
        ? (g = s(u.then, void 0))
        : typeof u.then == "string" && ((p = u.then) === null || p === void 0 ? void 0 : p.startsWith("$"))
        ? (g = f(Ze(u.then)))
        : (g = () => u.then),
      ee(u, "else") &&
        (typeof u.else == "object" ? (w = s(u.else)) : typeof u.else == "string" && (($ = u.else) === null || $ === void 0 ? void 0 : $.startsWith("$")) ? (w = f(Ze(u.else))) : (w = () => u.else)),
      () => (b() ? g() : w())
    )
  }
  function s(u, c, p = {}) {
    const $ = new Set(Object.keys(u || {})),
      b = c ? f(Ze(c)) : () => ({}),
      w = [
        (g) => {
          const k = b()
          for (const M in k) $.has(M) || (g[M] = k[M])
        },
      ]
    if (u) {
      if (_n(u)) return r(u, p)
      for (let g in u) {
        const k = u[g]
        let M
        const _ = typeof k == "string"
        g.startsWith($g)
          ? ((g = g.substring(7)), (M = () => k))
          : _ && k.startsWith("$") && k.length > 1 && !(k.startsWith("$reset") && xg.test(g))
          ? (M = f(Ze(k)))
          : typeof k == "object" && _n(k)
          ? (M = r(k, void 0))
          : typeof k == "object" && on(k)
          ? (M = s(k))
          : (M = () => k),
          w.push((P) => {
            P[g] = M()
          })
      }
    }
    return () => {
      const g = Array.isArray(u) ? [] : {}
      return w.forEach((k) => k(g)), g
    }
  }
  function i(u, c) {
    let p = null,
      $ = () => null,
      b = !1,
      w = null,
      g = null,
      k = null,
      M = !1
    const _ = Mh(c)
    if (
      (Zs(_)
        ? ((p = _.$el), ($ = _.$el !== "text" ? s(_.attrs, _.bind) : () => null))
        : ei(_)
        ? (typeof _.$cmp == "string" ? (ee(u, _.$cmp) ? (p = u[_.$cmp]) : ((p = _.$cmp), (M = !0))) : (p = _.$cmp), ($ = s(_.props, _.bind)))
        : _n(_) && ([b, w, g] = n(u, _)),
      !_n(_) && "if" in _ ? (b = f(Ze(_.if))) : !_n(_) && p === null && (b = () => !0),
      "children" in _ && _.children)
    )
      if (typeof _.children == "string")
        if (_.children.startsWith("$slots.")) (p = p === "text" ? "slot" : p), (w = f(Ze(_.children)))
        else if (_.children.startsWith("$") && _.children.length > 1) {
          const P = f(Ze(_.children))
          w = () => String(P())
        } else w = () => String(_.children)
      else if (Array.isArray(_.children)) w = l(u, _.children)
      else {
        const [P, T, v] = n(u, _.children)
        w = (A) => (P && P() ? T && T(A) : v && v(A))
      }
    if (ei(_))
      if (w) {
        const P = w
        ;(w = (T) => ({
          default(v, A) {
            var D, Y, K, G
            const ue = De
            A && (De = A), v && ((D = en.get(De)) === null || D === void 0 || D.unshift(v)), T && ((Y = en.get(De)) === null || Y === void 0 || Y.unshift(T))
            const xe = P(T)
            return v && ((K = en.get(De)) === null || K === void 0 || K.shift()), T && ((G = en.get(De)) === null || G === void 0 || G.shift()), (De = ue), xe
          },
        })),
          (w.slot = !0)
      } else w = () => ({})
    if ("for" in _ && _.for) {
      const P = _.for.length === 3 ? _.for[2] : _.for[1]
      k = [typeof P == "string" && P.startsWith("$") ? f(Ze(P)) : () => P, _.for[0], _.for.length === 3 ? String(_.for[1]) : null]
    }
    return [b, p, $, w, g, k, M]
  }
  function o(u, c) {
    const p = u(c),
      $ = De
    return Object.keys(p).reduce((b, w) => {
      const g = p && p[w]
      return (b[w] = (k) => (g && g(k, $)) || null), b
    }, {})
  }
  function a(u, c) {
    const [p, $, b, w, g, k, M] = i(u, c)
    let _ = (P) => {
      if (p && $ === null && w) return p() ? w(P) : g && g(P)
      if ($ && (!p || p())) {
        if ($ === "text" && w) return ht(String(w()))
        if ($ === "slot" && w) return w(P)
        const T = M ? rf($) : $,
          v = w != null && w.slot ? o(w, P) : null
        return An(T, b(), v || (w ? w(P) : []))
      }
      return typeof g == "function" ? g(P) : g
    }
    if (k) {
      const P = _,
        [T, v, A] = k
      _ = () => {
        const D = T(),
          Y = isNaN(D)
            ? D
            : Array(Number(D))
                .fill(0)
                .map((ue, xe) => xe),
          K = []
        if (typeof Y != "object") return null
        const G = en.get(De) || []
        for (const ue in Y) {
          if (Array.isArray(Y) && ue === "length") continue
          const xe = Object.defineProperty({ ...G.reduce((ae, z) => (ae.__idata ? { ...ae, ...z } : z), {}), [v]: Y[ue], ...(A !== null ? { [A]: ue } : {}) }, "__idata", { enumerable: !1, value: !0 })
          G.unshift(xe), K.push(P.bind(null, xe)()), G.shift()
        }
        return K
      }
    }
    return _
  }
  function l(u, c) {
    if (Array.isArray(c)) {
      const $ = c.map(a.bind(null, u))
      return (b) => $.map((w) => w(b))
    }
    const p = a(u, c)
    return ($) => p($)
  }
  const d = []
  function f(u, c = {}) {
    const p = {}
    return (
      d.push(($, b) => {
        p[b] = u.provide((w) => $(w, c))
      }),
      () => p[De]()
    )
  }
  return function (c, p) {
    const $ = JSON.stringify(t),
      [b, w] = ee(ks, $) ? ks[$] : [l(e, t), d]
    return (
      (ks[$] = [b, w]),
      w.forEach((g) => {
        g(c, p)
      }),
      () => ((De = p), b())
    )
  }
}
function $u(e, t) {
  const n = en.get(De) || []
  let r
  return n.length && (r = Vi(n, e.split("."))), r === void 0 ? t : r
}
function Pg(e, t) {
  return new Proxy(e, {
    get(...n) {
      let r
      const s = n[1]
      if (typeof s == "string") {
        const i = De
        ;(De = t), (r = $u(s, void 0)), (De = i)
      }
      return r !== void 0 ? r : Reflect.get(...n)
    },
  })
}
function pa(e, t, n) {
  return e(
    (r, s = {}) =>
      r.reduce((i, o) => {
        if (o.startsWith("slots.")) {
          const l = o.substring(6),
            d = t.slots && ee(t.slots, l)
          if (s.if) i[o] = () => d
          else if (t.slots && d) {
            const f = Pg(t, n)
            return (i[o] = () => t.slots[l](f)), i
          }
        }
        const a = kg(o, t)
        return (i[o] = () => $u(o, a.value)), i
      }, {}),
    n
  )
}
let ha = 0
const xu = ur({
    name: "FormKitSchema",
    props: { schema: { type: [Array, Object], required: !0 }, data: { type: Object, default: () => ({}) }, library: { type: Object, default: () => ({}) } },
    setup(e, t) {
      const n = Mi()
      let r = Symbol(String(ha++))
      en.set(r, [])
      let s = da(e.library, e.schema),
        i,
        o
      return (
        Ve(
          () => e.schema,
          (a, l) => {
            var d
            ;(r = Symbol(String(ha++))), (s = da(e.library, e.schema)), (i = pa(s, o, r)), a === l && ((d = n == null ? void 0 : n.proxy) === null || d === void 0 ? void 0 : d.$forceUpdate)()
          },
          { deep: !0 }
        ),
        xt(() => {
          ;(o = Object.assign(pt(e.data), { slots: t.slots })), (i = pa(s, o, r))
        }),
        () => i()
      )
    },
  }),
  Og = {
    config: { type: Object, default: {} },
    classes: { type: Object, required: !1 },
    delay: { type: Number, required: !1 },
    errors: { type: Array, default: [] },
    inputErrors: { type: Object, default: () => ({}) },
    index: { type: Number, required: !1 },
    id: { type: String, required: !1 },
    modelValue: { required: !1 },
    name: { type: String, required: !1 },
    parent: { type: Object, required: !1 },
    plugins: { type: Array, default: [] },
    sectionsSchema: { type: Object, default: {} },
    type: { type: [String, Object], default: "text" },
    validation: { type: [String, Array], required: !1 },
    validationMessages: { type: Object, required: !1 },
    validationRules: { type: Object, required: !1 },
    validationLabel: { type: [String, Function], required: !1 },
  },
  Eg = Og,
  si = Symbol("FormKitParent"),
  Sg = ur({
    props: Eg,
    emits: { input: (e, t) => !0, inputRaw: (e, t) => !0, "update:modelValue": (e) => !0, node: (e) => !!e, submit: (e, t) => !0, submitRaw: (e, t) => !0, submitInvalid: (e) => !0 },
    inheritAttrs: !1,
    setup(e, t) {
      const n = Fg(e, t)
      if ((n.props.definition || qe(600, n), n.props.definition.component))
        return () => {
          var o
          return An((o = n.props.definition) === null || o === void 0 ? void 0 : o.component, { context: n.context }, { ...t.slots })
        }
      const r = ne([]),
        s = () => {
          var o, a
          const l = (a = (o = n.props) === null || o === void 0 ? void 0 : o.definition) === null || a === void 0 ? void 0 : a.schema
          l || qe(601, n), (r.value = typeof l == "function" ? l({ ...e.sectionsSchema }) : l)
        }
      s(), n.on("schema", s), t.emit("node", n)
      const i = n.props.definition.library
      return t.expose({ node: n }), () => An(xu, { schema: r.value, data: n.context, library: i }, { ...t.slots })
    },
  })
function Ag(e, t) {
  return (
    e.component(t.alias || "FormKit", Sg).component(t.schemaAlias || "FormKitSchema", xu),
    {
      get: cr,
      setLocale: (n) => {
        var r
        !((r = t.config) === null || r === void 0) && r.rootConfig && (t.config.rootConfig.locale = n)
      },
      clearErrors: Ih,
      setErrors: Rh,
      submit: ql,
      reset: Kl,
    }
  )
}
const qi = Symbol.for("FormKitOptions"),
  Tg = Symbol.for("FormKitConfig"),
  Mg = {
    install(e, t) {
      const n = Object.assign({ alias: "FormKit", schemaAlias: "FormKitSchema" }, typeof t == "function" ? t() : t),
        r = Hp(n.config || {})
      ;(n.config = { rootConfig: r }), (e.config.globalProperties.$formkit = Ag(e, n)), e.provide(qi, n), e.provide(Tg, r)
    },
  },
  ii = Symbol()
function jg(e, t) {
  const n = {},
    r = (o) => {
      for (const a of o) a.__str in n && n[a.__str](), (n[a.__str] = Ve(Ig.bind(null, e, a), i.bind(null, a), { deep: !1 }))
    },
    i = Rg(e, t, r, (o) => {
      if (!!o.length) for (const a in n) `${a}`.startsWith(`${o.__str}.`) && (n[a](), delete n[a])
    })
  r(Ki(e))
}
function Rg(e, t, n, r) {
  return (s) => {
    const i = ku(e, s)
    i !== ii && (s.__deep && r(s), typeof i == "object" && n(Ki(i, [s], ...s)), t(s, i, e))
  }
}
function Ig(e, t) {
  const n = ku(e, t)
  return n && typeof n == "object" ? Object.keys(n) : n
}
function ku(e, t) {
  if ($e(e)) {
    if (t.length === 0) return e.value
    e = e.value
  }
  return t.reduce((n, r) => (n === ii ? n : n === null || typeof n != "object" ? ii : n[r]), e)
}
function Ki(e, t = [], ...n) {
  if (e === null) return t
  if (!n.length) {
    const r = Object.defineProperty([], "__str", { value: "" })
    if (((e = $e(e) ? e.value : e), e && typeof e == "object")) Object.defineProperty(r, "__deep", { value: !0 }), t.push(r)
    else return [r]
  }
  if (e === null || typeof e != "object") return t
  for (const r in e) {
    const s = n.concat(r)
    Object.defineProperty(s, "__str", { value: s.join(".") })
    const i = e[r]
    on(i) || Array.isArray(i) ? (t.push(Object.defineProperty(s, "__deep", { value: !0 })), (t = t.concat(Ki(i, [], ...s)))) : t.push(s)
  }
  return t
}
function Tr(e) {
  return e === null || typeof e != "object" || (mt(e) ? (e = fe(e)) : $e(e) && (e = mt(e.value) ? Tr(e.value) : e.value)), e
}
const Cs = [
  "help",
  "label",
  "ignore",
  "disabled",
  "preserve",
  /^preserve(-e|E)rrors/,
  /^[a-z]+(?:-visibility|Visibility)$/,
  /^[a-zA-Z-]+(?:-class|Class)$/,
  "prefixIcon",
  "suffixIcon",
  /^[a-zA-Z-]+(?:-icon|Icon)$/,
]
function ma(e, t) {
  t.classes &&
    Object.keys(t.classes).forEach((n) => {
      typeof n == "string" && ((e.props[`_${n}Class`] = t.classes[n]), Gs(t.classes[n]) && n === "inner" && Object.values(t.classes[n]))
    })
}
function Dg(e) {
  return e
    ? ["Submit", "SubmitRaw", "SubmitInvalid"].reduce((n, r) => {
        const s = `on${r}`
        return s in e && typeof e[s] == "function" && (n[s] = e[s]), n
      }, {})
    : {}
}
function Fg(e, t, n = {}) {
  const r = Object.assign({}, Je(qi) || {}, n),
    s = Mi(),
    i = Dg(s == null ? void 0 : s.vnode.props),
    o = e.modelValue !== void 0,
    a = e.modelValue !== void 0 ? e.modelValue : Ct(t.attrs.value)
  function l() {
    const _ = { ...gn(e), ...i },
      P = qo(gn(t.attrs), Cs)
    _.attrs = P
    const T = Ko(gn(t.attrs), Cs)
    for (const A in T) _[Cn(A)] = T[A]
    const v = { props: {} }
    return ma(v, e), Object.assign(_, v.props), typeof _.type != "string" && ((_.definition = _.type), delete _.type), _
  }
  const d = l(),
    f = d.ignore ? null : e.parent || Je(si, null),
    u = Ah(an(r || {}, { name: e.name || void 0, value: a, parent: f, plugins: (r.plugins || []).concat(e.plugins), config: e.config, props: d, index: e.index }, !1, !0))
  u.props.definition || qe(600, u)
  const c = ne(new Set(u.props.definition.props || []))
  u.on("added-props", ({ payload: _ }) => {
    Array.isArray(_) && _.forEach((P) => c.value.add(P))
  })
  const p = ke(() => Cs.concat([...c.value]).reduce((_, P) => (typeof P == "string" ? (_.push(Cn(P)), _.push(Ii(P))) : _.push(P), _), []))
  xt(() => ma(u, e))
  const $ = gn(e)
  for (const _ in $)
    Ve(
      () => e[_],
      () => {
        e[_] !== void 0 && (u.props[_] = e[_])
      }
    )
  const b = new Set(),
    w = gn(t.attrs)
  xt(() => {
    g(Ko(w, p.value))
  })
  function g(_) {
    b.forEach((P) => {
      P(), b.delete(P)
    })
    for (const P in _) {
      const T = Cn(P)
      b.add(
        Ve(
          () => t.attrs[P],
          () => {
            u.props[T] = t.attrs[P]
          }
        )
      )
    }
  }
  if (
    (xt(() => {
      const _ = qo(gn(t.attrs), p.value)
      u.props.attrs = Object.assign({}, u.props.attrs || {}, _)
    }),
    xt(() => {
      const _ = e.errors.map((P) => ot({ key: Wl(P), type: "error", value: P, meta: { source: "prop" } }))
      u.store.apply(_, (P) => P.type === "error" && P.meta.source === "prop")
    }),
    u.type !== "input")
  ) {
    const _ = `${u.name}-prop`
    xt(() => {
      const P = Object.keys(e.inputErrors)
      P.length || u.clearErrors(!0, _)
      const T = P.reduce((v, A) => {
        let D = e.inputErrors[A]
        return typeof D == "string" && (D = [D]), Array.isArray(D) && (v[A] = D.map((Y) => ot({ key: Y, type: "error", value: Y, meta: { source: _ } }))), v
      }, {})
      u.store.apply(T, (v) => v.type === "error" && v.meta.source === _)
    })
  }
  xt(() => Object.assign(u.config, e.config)), u.type !== "input" && Kn(si, u)
  let k
  const M = new WeakSet()
  return (
    u.on("modelUpdated", () => {
      var _, P
      if (
        (t.emit("inputRaw", (_ = u.context) === null || _ === void 0 ? void 0 : _.value, u),
        clearTimeout(k),
        (k = setTimeout(t.emit, 20, "input", (P = u.context) === null || P === void 0 ? void 0 : P.value, u)),
        o && u.context)
      ) {
        const T = Tr(u.context.value)
        Gs(T) && Tr(e.modelValue) !== T && M.add(T), t.emit("update:modelValue", T)
      }
    }),
    o &&
      (jg(Sc(e, "modelValue"), (_, P) => {
        var T
        const v = Tr(P)
        if (Gs(v) && M.has(v)) return M.delete(v)
        _.length ? (T = u.at(_)) === null || T === void 0 || T.input(P, !1) : u.input(P, !1)
      }),
      u.value !== a && u.emit("modelUpdated")),
    Ci(() => u.destroy()),
    u
  )
}
const Ng = function (t) {
    t.ledger.count("blocking", (v) => v.blocking)
    const n = ne(!t.ledger.value("blocking"))
    t.ledger.count("errors", (v) => v.type === "error")
    const r = ne(!!t.ledger.value("errors"))
    let s = !1
    as(() => {
      s = !0
    })
    const i = pt(t.store.reduce((v, A) => (A.visible && (v[A.key] = A), v), {})),
      o = ne(t.props.validationVisibility || "blur")
    t.on("prop:validationVisibility", ({ payload: v }) => {
      o.value = v
    })
    const a = ne(o.value === "live"),
      l = ke(() => {
        if (k.state.submitted) return !0
        if (!a.value && !k.state.settled) return !1
        switch (o.value) {
          case "live":
            return !0
          case "blur":
            return k.state.blurred
          case "dirty":
            return k.state.dirty
          default:
            return !1
        }
      }),
      d = ke(() => (f.value ? n.value && !r.value : k.state.dirty && !or(k.value))),
      f = ne(Array.isArray(t.props.parsedRules) && t.props.parsedRules.length > 0)
    t.on("prop:parsedRules", ({ payload: v }) => {
      f.value = Array.isArray(v) && v.length > 0
    })
    const u = ke(() => {
        const v = {}
        for (const A in i) {
          const D = i[A]
          ;(D.type !== "validation" || l.value) && (v[A] = D)
        }
        return v
      }),
      c = pt(t.store.reduce((v, A) => (A.type === "ui" && A.visible && (v[A.key] = A), v), {})),
      p = pt({}),
      $ = new Proxy(p, {
        get(...v) {
          const [A, D] = v
          let Y = Reflect.get(...v)
          return (
            !Y &&
              typeof D == "string" &&
              !ee(A, D) &&
              !D.startsWith("__v") &&
              Kr(t).watch((G) => {
                const ue = typeof G.config.rootClasses == "function" ? G.config.rootClasses(D, G) : {},
                  xe = G.config.classes ? Sr(D, G, G.config.classes[D]) : {},
                  ae = Sr(D, G, G.props[`_${D}Class`]),
                  z = Sr(D, G, G.props[`${D}Class`])
                ;(Y = jh(G, D, ue, xe, ae, z)), (A[D] = Y)
              }),
            Y
          )
        },
      }),
      b = ke(() => {
        const v = []
        k.help && v.push(`help-${t.props.id}`)
        for (const A in u.value) v.push(`${t.props.id}-${A}`)
        return v.length ? v.join(" ") : void 0
      }),
      w = ne(t.value),
      g = ne(t.value),
      k = pt({
        _value: g,
        attrs: t.props.attrs,
        disabled: t.props.disabled,
        describedBy: b,
        fns: { length: (v) => Object.keys(v).length, number: (v) => Number(v), string: (v) => String(v), json: (v) => JSON.stringify(v), eq: vt },
        handlers: {
          blur: (v) => {
            t.store.set(ot({ key: "blurred", visible: !1, value: !0 })), typeof t.props.attrs.onBlur == "function" && t.props.attrs.onBlur(v)
          },
          touch: () => {
            t.store.set(ot({ key: "dirty", visible: !1, value: !0 }))
          },
          DOMInput: (v) => {
            t.input(v.target.value), t.emit("dom-input-event", v)
          },
        },
        help: t.props.help,
        id: t.props.id,
        label: t.props.label,
        messages: u,
        node: bi(t),
        options: t.props.options,
        state: { blurred: !1, complete: d, dirty: !1, submitted: !1, settled: t.isSettled, valid: n, errors: r, rules: f, validationVisible: l },
        type: t.props.type,
        family: t.props.family,
        ui: c,
        value: w,
        classes: $,
      })
    t.on("created", () => {
      vt(k.value, t.value) || ((g.value = t.value), (w.value = t.value), br(w), br(g)), (t.props._init = Ct(t.value))
    }),
      t.on("settled", ({ payload: v }) => {
        k.state.settled = v
      })
    function M(v) {
      v.forEach((A) => {
        ;(A = Cn(A)),
          !ee(k, A) && ee(t.props, A) && (k[A] = t.props[A]),
          t.on(`prop:${A}`, ({ payload: D }) => {
            k[A] = D
          })
      })
    }
    M(
      (() => {
        const v = ["help", "label", "disabled", "options", "type", "attrs", "preserve", "preserveErrors", "id"],
          A = /^[a-zA-Z-]+(?:-icon|Icon)$/,
          D = Object.keys(t.props).filter((Y) => A.test(Y))
        return v.concat(D)
      })()
    )
    function P(v) {
      v.props && M(v.props)
    }
    t.props.definition && P(t.props.definition),
      t.on("added-props", ({ payload: v }) => M(v)),
      t.on("input", ({ payload: v }) => {
        t.type !== "input" && !$e(v) && !mt(v) ? (g.value = Yo(v)) : ((g.value = v), br(g))
      }),
      t.on("commit", ({ payload: v }) => {
        t.type !== "input" && !$e(v) && !mt(v) ? (w.value = g.value = Yo(v)) : ((w.value = g.value = v), br(w)),
          t.emit("modelUpdated"),
          !k.state.dirty && t.isCreated && s && !vt(w.value, t.props._init) && k.handlers.touch(),
          d &&
            t.type === "input" &&
            r.value &&
            !kt(t.props.preserveErrors) &&
            t.store.filter((A) => {
              var D
              return !(A.type === "error" && ((D = A.meta) === null || D === void 0 ? void 0 : D.autoClear) === !0)
            })
      })
    const T = async (v) => {
      v.type === "ui" && v.visible && !v.meta.showAsMessage ? (c[v.key] = v) : v.visible ? (i[v.key] = v) : v.type === "state" && (k.state[v.key] = !!v.value)
    }
    t.on("message-added", (v) => T(v.payload)),
      t.on("message-updated", (v) => T(v.payload)),
      t.on("message-removed", ({ payload: v }) => {
        delete c[v.key], delete i[v.key], delete k.state[v.key]
      }),
      t.on("settled:blocking", () => {
        n.value = !0
      }),
      t.on("unsettled:blocking", () => {
        n.value = !1
      }),
      t.on("settled:errors", () => {
        r.value = !1
      }),
      t.on("unsettled:errors", () => {
        r.value = !0
      }),
      Ve(l, (v) => {
        v && (a.value = !0)
      }),
      (t.context = k),
      t.emit("context", t, !1)
  },
  Lg = (e = {}) => {
    const { rules: t = {}, locales: n = {}, inputs: r = {}, messages: s = {}, locale: i = void 0, theme: o = void 0, iconLoaderUrl: a = void 0, iconLoader: l = void 0, icons: d = {}, ...f } = e,
      u = qm({ ...Bm, ...(t || {}) }),
      c = fg(an({ en: cg, ...(n || {}) }, s)),
      p = Dh(xm, r),
      $ = pg(o, d, a, l)
    return an({ plugins: [p, $, Ng, c, u], ...(i ? { config: { locale: i } } : {}) }, f || {}, !0)
  }
ur({
  name: "FormKitIcon",
  props: { icon: { type: String, default: "" }, iconLoader: { type: Function, default: null }, iconLoaderUrl: { type: Function, default: null } },
  setup(e) {
    var t, n
    const r = ne(void 0),
      s = Je(qi, {}),
      i = Je(si, null)
    let o
    if (e.iconLoader && typeof e.iconLoader == "function") o = Xn(e.iconLoader)
    else if (i && ((t = i.props) === null || t === void 0 ? void 0 : t.iconLoader)) o = Xn(i.props.iconLoader)
    else if (e.iconLoaderUrl && typeof e.iconLoaderUrl == "function") o = Xn(o, e.iconLoaderUrl)
    else {
      const a = (n = s == null ? void 0 : s.plugins) === null || n === void 0 ? void 0 : n.find((l) => typeof l.iconHandler == "function")
      a && (o = a.iconHandler)
    }
    if (o && typeof o == "function") {
      const a = o(e.icon)
      a instanceof Promise
        ? a.then((l) => {
            r.value = l
          })
        : (r.value = a)
    }
    return () => (r.value ? An("span", { class: "formkit-icon", innerHTML: r.value }) : null)
  },
})
function un(e) {
  if (e === null || e === !0 || e === !1) return NaN
  var t = Number(e)
  return isNaN(t) ? t : t < 0 ? Math.ceil(t) : Math.floor(t)
}
function Ne(e, t) {
  if (t.length < e) throw new TypeError(e + " argument" + (e > 1 ? "s" : "") + " required, but only " + t.length + " present")
}
function Mr(e) {
  return (
    typeof Symbol == "function" && typeof Symbol.iterator == "symbol"
      ? (Mr = function (n) {
          return typeof n
        })
      : (Mr = function (n) {
          return n && typeof Symbol == "function" && n.constructor === Symbol && n !== Symbol.prototype ? "symbol" : typeof n
        }),
    Mr(e)
  )
}
function bt(e) {
  Ne(1, arguments)
  var t = Object.prototype.toString.call(e)
  return e instanceof Date || (Mr(e) === "object" && t === "[object Date]")
    ? new Date(e.getTime())
    : typeof e == "number" || t === "[object Number]"
    ? new Date(e)
    : ((typeof e == "string" || t === "[object String]") &&
        typeof console < "u" &&
        (console.warn(
          "Starting with v2.0.0-beta.1 date-fns doesn't accept strings as date arguments. Please use `parseISO` to parse strings. See: https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#string-arguments"
        ),
        console.warn(new Error().stack)),
      new Date(NaN))
}
function Ug(e, t) {
  Ne(2, arguments)
  var n = bt(e).getTime(),
    r = un(t)
  return new Date(n + r)
}
var Wg = {}
function gs() {
  return Wg
}
function Hg(e) {
  var t = new Date(Date.UTC(e.getFullYear(), e.getMonth(), e.getDate(), e.getHours(), e.getMinutes(), e.getSeconds(), e.getMilliseconds()))
  return t.setUTCFullYear(e.getFullYear()), e.getTime() - t.getTime()
}
function jr(e) {
  return (
    typeof Symbol == "function" && typeof Symbol.iterator == "symbol"
      ? (jr = function (n) {
          return typeof n
        })
      : (jr = function (n) {
          return n && typeof Symbol == "function" && n.constructor === Symbol && n !== Symbol.prototype ? "symbol" : typeof n
        }),
    jr(e)
  )
}
function zg(e) {
  return Ne(1, arguments), e instanceof Date || (jr(e) === "object" && Object.prototype.toString.call(e) === "[object Date]")
}
function Bg(e) {
  if ((Ne(1, arguments), !zg(e) && typeof e != "number")) return !1
  var t = bt(e)
  return !isNaN(Number(t))
}
function Vg(e, t) {
  Ne(2, arguments)
  var n = un(t)
  return Ug(e, -n)
}
var qg = 864e5
function Kg(e) {
  Ne(1, arguments)
  var t = bt(e),
    n = t.getTime()
  t.setUTCMonth(0, 1), t.setUTCHours(0, 0, 0, 0)
  var r = t.getTime(),
    s = n - r
  return Math.floor(s / qg) + 1
}
function Gr(e) {
  Ne(1, arguments)
  var t = 1,
    n = bt(e),
    r = n.getUTCDay(),
    s = (r < t ? 7 : 0) + r - t
  return n.setUTCDate(n.getUTCDate() - s), n.setUTCHours(0, 0, 0, 0), n
}
function Cu(e) {
  Ne(1, arguments)
  var t = bt(e),
    n = t.getUTCFullYear(),
    r = new Date(0)
  r.setUTCFullYear(n + 1, 0, 4), r.setUTCHours(0, 0, 0, 0)
  var s = Gr(r),
    i = new Date(0)
  i.setUTCFullYear(n, 0, 4), i.setUTCHours(0, 0, 0, 0)
  var o = Gr(i)
  return t.getTime() >= s.getTime() ? n + 1 : t.getTime() >= o.getTime() ? n : n - 1
}
function Yg(e) {
  Ne(1, arguments)
  var t = Cu(e),
    n = new Date(0)
  n.setUTCFullYear(t, 0, 4), n.setUTCHours(0, 0, 0, 0)
  var r = Gr(n)
  return r
}
var Gg = 6048e5
function Qg(e) {
  Ne(1, arguments)
  var t = bt(e),
    n = Gr(t).getTime() - Yg(t).getTime()
  return Math.round(n / Gg) + 1
}
function Qr(e, t) {
  var n, r, s, i, o, a, l, d
  Ne(1, arguments)
  var f = gs(),
    u = un(
      (n =
        (r =
          (s =
            (i = t == null ? void 0 : t.weekStartsOn) !== null && i !== void 0
              ? i
              : t == null || (o = t.locale) === null || o === void 0 || (a = o.options) === null || a === void 0
              ? void 0
              : a.weekStartsOn) !== null && s !== void 0
            ? s
            : f.weekStartsOn) !== null && r !== void 0
          ? r
          : (l = f.locale) === null || l === void 0 || (d = l.options) === null || d === void 0
          ? void 0
          : d.weekStartsOn) !== null && n !== void 0
        ? n
        : 0
    )
  if (!(u >= 0 && u <= 6)) throw new RangeError("weekStartsOn must be between 0 and 6 inclusively")
  var c = bt(e),
    p = c.getUTCDay(),
    $ = (p < u ? 7 : 0) + p - u
  return c.setUTCDate(c.getUTCDate() - $), c.setUTCHours(0, 0, 0, 0), c
}
function Pu(e, t) {
  var n, r, s, i, o, a, l, d
  Ne(1, arguments)
  var f = bt(e),
    u = f.getUTCFullYear(),
    c = gs(),
    p = un(
      (n =
        (r =
          (s =
            (i = t == null ? void 0 : t.firstWeekContainsDate) !== null && i !== void 0
              ? i
              : t == null || (o = t.locale) === null || o === void 0 || (a = o.options) === null || a === void 0
              ? void 0
              : a.firstWeekContainsDate) !== null && s !== void 0
            ? s
            : c.firstWeekContainsDate) !== null && r !== void 0
          ? r
          : (l = c.locale) === null || l === void 0 || (d = l.options) === null || d === void 0
          ? void 0
          : d.firstWeekContainsDate) !== null && n !== void 0
        ? n
        : 1
    )
  if (!(p >= 1 && p <= 7)) throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively")
  var $ = new Date(0)
  $.setUTCFullYear(u + 1, 0, p), $.setUTCHours(0, 0, 0, 0)
  var b = Qr($, t),
    w = new Date(0)
  w.setUTCFullYear(u, 0, p), w.setUTCHours(0, 0, 0, 0)
  var g = Qr(w, t)
  return f.getTime() >= b.getTime() ? u + 1 : f.getTime() >= g.getTime() ? u : u - 1
}
function Jg(e, t) {
  var n, r, s, i, o, a, l, d
  Ne(1, arguments)
  var f = gs(),
    u = un(
      (n =
        (r =
          (s =
            (i = t == null ? void 0 : t.firstWeekContainsDate) !== null && i !== void 0
              ? i
              : t == null || (o = t.locale) === null || o === void 0 || (a = o.options) === null || a === void 0
              ? void 0
              : a.firstWeekContainsDate) !== null && s !== void 0
            ? s
            : f.firstWeekContainsDate) !== null && r !== void 0
          ? r
          : (l = f.locale) === null || l === void 0 || (d = l.options) === null || d === void 0
          ? void 0
          : d.firstWeekContainsDate) !== null && n !== void 0
        ? n
        : 1
    ),
    c = Pu(e, t),
    p = new Date(0)
  p.setUTCFullYear(c, 0, u), p.setUTCHours(0, 0, 0, 0)
  var $ = Qr(p, t)
  return $
}
var Xg = 6048e5
function Zg(e, t) {
  Ne(1, arguments)
  var n = bt(e),
    r = Qr(n, t).getTime() - Jg(n, t).getTime()
  return Math.round(r / Xg) + 1
}
function de(e, t) {
  for (var n = e < 0 ? "-" : "", r = Math.abs(e).toString(); r.length < t; ) r = "0" + r
  return n + r
}
var ev = {
  y: function (t, n) {
    var r = t.getUTCFullYear(),
      s = r > 0 ? r : 1 - r
    return de(n === "yy" ? s % 100 : s, n.length)
  },
  M: function (t, n) {
    var r = t.getUTCMonth()
    return n === "M" ? String(r + 1) : de(r + 1, 2)
  },
  d: function (t, n) {
    return de(t.getUTCDate(), n.length)
  },
  a: function (t, n) {
    var r = t.getUTCHours() / 12 >= 1 ? "pm" : "am"
    switch (n) {
      case "a":
      case "aa":
        return r.toUpperCase()
      case "aaa":
        return r
      case "aaaaa":
        return r[0]
      case "aaaa":
      default:
        return r === "am" ? "a.m." : "p.m."
    }
  },
  h: function (t, n) {
    return de(t.getUTCHours() % 12 || 12, n.length)
  },
  H: function (t, n) {
    return de(t.getUTCHours(), n.length)
  },
  m: function (t, n) {
    return de(t.getUTCMinutes(), n.length)
  },
  s: function (t, n) {
    return de(t.getUTCSeconds(), n.length)
  },
  S: function (t, n) {
    var r = n.length,
      s = t.getUTCMilliseconds(),
      i = Math.floor(s * Math.pow(10, r - 3))
    return de(i, n.length)
  },
}
const Rt = ev
var vn = { am: "am", pm: "pm", midnight: "midnight", noon: "noon", morning: "morning", afternoon: "afternoon", evening: "evening", night: "night" },
  tv = {
    G: function (t, n, r) {
      var s = t.getUTCFullYear() > 0 ? 1 : 0
      switch (n) {
        case "G":
        case "GG":
        case "GGG":
          return r.era(s, { width: "abbreviated" })
        case "GGGGG":
          return r.era(s, { width: "narrow" })
        case "GGGG":
        default:
          return r.era(s, { width: "wide" })
      }
    },
    y: function (t, n, r) {
      if (n === "yo") {
        var s = t.getUTCFullYear(),
          i = s > 0 ? s : 1 - s
        return r.ordinalNumber(i, { unit: "year" })
      }
      return Rt.y(t, n)
    },
    Y: function (t, n, r, s) {
      var i = Pu(t, s),
        o = i > 0 ? i : 1 - i
      if (n === "YY") {
        var a = o % 100
        return de(a, 2)
      }
      return n === "Yo" ? r.ordinalNumber(o, { unit: "year" }) : de(o, n.length)
    },
    R: function (t, n) {
      var r = Cu(t)
      return de(r, n.length)
    },
    u: function (t, n) {
      var r = t.getUTCFullYear()
      return de(r, n.length)
    },
    Q: function (t, n, r) {
      var s = Math.ceil((t.getUTCMonth() + 1) / 3)
      switch (n) {
        case "Q":
          return String(s)
        case "QQ":
          return de(s, 2)
        case "Qo":
          return r.ordinalNumber(s, { unit: "quarter" })
        case "QQQ":
          return r.quarter(s, { width: "abbreviated", context: "formatting" })
        case "QQQQQ":
          return r.quarter(s, { width: "narrow", context: "formatting" })
        case "QQQQ":
        default:
          return r.quarter(s, { width: "wide", context: "formatting" })
      }
    },
    q: function (t, n, r) {
      var s = Math.ceil((t.getUTCMonth() + 1) / 3)
      switch (n) {
        case "q":
          return String(s)
        case "qq":
          return de(s, 2)
        case "qo":
          return r.ordinalNumber(s, { unit: "quarter" })
        case "qqq":
          return r.quarter(s, { width: "abbreviated", context: "standalone" })
        case "qqqqq":
          return r.quarter(s, { width: "narrow", context: "standalone" })
        case "qqqq":
        default:
          return r.quarter(s, { width: "wide", context: "standalone" })
      }
    },
    M: function (t, n, r) {
      var s = t.getUTCMonth()
      switch (n) {
        case "M":
        case "MM":
          return Rt.M(t, n)
        case "Mo":
          return r.ordinalNumber(s + 1, { unit: "month" })
        case "MMM":
          return r.month(s, { width: "abbreviated", context: "formatting" })
        case "MMMMM":
          return r.month(s, { width: "narrow", context: "formatting" })
        case "MMMM":
        default:
          return r.month(s, { width: "wide", context: "formatting" })
      }
    },
    L: function (t, n, r) {
      var s = t.getUTCMonth()
      switch (n) {
        case "L":
          return String(s + 1)
        case "LL":
          return de(s + 1, 2)
        case "Lo":
          return r.ordinalNumber(s + 1, { unit: "month" })
        case "LLL":
          return r.month(s, { width: "abbreviated", context: "standalone" })
        case "LLLLL":
          return r.month(s, { width: "narrow", context: "standalone" })
        case "LLLL":
        default:
          return r.month(s, { width: "wide", context: "standalone" })
      }
    },
    w: function (t, n, r, s) {
      var i = Zg(t, s)
      return n === "wo" ? r.ordinalNumber(i, { unit: "week" }) : de(i, n.length)
    },
    I: function (t, n, r) {
      var s = Qg(t)
      return n === "Io" ? r.ordinalNumber(s, { unit: "week" }) : de(s, n.length)
    },
    d: function (t, n, r) {
      return n === "do" ? r.ordinalNumber(t.getUTCDate(), { unit: "date" }) : Rt.d(t, n)
    },
    D: function (t, n, r) {
      var s = Kg(t)
      return n === "Do" ? r.ordinalNumber(s, { unit: "dayOfYear" }) : de(s, n.length)
    },
    E: function (t, n, r) {
      var s = t.getUTCDay()
      switch (n) {
        case "E":
        case "EE":
        case "EEE":
          return r.day(s, { width: "abbreviated", context: "formatting" })
        case "EEEEE":
          return r.day(s, { width: "narrow", context: "formatting" })
        case "EEEEEE":
          return r.day(s, { width: "short", context: "formatting" })
        case "EEEE":
        default:
          return r.day(s, { width: "wide", context: "formatting" })
      }
    },
    e: function (t, n, r, s) {
      var i = t.getUTCDay(),
        o = (i - s.weekStartsOn + 8) % 7 || 7
      switch (n) {
        case "e":
          return String(o)
        case "ee":
          return de(o, 2)
        case "eo":
          return r.ordinalNumber(o, { unit: "day" })
        case "eee":
          return r.day(i, { width: "abbreviated", context: "formatting" })
        case "eeeee":
          return r.day(i, { width: "narrow", context: "formatting" })
        case "eeeeee":
          return r.day(i, { width: "short", context: "formatting" })
        case "eeee":
        default:
          return r.day(i, { width: "wide", context: "formatting" })
      }
    },
    c: function (t, n, r, s) {
      var i = t.getUTCDay(),
        o = (i - s.weekStartsOn + 8) % 7 || 7
      switch (n) {
        case "c":
          return String(o)
        case "cc":
          return de(o, n.length)
        case "co":
          return r.ordinalNumber(o, { unit: "day" })
        case "ccc":
          return r.day(i, { width: "abbreviated", context: "standalone" })
        case "ccccc":
          return r.day(i, { width: "narrow", context: "standalone" })
        case "cccccc":
          return r.day(i, { width: "short", context: "standalone" })
        case "cccc":
        default:
          return r.day(i, { width: "wide", context: "standalone" })
      }
    },
    i: function (t, n, r) {
      var s = t.getUTCDay(),
        i = s === 0 ? 7 : s
      switch (n) {
        case "i":
          return String(i)
        case "ii":
          return de(i, n.length)
        case "io":
          return r.ordinalNumber(i, { unit: "day" })
        case "iii":
          return r.day(s, { width: "abbreviated", context: "formatting" })
        case "iiiii":
          return r.day(s, { width: "narrow", context: "formatting" })
        case "iiiiii":
          return r.day(s, { width: "short", context: "formatting" })
        case "iiii":
        default:
          return r.day(s, { width: "wide", context: "formatting" })
      }
    },
    a: function (t, n, r) {
      var s = t.getUTCHours(),
        i = s / 12 >= 1 ? "pm" : "am"
      switch (n) {
        case "a":
        case "aa":
          return r.dayPeriod(i, { width: "abbreviated", context: "formatting" })
        case "aaa":
          return r.dayPeriod(i, { width: "abbreviated", context: "formatting" }).toLowerCase()
        case "aaaaa":
          return r.dayPeriod(i, { width: "narrow", context: "formatting" })
        case "aaaa":
        default:
          return r.dayPeriod(i, { width: "wide", context: "formatting" })
      }
    },
    b: function (t, n, r) {
      var s = t.getUTCHours(),
        i
      switch ((s === 12 ? (i = vn.noon) : s === 0 ? (i = vn.midnight) : (i = s / 12 >= 1 ? "pm" : "am"), n)) {
        case "b":
        case "bb":
          return r.dayPeriod(i, { width: "abbreviated", context: "formatting" })
        case "bbb":
          return r.dayPeriod(i, { width: "abbreviated", context: "formatting" }).toLowerCase()
        case "bbbbb":
          return r.dayPeriod(i, { width: "narrow", context: "formatting" })
        case "bbbb":
        default:
          return r.dayPeriod(i, { width: "wide", context: "formatting" })
      }
    },
    B: function (t, n, r) {
      var s = t.getUTCHours(),
        i
      switch ((s >= 17 ? (i = vn.evening) : s >= 12 ? (i = vn.afternoon) : s >= 4 ? (i = vn.morning) : (i = vn.night), n)) {
        case "B":
        case "BB":
        case "BBB":
          return r.dayPeriod(i, { width: "abbreviated", context: "formatting" })
        case "BBBBB":
          return r.dayPeriod(i, { width: "narrow", context: "formatting" })
        case "BBBB":
        default:
          return r.dayPeriod(i, { width: "wide", context: "formatting" })
      }
    },
    h: function (t, n, r) {
      if (n === "ho") {
        var s = t.getUTCHours() % 12
        return s === 0 && (s = 12), r.ordinalNumber(s, { unit: "hour" })
      }
      return Rt.h(t, n)
    },
    H: function (t, n, r) {
      return n === "Ho" ? r.ordinalNumber(t.getUTCHours(), { unit: "hour" }) : Rt.H(t, n)
    },
    K: function (t, n, r) {
      var s = t.getUTCHours() % 12
      return n === "Ko" ? r.ordinalNumber(s, { unit: "hour" }) : de(s, n.length)
    },
    k: function (t, n, r) {
      var s = t.getUTCHours()
      return s === 0 && (s = 24), n === "ko" ? r.ordinalNumber(s, { unit: "hour" }) : de(s, n.length)
    },
    m: function (t, n, r) {
      return n === "mo" ? r.ordinalNumber(t.getUTCMinutes(), { unit: "minute" }) : Rt.m(t, n)
    },
    s: function (t, n, r) {
      return n === "so" ? r.ordinalNumber(t.getUTCSeconds(), { unit: "second" }) : Rt.s(t, n)
    },
    S: function (t, n) {
      return Rt.S(t, n)
    },
    X: function (t, n, r, s) {
      var i = s._originalDate || t,
        o = i.getTimezoneOffset()
      if (o === 0) return "Z"
      switch (n) {
        case "X":
          return va(o)
        case "XXXX":
        case "XX":
          return Qt(o)
        case "XXXXX":
        case "XXX":
        default:
          return Qt(o, ":")
      }
    },
    x: function (t, n, r, s) {
      var i = s._originalDate || t,
        o = i.getTimezoneOffset()
      switch (n) {
        case "x":
          return va(o)
        case "xxxx":
        case "xx":
          return Qt(o)
        case "xxxxx":
        case "xxx":
        default:
          return Qt(o, ":")
      }
    },
    O: function (t, n, r, s) {
      var i = s._originalDate || t,
        o = i.getTimezoneOffset()
      switch (n) {
        case "O":
        case "OO":
        case "OOO":
          return "GMT" + ga(o, ":")
        case "OOOO":
        default:
          return "GMT" + Qt(o, ":")
      }
    },
    z: function (t, n, r, s) {
      var i = s._originalDate || t,
        o = i.getTimezoneOffset()
      switch (n) {
        case "z":
        case "zz":
        case "zzz":
          return "GMT" + ga(o, ":")
        case "zzzz":
        default:
          return "GMT" + Qt(o, ":")
      }
    },
    t: function (t, n, r, s) {
      var i = s._originalDate || t,
        o = Math.floor(i.getTime() / 1e3)
      return de(o, n.length)
    },
    T: function (t, n, r, s) {
      var i = s._originalDate || t,
        o = i.getTime()
      return de(o, n.length)
    },
  }
function ga(e, t) {
  var n = e > 0 ? "-" : "+",
    r = Math.abs(e),
    s = Math.floor(r / 60),
    i = r % 60
  if (i === 0) return n + String(s)
  var o = t || ""
  return n + String(s) + o + de(i, 2)
}
function va(e, t) {
  if (e % 60 === 0) {
    var n = e > 0 ? "-" : "+"
    return n + de(Math.abs(e) / 60, 2)
  }
  return Qt(e, t)
}
function Qt(e, t) {
  var n = t || "",
    r = e > 0 ? "-" : "+",
    s = Math.abs(e),
    i = de(Math.floor(s / 60), 2),
    o = de(s % 60, 2)
  return r + i + n + o
}
const nv = tv
var ya = function (t, n) {
    switch (t) {
      case "P":
        return n.date({ width: "short" })
      case "PP":
        return n.date({ width: "medium" })
      case "PPP":
        return n.date({ width: "long" })
      case "PPPP":
      default:
        return n.date({ width: "full" })
    }
  },
  Ou = function (t, n) {
    switch (t) {
      case "p":
        return n.time({ width: "short" })
      case "pp":
        return n.time({ width: "medium" })
      case "ppp":
        return n.time({ width: "long" })
      case "pppp":
      default:
        return n.time({ width: "full" })
    }
  },
  rv = function (t, n) {
    var r = t.match(/(P+)(p+)?/) || [],
      s = r[1],
      i = r[2]
    if (!i) return ya(t, n)
    var o
    switch (s) {
      case "P":
        o = n.dateTime({ width: "short" })
        break
      case "PP":
        o = n.dateTime({ width: "medium" })
        break
      case "PPP":
        o = n.dateTime({ width: "long" })
        break
      case "PPPP":
      default:
        o = n.dateTime({ width: "full" })
        break
    }
    return o.replace("{{date}}", ya(s, n)).replace("{{time}}", Ou(i, n))
  },
  sv = { p: Ou, P: rv }
const iv = sv
var ov = ["D", "DD"],
  av = ["YY", "YYYY"]
function lv(e) {
  return ov.indexOf(e) !== -1
}
function uv(e) {
  return av.indexOf(e) !== -1
}
function ba(e, t, n) {
  if (e === "YYYY")
    throw new RangeError(
      "Use `yyyy` instead of `YYYY` (in `".concat(t, "`) for formatting years to the input `").concat(n, "`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md")
    )
  if (e === "YY")
    throw new RangeError(
      "Use `yy` instead of `YY` (in `".concat(t, "`) for formatting years to the input `").concat(n, "`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md")
    )
  if (e === "D")
    throw new RangeError(
      "Use `d` instead of `D` (in `".concat(t, "`) for formatting days of the month to the input `").concat(n, "`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md")
    )
  if (e === "DD")
    throw new RangeError(
      "Use `dd` instead of `DD` (in `".concat(t, "`) for formatting days of the month to the input `").concat(n, "`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md")
    )
}
var cv = {
    lessThanXSeconds: { one: "less than a second", other: "less than {{count}} seconds" },
    xSeconds: { one: "1 second", other: "{{count}} seconds" },
    halfAMinute: "half a minute",
    lessThanXMinutes: { one: "less than a minute", other: "less than {{count}} minutes" },
    xMinutes: { one: "1 minute", other: "{{count}} minutes" },
    aboutXHours: { one: "about 1 hour", other: "about {{count}} hours" },
    xHours: { one: "1 hour", other: "{{count}} hours" },
    xDays: { one: "1 day", other: "{{count}} days" },
    aboutXWeeks: { one: "about 1 week", other: "about {{count}} weeks" },
    xWeeks: { one: "1 week", other: "{{count}} weeks" },
    aboutXMonths: { one: "about 1 month", other: "about {{count}} months" },
    xMonths: { one: "1 month", other: "{{count}} months" },
    aboutXYears: { one: "about 1 year", other: "about {{count}} years" },
    xYears: { one: "1 year", other: "{{count}} years" },
    overXYears: { one: "over 1 year", other: "over {{count}} years" },
    almostXYears: { one: "almost 1 year", other: "almost {{count}} years" },
  },
  fv = function (t, n, r) {
    var s,
      i = cv[t]
    return (
      typeof i == "string" ? (s = i) : n === 1 ? (s = i.one) : (s = i.other.replace("{{count}}", n.toString())),
      r != null && r.addSuffix ? (r.comparison && r.comparison > 0 ? "in " + s : s + " ago") : s
    )
  }
const dv = fv
function Ps(e) {
  return function () {
    var t = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : {},
      n = t.width ? String(t.width) : e.defaultWidth,
      r = e.formats[n] || e.formats[e.defaultWidth]
    return r
  }
}
var pv = { full: "EEEE, MMMM do, y", long: "MMMM do, y", medium: "MMM d, y", short: "MM/dd/yyyy" },
  hv = { full: "h:mm:ss a zzzz", long: "h:mm:ss a z", medium: "h:mm:ss a", short: "h:mm a" },
  mv = { full: "{{date}} 'at' {{time}}", long: "{{date}} 'at' {{time}}", medium: "{{date}}, {{time}}", short: "{{date}}, {{time}}" },
  gv = { date: Ps({ formats: pv, defaultWidth: "full" }), time: Ps({ formats: hv, defaultWidth: "full" }), dateTime: Ps({ formats: mv, defaultWidth: "full" }) }
const vv = gv
var yv = { lastWeek: "'last' eeee 'at' p", yesterday: "'yesterday at' p", today: "'today at' p", tomorrow: "'tomorrow at' p", nextWeek: "eeee 'at' p", other: "P" },
  bv = function (t, n, r, s) {
    return yv[t]
  }
const wv = bv
function Hn(e) {
  return function (t, n) {
    var r = n != null && n.context ? String(n.context) : "standalone",
      s
    if (r === "formatting" && e.formattingValues) {
      var i = e.defaultFormattingWidth || e.defaultWidth,
        o = n != null && n.width ? String(n.width) : i
      s = e.formattingValues[o] || e.formattingValues[i]
    } else {
      var a = e.defaultWidth,
        l = n != null && n.width ? String(n.width) : e.defaultWidth
      s = e.values[l] || e.values[a]
    }
    var d = e.argumentCallback ? e.argumentCallback(t) : t
    return s[d]
  }
}
var _v = { narrow: ["B", "A"], abbreviated: ["BC", "AD"], wide: ["Before Christ", "Anno Domini"] },
  $v = { narrow: ["1", "2", "3", "4"], abbreviated: ["Q1", "Q2", "Q3", "Q4"], wide: ["1st quarter", "2nd quarter", "3rd quarter", "4th quarter"] },
  xv = {
    narrow: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
    abbreviated: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    wide: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
  },
  kv = {
    narrow: ["S", "M", "T", "W", "T", "F", "S"],
    short: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    abbreviated: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    wide: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
  },
  Cv = {
    narrow: { am: "a", pm: "p", midnight: "mi", noon: "n", morning: "morning", afternoon: "afternoon", evening: "evening", night: "night" },
    abbreviated: { am: "AM", pm: "PM", midnight: "midnight", noon: "noon", morning: "morning", afternoon: "afternoon", evening: "evening", night: "night" },
    wide: { am: "a.m.", pm: "p.m.", midnight: "midnight", noon: "noon", morning: "morning", afternoon: "afternoon", evening: "evening", night: "night" },
  },
  Pv = {
    narrow: { am: "a", pm: "p", midnight: "mi", noon: "n", morning: "in the morning", afternoon: "in the afternoon", evening: "in the evening", night: "at night" },
    abbreviated: { am: "AM", pm: "PM", midnight: "midnight", noon: "noon", morning: "in the morning", afternoon: "in the afternoon", evening: "in the evening", night: "at night" },
    wide: { am: "a.m.", pm: "p.m.", midnight: "midnight", noon: "noon", morning: "in the morning", afternoon: "in the afternoon", evening: "in the evening", night: "at night" },
  },
  Ov = function (t, n) {
    var r = Number(t),
      s = r % 100
    if (s > 20 || s < 10)
      switch (s % 10) {
        case 1:
          return r + "st"
        case 2:
          return r + "nd"
        case 3:
          return r + "rd"
      }
    return r + "th"
  },
  Ev = {
    ordinalNumber: Ov,
    era: Hn({ values: _v, defaultWidth: "wide" }),
    quarter: Hn({
      values: $v,
      defaultWidth: "wide",
      argumentCallback: function (t) {
        return t - 1
      },
    }),
    month: Hn({ values: xv, defaultWidth: "wide" }),
    day: Hn({ values: kv, defaultWidth: "wide" }),
    dayPeriod: Hn({ values: Cv, defaultWidth: "wide", formattingValues: Pv, defaultFormattingWidth: "wide" }),
  }
const Sv = Ev
function zn(e) {
  return function (t) {
    var n = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {},
      r = n.width,
      s = (r && e.matchPatterns[r]) || e.matchPatterns[e.defaultMatchWidth],
      i = t.match(s)
    if (!i) return null
    var o = i[0],
      a = (r && e.parsePatterns[r]) || e.parsePatterns[e.defaultParseWidth],
      l = Array.isArray(a)
        ? Tv(a, function (u) {
            return u.test(o)
          })
        : Av(a, function (u) {
            return u.test(o)
          }),
      d
    ;(d = e.valueCallback ? e.valueCallback(l) : l), (d = n.valueCallback ? n.valueCallback(d) : d)
    var f = t.slice(o.length)
    return { value: d, rest: f }
  }
}
function Av(e, t) {
  for (var n in e) if (e.hasOwnProperty(n) && t(e[n])) return n
}
function Tv(e, t) {
  for (var n = 0; n < e.length; n++) if (t(e[n])) return n
}
function Mv(e) {
  return function (t) {
    var n = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {},
      r = t.match(e.matchPattern)
    if (!r) return null
    var s = r[0],
      i = t.match(e.parsePattern)
    if (!i) return null
    var o = e.valueCallback ? e.valueCallback(i[0]) : i[0]
    o = n.valueCallback ? n.valueCallback(o) : o
    var a = t.slice(s.length)
    return { value: o, rest: a }
  }
}
var jv = /^(\d+)(th|st|nd|rd)?/i,
  Rv = /\d+/i,
  Iv = { narrow: /^(b|a)/i, abbreviated: /^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i, wide: /^(before christ|before common era|anno domini|common era)/i },
  Dv = { any: [/^b/i, /^(a|c)/i] },
  Fv = { narrow: /^[1234]/i, abbreviated: /^q[1234]/i, wide: /^[1234](th|st|nd|rd)? quarter/i },
  Nv = { any: [/1/i, /2/i, /3/i, /4/i] },
  Lv = {
    narrow: /^[jfmasond]/i,
    abbreviated: /^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,
    wide: /^(january|february|march|april|may|june|july|august|september|october|november|december)/i,
  },
  Uv = {
    narrow: [/^j/i, /^f/i, /^m/i, /^a/i, /^m/i, /^j/i, /^j/i, /^a/i, /^s/i, /^o/i, /^n/i, /^d/i],
    any: [/^ja/i, /^f/i, /^mar/i, /^ap/i, /^may/i, /^jun/i, /^jul/i, /^au/i, /^s/i, /^o/i, /^n/i, /^d/i],
  },
  Wv = { narrow: /^[smtwf]/i, short: /^(su|mo|tu|we|th|fr|sa)/i, abbreviated: /^(sun|mon|tue|wed|thu|fri|sat)/i, wide: /^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i },
  Hv = { narrow: [/^s/i, /^m/i, /^t/i, /^w/i, /^t/i, /^f/i, /^s/i], any: [/^su/i, /^m/i, /^tu/i, /^w/i, /^th/i, /^f/i, /^sa/i] },
  zv = { narrow: /^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i, any: /^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i },
  Bv = { any: { am: /^a/i, pm: /^p/i, midnight: /^mi/i, noon: /^no/i, morning: /morning/i, afternoon: /afternoon/i, evening: /evening/i, night: /night/i } },
  Vv = {
    ordinalNumber: Mv({
      matchPattern: jv,
      parsePattern: Rv,
      valueCallback: function (t) {
        return parseInt(t, 10)
      },
    }),
    era: zn({ matchPatterns: Iv, defaultMatchWidth: "wide", parsePatterns: Dv, defaultParseWidth: "any" }),
    quarter: zn({
      matchPatterns: Fv,
      defaultMatchWidth: "wide",
      parsePatterns: Nv,
      defaultParseWidth: "any",
      valueCallback: function (t) {
        return t + 1
      },
    }),
    month: zn({ matchPatterns: Lv, defaultMatchWidth: "wide", parsePatterns: Uv, defaultParseWidth: "any" }),
    day: zn({ matchPatterns: Wv, defaultMatchWidth: "wide", parsePatterns: Hv, defaultParseWidth: "any" }),
    dayPeriod: zn({ matchPatterns: zv, defaultMatchWidth: "any", parsePatterns: Bv, defaultParseWidth: "any" }),
  }
const qv = Vv
var Kv = { code: "en-US", formatDistance: dv, formatLong: vv, formatRelative: wv, localize: Sv, match: qv, options: { weekStartsOn: 0, firstWeekContainsDate: 1 } }
const Yv = Kv
var Gv = /[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g,
  Qv = /P+p+|P+|p+|''|'(''|[^'])+('|$)|./g,
  Jv = /^'([^]*?)'?$/,
  Xv = /''/g,
  Zv = /[a-zA-Z]/
function Jr(e, t, n) {
  var r, s, i, o, a, l, d, f, u, c, p, $, b, w, g, k, M, _
  Ne(2, arguments)
  var P = String(t),
    T = gs(),
    v = (r = (s = n == null ? void 0 : n.locale) !== null && s !== void 0 ? s : T.locale) !== null && r !== void 0 ? r : Yv,
    A = un(
      (i =
        (o =
          (a =
            (l = n == null ? void 0 : n.firstWeekContainsDate) !== null && l !== void 0
              ? l
              : n == null || (d = n.locale) === null || d === void 0 || (f = d.options) === null || f === void 0
              ? void 0
              : f.firstWeekContainsDate) !== null && a !== void 0
            ? a
            : T.firstWeekContainsDate) !== null && o !== void 0
          ? o
          : (u = T.locale) === null || u === void 0 || (c = u.options) === null || c === void 0
          ? void 0
          : c.firstWeekContainsDate) !== null && i !== void 0
        ? i
        : 1
    )
  if (!(A >= 1 && A <= 7)) throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively")
  var D = un(
    (p =
      ($ =
        (b =
          (w = n == null ? void 0 : n.weekStartsOn) !== null && w !== void 0
            ? w
            : n == null || (g = n.locale) === null || g === void 0 || (k = g.options) === null || k === void 0
            ? void 0
            : k.weekStartsOn) !== null && b !== void 0
          ? b
          : T.weekStartsOn) !== null && $ !== void 0
        ? $
        : (M = T.locale) === null || M === void 0 || (_ = M.options) === null || _ === void 0
        ? void 0
        : _.weekStartsOn) !== null && p !== void 0
      ? p
      : 0
  )
  if (!(D >= 0 && D <= 6)) throw new RangeError("weekStartsOn must be between 0 and 6 inclusively")
  if (!v.localize) throw new RangeError("locale must contain localize property")
  if (!v.formatLong) throw new RangeError("locale must contain formatLong property")
  var Y = bt(e)
  if (!Bg(Y)) throw new RangeError("Invalid time value")
  var K = Hg(Y),
    G = Vg(Y, K),
    ue = { firstWeekContainsDate: A, weekStartsOn: D, locale: v, _originalDate: Y },
    xe = P.match(Qv)
      .map(function (ae) {
        var z = ae[0]
        if (z === "p" || z === "P") {
          var X = iv[z]
          return X(ae, v.formatLong)
        }
        return ae
      })
      .join("")
      .match(Gv)
      .map(function (ae) {
        if (ae === "''") return "'"
        var z = ae[0]
        if (z === "'") return ey(ae)
        var X = nv[z]
        if (X)
          return (
            !(n != null && n.useAdditionalWeekYearTokens) && uv(ae) && ba(ae, t, String(e)), !(n != null && n.useAdditionalDayOfYearTokens) && lv(ae) && ba(ae, t, String(e)), X(G, ae, v.localize, ue)
          )
        if (z.match(Zv)) throw new RangeError("Format string contains an unescaped latin alphabet character `" + z + "`")
        return ae
      })
      .join("")
  return xe
}
function ey(e) {
  var t = e.match(Jv)
  return t ? t[1].replace(Xv, "'") : e
}
function ty(e) {
  var t = e.default
  if (typeof t == "function") {
    var n = function () {
      return t.apply(this, arguments)
    }
    n.prototype = t.prototype
  } else n = {}
  return (
    Object.defineProperty(n, "__esModule", { value: !0 }),
    Object.keys(e).forEach(function (r) {
      var s = Object.getOwnPropertyDescriptor(e, r)
      Object.defineProperty(
        n,
        r,
        s.get
          ? s
          : {
              enumerable: !0,
              get: function () {
                return e[r]
              },
            }
      )
    }),
    n
  )
}
function ny(e) {
  throw new Error(
    'Could not dynamically require "' + e + '". Please configure the dynamicRequireTargets or/and ignoreDynamicRequires option of @rollup/plugin-commonjs appropriately for this require call to work.'
  )
}
var In = { exports: {} }
const ry = {},
  sy = Object.freeze(Object.defineProperty({ __proto__: null, default: ry }, Symbol.toStringTag, { value: "Module" })),
  iy = ty(sy)
var Eu = typeof process < "u" && process.pid ? process.pid.toString(36) : "",
  Su = ""
if (typeof __webpack_require__ != "function" && typeof ny < "u") {
  var Os = "",
    wa = iy
  if (wa.networkInterfaces) var Es = wa.networkInterfaces()
  if (Es) {
    e: for (let e in Es) {
      const t = Es[e],
        n = t.length
      for (var yn = 0; yn < n; yn++)
        if (t[yn] !== void 0 && t[yn].mac && t[yn].mac != "00:00:00:00:00:00") {
          Os = t[yn].mac
          break e
        }
    }
    Su = Os ? parseInt(Os.replace(/\:|\D+/gi, "")).toString(36) : ""
  }
}
In.exports = In.exports.default = function (e, t) {
  return (e || "") + Su + Eu + lr().toString(36) + (t || "")
}
In.exports.process = function (e, t) {
  return (e || "") + Eu + lr().toString(36) + (t || "")
}
In.exports.time = function (e, t) {
  return (e || "") + lr().toString(36) + (t || "")
}
function lr() {
  var e = Date.now(),
    t = lr.last || e
  return (lr.last = e > t ? e : t + 1)
}
const Yi = (e, t) => {
    const n = e.__vccOpts || e
    for (const [r, s] of t) n[r] = s
    return n
  },
  wt = (e) => (ll("data-v-8d1e7ec9"), (e = e()), ul(), e),
  oy = { class: "w-full flex items-center justify-between gap-2 py-1 registro" },
  ay = { class: "flex items-center justify-start gap-2 w-auto" },
  ly = wt(() => y("div", { class: "w-1 h-1 flex-none rounded-full card dot" }, null, -1)),
  uy = { class: "w-full" },
  cy = { class: "truncate capitalize" },
  fy = { class: "truncate" },
  dy = { class: "truncate" },
  py = { class: "truncate" },
  hy = { class: "w-16 items-center flex flex-none justify-center card p-1 rounded cursor-pointer" },
  my = { class: "w-16 items-center flex flex-none justify-center card p-1 rounded cursor-pointer" },
  gy = { class: "w-16 items-center flex flex-none justify-center card p-1 rounded cursor-pointer" },
  vy = { class: "w-6 flex items-center justify-center relative" },
  yy = wt(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-5 h-5" },
      [
        y("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          d: "M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z",
        }),
      ],
      -1
    )
  ),
  by = [yy],
  wy = { key: 0, class: "p-1 w-36 card shadow-lg rounded flex flex-col items-center justify-center absolute right-0 gap-1 z-50" },
  _y = wt(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-3 h-3" },
      [
        y("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          d: "M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0",
        }),
      ],
      -1
    )
  ),
  $y = wt(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-3 h-3" },
      [y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M6 18L18 6M6 6l12 12" })],
      -1
    )
  ),
  xy = { key: 0, class: "modal flex items-center justify-center" },
  ky = { class: "z-50 card p-2 rounded-lg flex flex-col items-center justify-start gap-2" },
  Cy = { key: 0, class: "modal flex flex-col items-center justify-center" },
  Py = { class: "z-50 card p-2 rounded-lg flex flex-col items-center justify-start gap-1 w-3/6 md:w-44 max-h-modal" },
  Oy = wt(() => y("h1", { class: "mb-2 text-xs" }, "Responsable", -1)),
  Ey = ["onClick"],
  Sy = { key: 0, class: "modal flex items-center justify-center" },
  Ay = { class: "z-50 card p-2 rounded-lg flex flex-col items-center justify-start gap-1 w-3/6 md:w-44" },
  Ty = { key: 0, class: "modal flex flex-col items-center justify-center" },
  My = { class: "z-50 bg-white dark:bg-black p-2 rounded-lg flex flex-col items-center justify-start gap-2 w-5/6 md:w-96 max-h-modal" },
  jy = wt(() => y("h1", { class: "mb-2 text-xs" }, "Comentarios", -1)),
  Ry = { class: "card p-2 rounded w-full" },
  Iy = { class: "text-justify" },
  Dy = { class: "flex items-center justify-between" },
  Fy = { class: "font-bold" },
  Ny = { key: 0, class: "modal flex items-center justify-center overflow-y-auto" },
  Ly = { class: "z-50 card p-2 rounded-lg flex flex-col md:flex-row items-start justify-start gap-2 w-full md:w-9/12 divide-x max-h-modal relative" },
  Uy = { class: "w-full md:w-1/2 px-2 overflow-y-auto flex flex-col items-start justify-start gap-2 relative" },
  Wy = { class: "w-full flex flex-col items-start justify-start sticky top-0 card" },
  Hy = wt(() => y("h3", null, "Antes", -1)),
  zy = { class: "flex items-center justify-start gap-2 relative" },
  By = wt(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-4 h-4" },
      [y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" })],
      -1
    )
  ),
  Vy = { class: "w-full flex flex-wrap gap-2" },
  qy = ["href"],
  Ky = ["src", "alt"],
  Yy = { class: "w-full md:w-1/2 px-2 overflow-y-auto flex flex-col items-start justify-start gap-2" },
  Gy = { class: "w-full flex flex-col items-start justify-start sticky top-0 card" },
  Qy = wt(() => y("h3", null, "Desp\xFAes", -1)),
  Jy = { class: "flex items-center justify-start gap-2 relative" },
  Xy = wt(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-4 h-4" },
      [y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" })],
      -1
    )
  ),
  Zy = { class: "w-full flex flex-wrap gap-2" },
  e0 = ["href"],
  t0 = ["src", "alt"],
  n0 = {
    __name: "Registrov1",
    props: { array: { type: Object, value: [] } },
    emits: ["obtenerAll"],
    setup(e, { emit: t }) {
      const n = e,
        r = ne({ menu: !1, modalResponsable: !1, modalEstado: !1, modalDescripcion: !1, modalComentarios: !1, modalMedia: !1 }),
        s = ne([]),
        i = ne(""),
        o = ne(""),
        a = async () => {
          s.value = []
          try {
            const u = { apartado: "auditorias", accion: "responsables", idDestino: n.array.idDestino, idUsuario: localStorage.getItem("usuario") },
              p = await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(u) })).json()
            p.response == "SUCCESS" && (s.value = p.data)
          } catch (u) {
            console.log(u)
          }
        },
        l = async () => {
          try {
            const u = {
              apartado: "auditorias",
              accion: "updateTarea",
              idDestino: localStorage.getItem("idDestino"),
              idUsuario: localStorage.getItem("usuario"),
              idTarea: n.array.idTarea,
              tarea: n.array.tarea,
              idResponsable: n.array.idResponsable,
              estado: n.array.estado,
              fechaAlta: n.array.fechaAlta,
              fechaCaducidad: n.array.fechaCaducidad,
              fechaSubsanacion: n.array.fechaSubsanacion,
              activo: n.array.activo,
            }
            ;(await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(u) })).json()).response == "SUCCESS" &&
              (t("obtenerAll"),
              (r.value.menu = !1),
              (r.value.modalResponsable = !1),
              (r.value.modalEstado = !1),
              (r.value.modalDescripcion = !1),
              (r.value.modalComentarios = !1),
              (r.value.modalMedia = !1))
          } catch (u) {
            console.log(u)
          }
        },
        d = async () => {
          if (!(o.value.length <= 1))
            try {
              const u = {
                apartado: "auditorias",
                accion: "addTareasComentarios",
                idDestino: localStorage.getItem("idDestino"),
                idUsuario: localStorage.getItem("usuario"),
                idTarea: n.array.idTarea,
                comentario: o.value,
                fechaCreado: Jr(new Date(), "yyyy-MM-dd KK:mm:ss"),
                activo: n.array.activo,
              }
              ;(await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(u) })).json()).response == "SUCCESS" && ((o.value = ""), t("obtenerAll"))
            } catch (u) {
              console.log(u)
            }
        },
        f = async (u, c) => {
          if (!!u.target.files[0])
            try {
              const p = u.target.files[0],
                $ = new FormData()
              $.append("apartado", "auditorias"),
                $.append("accion", "addTareasAdjuntos"),
                $.append("idDestino", localStorage.getItem("idDestino")),
                $.append("idUsuario", localStorage.getItem("usuario")),
                $.append("idAuditoriaTarea", n.array.idTarea),
                $.append("posicion", c),
                $.append("url", In.exports(In.exports())),
                $.append("descripcion", p.name),
                $.append("extension", p.type),
                $.append("file", p),
                $.append("fechaCreado", Jr(new Date(), "yyyy-MM-dd KK:mm:ss")),
                (await (await fetch("https://maphg.com/europa/api_auditorias/adjuntos.php", { method: "POST", body: $ })).json()).response == "SUCCESS" && t("obtenerAll")
            } catch (p) {
              console.log(p)
            }
        }
      return (u, c) => (
        U(),
        q("div", oy, [
          y("div", ay, [
            ly,
            y("div", uy, [
              y(
                "p",
                {
                  onClick:
                    c[0] ||
                    (c[0] = (p) => {
                      ;(r.value.modalDescripcion = !0), (i.value = e.array.tarea)
                    }),
                  class: "text-justify min-w-txt cursor-pointer",
                },
                _e(e.array.tarea),
                1
              ),
            ]),
            y(
              "div",
              {
                onClick:
                  c[1] ||
                  (c[1] = (p) => {
                    a(), (r.value.modalResponsable = !0)
                  }),
                class: "w-28 items-center flex flex-none justify-center p-1 card rounded cursor-pointer",
              },
              [y("p", cy, _e(e.array.responsable), 1)]
            ),
            y(
              "div",
              {
                onClick: c[2] || (c[2] = (p) => (r.value.modalEstado = !0)),
                class: es([
                  "w-28 items-center flex flex-none justify-center p-1 rounded cursor-pointer",
                  [
                    { "bg-yellow-400 text-yellow-800": e.array.estado === "En Proceso" },
                    { "bg-blue-400 text-blue-800": e.array.estado === "P. Proveedor" },
                    { "bg-red-400 text-red-800": e.array.estado === "P. Aprovaci\xF3n" },
                    { "bg-green-400 text-green-800": e.array.estado === "Finalizado" },
                  ],
                ]),
              },
              [y("p", fy, _e(e.array.estado), 1)],
              2
            ),
            y("div", { onClick: c[3] || (c[3] = (p) => (r.value.modalMedia = !0)), class: "w-12 items-center flex flex-none justify-center card p-1 rounded cursor-pointer" }, [
              y("p", dy, _e(e.array.adjuntosTotal), 1),
            ]),
            y("div", { onClick: c[4] || (c[4] = (p) => (r.value.modalComentarios = !0)), class: "w-12 items-center flex flex-none justify-center card p-1 rounded cursor-pointer" }, [
              y("p", py, _e(e.array.comentariosTotal), 1),
            ]),
            y("div", hy, [
              Ft(
                y(
                  "input",
                  { onChange: c[5] || (c[5] = (p) => l()), class: "text-xxs bg-transparent", type: "date", "onUpdate:modelValue": c[6] || (c[6] = (p) => (e.array.fechaAlta = p)) },
                  null,
                  544
                ),
                [[Lt, e.array.fechaAlta]]
              ),
            ]),
            y("div", my, [
              Ft(
                y(
                  "input",
                  { onChange: c[7] || (c[7] = (p) => l()), class: "text-xxs bg-transparent", type: "date", "onUpdate:modelValue": c[8] || (c[8] = (p) => (e.array.fechaCaducidad = p)) },
                  null,
                  544
                ),
                [[Lt, e.array.fechaCaducidad]]
              ),
            ]),
            y("div", gy, [
              Ft(
                y(
                  "input",
                  { onChange: c[9] || (c[9] = (p) => l()), class: "text-xxs bg-transparent", type: "date", "onUpdate:modelValue": c[10] || (c[10] = (p) => (e.array.fechaSubsanacion = p)) },
                  null,
                  544
                ),
                [[Lt, e.array.fechaSubsanacion]]
              ),
            ]),
          ]),
          y("div", vy, [
            y("button", { onClick: c[11] || (c[11] = (p) => (r.value.menu = !0)), class: "rounded-full w-5 h-5 p-0 flex flex-none items-center justify-center text-current" }, by),
            r.value.menu
              ? (U(),
                q("div", wy, [
                  y(
                    "button",
                    {
                      onClick:
                        c[12] ||
                        (c[12] = (p) => {
                          ;(e.array.activo = 0), l()
                        }),
                      class: "w-full flex items-center justify-start gap-2",
                    },
                    [_y, ht(" Eliminar tarea ")]
                  ),
                  y("button", { onClick: c[13] || (c[13] = (p) => (r.value.menu = !1)), class: "w-full flex items-center justify-start gap-2" }, [$y, ht(" Cancelar ")]),
                ]))
              : ve("", !0),
          ]),
          (U(),
          Ge(Nt, { to: "body" }, [
            r.value.modalDescripcion
              ? (U(),
                q("div", xy, [
                  y("div", ky, [
                    Ft(y("textarea", { "onUpdate:modelValue": c[14] || (c[14] = (p) => (i.value = p)), cols: "30", rows: "10", class: "bg-transparent" }, null, 512), [[Lt, i.value]]),
                    y(
                      "button",
                      {
                        onClick:
                          c[15] ||
                          (c[15] = (p) => {
                            ;(e.array.tarea = i.value), l()
                          }),
                      },
                      " Guardar Cambios "
                    ),
                  ]),
                  y("div", { onClick: c[16] || (c[16] = (p) => (r.value.modalDescripcion = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                ]))
              : ve("", !0),
          ])),
          (U(),
          Ge(Nt, { to: "body" }, [
            r.value.modalResponsable
              ? (U(),
                q("div", Cy, [
                  y("div", Py, [
                    Oy,
                    (U(!0),
                    q(
                      Pe,
                      null,
                      Ut(
                        s.value,
                        (p) => (
                          U(),
                          q(
                            "button",
                            {
                              onClick: ($) => {
                                ;(e.array.responsable = p.responsable), (e.array.idResponsable = p.idResponsable), l()
                              },
                              class: "w-full text-left flex-none capitalize",
                            },
                            _e(p.responsable),
                            9,
                            Ey
                          )
                        )
                      ),
                      256
                    )),
                  ]),
                  y("div", { onClick: c[17] || (c[17] = (p) => (r.value.modalResponsable = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                ]))
              : ve("", !0),
          ])),
          (U(),
          Ge(Nt, { to: "body" }, [
            r.value.modalEstado
              ? (U(),
                q("div", Sy, [
                  y("div", Ay, [
                    y(
                      "div",
                      {
                        onClick:
                          c[18] ||
                          (c[18] = (p) => {
                            ;(e.array.estado = "En Proceso"), l()
                          }),
                        class: "w-full text-xs self-stretch items-center flex flex-none justify-center p-2 rounded bg-yellow-400 text-yellow-800 cursor-pointer",
                      },
                      " En Proceso "
                    ),
                    y(
                      "div",
                      {
                        onClick:
                          c[19] ||
                          (c[19] = (p) => {
                            ;(e.array.estado = "P. Proveedor"), l()
                          }),
                        class: "w-full text-xs self-stretch items-center flex flex-none justify-center p-2 rounded bg-blue-400 text-blue-800 cursor-pointer",
                      },
                      " P. Proveedor "
                    ),
                    y(
                      "div",
                      {
                        onClick:
                          c[20] ||
                          (c[20] = (p) => {
                            ;(e.array.estado = "P. Aprovaci\xF3n"), l()
                          }),
                        class: "w-full text-xs self-stretch items-center flex flex-none justify-center p-2 rounded bg-red-400 text-red-800 cursor-pointer",
                      },
                      " P. Aprovaci\xF3n "
                    ),
                    y(
                      "div",
                      {
                        onClick:
                          c[21] ||
                          (c[21] = (p) => {
                            ;(e.array.estado = "Finalizado"), l()
                          }),
                        class: "w-full text-xs self-stretch items-center flex flex-none justify-center p-2 rounded bg-green-400 text-green-800 cursor-pointer",
                      },
                      " Finalizado "
                    ),
                  ]),
                  y("div", { onClick: c[22] || (c[22] = (p) => (r.value.modalEstado = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                ]))
              : ve("", !0),
          ])),
          (U(),
          Ge(Nt, { to: "body" }, [
            r.value.modalComentarios
              ? (U(),
                q("div", Ty, [
                  y("div", My, [
                    jy,
                    y("div", null, [
                      Ft(
                        y(
                          "input",
                          {
                            "onUpdate:modelValue": c[23] || (c[23] = (p) => (o.value = p)),
                            type: "text",
                            class: "card text-xs p-2 focus:outline-none rounded mr-2 w-full md:w-auto",
                            placeholder: "A\xF1adir comentario....",
                            onKeyup: c[24] || (c[24] = Ol((p) => d(), ["enter"])),
                          },
                          null,
                          544
                        ),
                        [[Lt, o.value]]
                      ),
                      y("button", { onClick: c[25] || (c[25] = (p) => d()), class: "w-full mt-2 md:mt-0 md:w-auto" }, "Enviar"),
                    ]),
                    (U(!0),
                    q(
                      Pe,
                      null,
                      Ut(e.array.comentarios, (p) => (U(), q("div", Ry, [y("p", Iy, _e(p.comentario), 1), y("div", Dy, [y("p", Fy, _e(p.creadoPor), 1), y("p", null, _e(p.fechaCreado), 1)])]))),
                      256
                    )),
                  ]),
                  y("div", { onClick: c[26] || (c[26] = (p) => (r.value.modalComentarios = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                ]))
              : ve("", !0),
          ])),
          (U(),
          Ge(Nt, { to: "body" }, [
            r.value.modalMedia
              ? (U(),
                q("div", Ny, [
                  y("div", Ly, [
                    y("div", Uy, [
                      y("div", Wy, [
                        Hy,
                        y("button", zy, [By, y("input", { class: "w-full absolute left-0 opacity-0", type: "file", onChange: c[27] || (c[27] = (p) => f(p, "ANTES")) }, null, 32), ht(" A\xF1adir ")]),
                      ]),
                      y("div", Vy, [
                        (U(!0),
                        q(
                          Pe,
                          null,
                          Ut(
                            e.array.adjuntos,
                            (p, $) => (
                              U(),
                              q(
                                "a",
                                { href: p.url, target: "_blank" },
                                [p.posicion == "ANTES" ? (U(), q("img", { class: "w-12 h-12 md:w-24 md:h-24 cursor-pointer", key: $, src: p.url, alt: p.descripcion }, null, 8, Ky)) : ve("", !0)],
                                8,
                                qy
                              )
                            )
                          ),
                          256
                        )),
                      ]),
                    ]),
                    y("div", Yy, [
                      y("div", Gy, [
                        Qy,
                        y("button", Jy, [
                          Xy,
                          ht(" A\xF1adir "),
                          y("input", { class: "w-full absolute left-0 opacity-0", type: "file", onChange: c[28] || (c[28] = (p) => f(p, "DESPUES")) }, null, 32),
                        ]),
                      ]),
                      y("div", Zy, [
                        (U(!0),
                        q(
                          Pe,
                          null,
                          Ut(
                            e.array.adjuntos,
                            (p, $) => (
                              U(),
                              q(
                                "a",
                                { href: p.url, target: "_blank" },
                                [p.posicion == "DESPUES" ? (U(), q("img", { class: "w-12 h-12 md:w-24 md:h-24 cursor-pointer", key: $, src: p.url, alt: p.descripcion }, null, 8, t0)) : ve("", !0)],
                                8,
                                e0
                              )
                            )
                          ),
                          256
                        )),
                      ]),
                    ]),
                  ]),
                  y("div", { onClick: c[29] || (c[29] = (p) => (r.value.modalMedia = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                ]))
              : ve("", !0),
          ])),
        ])
      )
    },
  },
  r0 = Yi(n0, [["__scopeId", "data-v-8d1e7ec9"]])
const s0 = {},
  i0 = { class: "w-full flex items-center justify-between gap-2 font-light bg-neutral-50 dark:bg-transparent" },
  o0 = Ai(
    '<div class="flex items-center justify-start gap-2 w-auto" data-v-5073c991><div class="w-1 h-1 flex-none rounded-full" data-v-5073c991></div><div class="self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="min-w-txt truncate text-center" data-v-5073c991>Descripci\xF3n</p></div><div class="w-28 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>Responsable</p></div><div class="w-28 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>Estado</p></div><div class="w-12 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>Media</p></div><div class="w-12 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>Comentarios</p></div><div class="w-16 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>F. Alta</p></div><div class="w-16 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>F. Caducidad</p></div><div class="w-16 self-stretch items-center flex flex-none justify-center" data-v-5073c991><p class="truncate" data-v-5073c991>F. Subsanaci\xF3n</p></div></div><div class="w-5" data-v-5073c991></div>',
    2
  ),
  a0 = [o0]
function l0(e, t) {
  return U(), q("div", i0, a0)
}
const u0 = Yi(s0, [
    ["render", l0],
    ["__scopeId", "data-v-5073c991"],
  ]),
  c0 = { class: "w-full flex items-center justify-start gap-1 cursor-pointer" },
  f0 = { key: 0 },
  d0 = y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M19.5 8.25l-7.5 7.5-7.5-7.5" }, null, -1),
  p0 = [d0],
  h0 = y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M8.25 4.5l7.5 7.5-7.5 7.5" }, null, -1),
  m0 = [h0],
  g0 = { key: 1, xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-3 h-3" },
  v0 = y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M18 12H6" }, null, -1),
  y0 = [v0],
  b0 = { class: "h-7 flex items-center justify-between gap-2 w-full" },
  w0 = { class: "truncate uppercase font-semibold" },
  _0 = { class: "flex items-center justify-between gap-2" },
  $0 = { key: 0, class: "flex flex-col items-center justify-center text-xxs" },
  x0 = { class: "w-24 flex-none flex items-center justify-start bg-neutral-200 dark:bg-neutral-700 rounded-xl gap-1" },
  k0 = { class: "relative flex items-center justify-center" },
  C0 = y(
    "svg",
    { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-6 h-6" },
    [
      y("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        d: "M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z",
      }),
    ],
    -1
  ),
  P0 = [C0],
  O0 = { key: 0, class: "p-1 w-36 z-50 card shadow-lg rounded flex flex-col items-center justify-center absolute right-1/2 gap-1" },
  E0 = y(
    "svg",
    { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-3 h-3" },
    [
      y("path", {
        "stroke-linecap": "round",
        "stroke-linejoin": "round",
        d: "M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0",
      }),
    ],
    -1
  ),
  S0 = y(
    "svg",
    { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-3 h-3" },
    [y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M12 4.5v15m7.5-7.5h-15" })],
    -1
  ),
  A0 = y(
    "svg",
    { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-3 h-3" },
    [y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M6 18L18 6M6 6l12 12" })],
    -1
  ),
  T0 = { key: 0, class: "w-full flex flex-col items-start justify-center gap-0 ml-3 overflow-auto pb-2" },
  M0 = { key: 0, class: "modal flex items-center justify-center" },
  j0 = { class: "z-50 bg-white dark:bg-black p-2 rounded-lg flex flex-col items-center justify-start gap-2" },
  R0 = y("p", null, "A\xF1adir nueva tarea", -1),
  I0 = {
    __name: "Grupo",
    props: { array: { type: Object, value: [] } },
    emits: ["obtenerAll"],
    setup(e, { emit: t }) {
      const n = e,
        r = ne(!1),
        s = ne(!1),
        i = ne(!1),
        o = ne(""),
        a = async () => {
          if (!(o.value.length <= 1))
            try {
              const u = {
                apartado: "auditorias",
                accion: "addTarea",
                idDestino: localStorage.getItem("idDestino"),
                idUsuario: localStorage.getItem("usuario"),
                idAuditoria: n.array.idGrupo,
                descripcion: o.value,
                idResponsable: 1,
                estado: "En Proceso",
                fechaAlta: "",
                fechaCaducidad: "",
                fechaSubsanacion: "",
                fechaCreado: Jr(new Date(), "yyyy-MM-dd KK:mm:ss"),
              }
              ;(await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(u) })).json()).response == "SUCCESS" &&
                ((o.value = ""), (i.value = !1), t("obtenerAll"))
            } catch (u) {
              console.log(u)
            }
        },
        l = async () => {
          try {
            const u = {
              apartado: "auditorias",
              accion: "updateGrupo",
              idDestino: localStorage.getItem("idDestino"),
              idUsuario: localStorage.getItem("usuario"),
              idAuditoria: n.array.idGrupo,
              descripcion: n.array.grupo,
              idResponsable: 1,
              activo: n.array.activo,
            }
            ;(await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(u) })).json()).response == "SUCCESS" &&
              ((o.value = ""), (i.value = !1), t("obtenerAll"))
          } catch (u) {
            console.log(u)
          }
        },
        d = (u, c) => {
          if ((localStorage.getItem("openGroups") || localStorage.setItem("openGroups", "0"), localStorage.getItem("openGroups"))) {
            let p = localStorage.getItem("openGroups").split(",")
            ;(p = p.filter(function ($) {
              return $ != u
            })),
              c && p.push(u),
              localStorage.setItem("openGroups", p.toString())
          }
        }
      return (
        (() => {
          localStorage.getItem("openGroups") &&
            localStorage
              .getItem("openGroups")
              .split(",")
              .forEach((u) => {
                u == n.array.idGrupo && (r.value = !0)
              })
        })(),
        (u, c) => (
          U(),
          q(
            Pe,
            null,
            [
              y("div", c0, [
                e.array.tareas.length
                  ? (U(),
                    q("div", f0, [
                      r.value
                        ? (U(),
                          q(
                            "svg",
                            {
                              key: 0,
                              onClick:
                                c[0] ||
                                (c[0] = (p) => {
                                  ;(r.value = !r.value), d(e.array.idGrupo, r.value)
                                }),
                              xmlns: "http://www.w3.org/2000/svg",
                              fill: "none",
                              viewBox: "0 0 24 24",
                              "stroke-width": "1.5",
                              stroke: "currentColor",
                              class: "w-4 h-4 rounded-full flex-none",
                              s: "",
                            },
                            p0
                          ))
                        : (U(),
                          q(
                            "svg",
                            {
                              key: 1,
                              onClick:
                                c[1] ||
                                (c[1] = (p) => {
                                  ;(r.value = !r.value), d(e.array.idGrupo, r.value)
                                }),
                              xmlns: "http://www.w3.org/2000/svg",
                              fill: "none",
                              viewBox: "0 0 24 24",
                              "stroke-width": "1.5",
                              stroke: "currentColor",
                              class: "w-4 h-4 rounded-full flex-none",
                            },
                            m0
                          )),
                    ]))
                  : (U(), q("svg", g0, y0)),
                y("div", b0, [
                  y(
                    "div",
                    {
                      onClick:
                        c[2] ||
                        (c[2] = (p) => {
                          ;(r.value = !r.value), d(e.array.idGrupo, r.value)
                        }),
                      class: "self-stretch flex items-center justify-between gap-2 w-full",
                    },
                    [
                      y("p", w0, _e(e.array.grupo), 1),
                      y("div", _0, [
                        e.array.tareasTotal > 0 ? (U(), q("div", $0, [y("p", null, _e(e.array.tareasFinalizado) + " / " + _e(e.array.tareasTotal), 1)])) : ve("", !0),
                        y("div", x0, [
                          e.array.tareasFinalizado > 0
                            ? (U(), q("div", { key: 0, style: tt({ width: e.array.tareasTotalPorcentaje * e.array.tareasFinalizado + "%" }), class: "h-full bg-green-400 p-0.5 rounded-lg" }, null, 4))
                            : ve("", !0),
                          e.array.tareasEnProceso > 0
                            ? (U(), q("div", { key: 1, style: tt({ width: e.array.tareasTotalPorcentaje * e.array.tareasEnProceso + "%" }), class: "h-full bg-yellow-400 p-0.5 rounded-lg" }, null, 4))
                            : ve("", !0),
                          e.array.tareasPAprovacion > 0
                            ? (U(), q("div", { key: 2, style: tt({ width: e.array.tareasTotalPorcentaje * e.array.tareasPAprovacion + "%" }), class: "h-full bg-red-400 p-0.5 rounded-lg" }, null, 4))
                            : ve("", !0),
                          e.array.tareasPProveedor > 0
                            ? (U(), q("div", { key: 3, style: tt({ width: e.array.tareasTotalPorcentaje * e.array.tareasPProveedor + "%" }), class: "h-full bg-blue-400 p-0.5 rounded-lg" }, null, 4))
                            : ve("", !0),
                        ]),
                      ]),
                    ]
                  ),
                  y("div", k0, [
                    y("button", { onClick: c[3] || (c[3] = (p) => (s.value = !0)), class: "rounded-full z-40 w-5 h-5 p-0 flex items-center justify-center text-current" }, P0),
                    s.value
                      ? (U(),
                        q("div", O0, [
                          y(
                            "button",
                            {
                              onClick:
                                c[4] ||
                                (c[4] = (p) => {
                                  ;(e.array.activo = 0), l()
                                }),
                              class: "w-full flex items-center justify-start gap-2",
                            },
                            [E0, ht(" Eliminar grupo ")]
                          ),
                          y(
                            "button",
                            {
                              onClick:
                                c[5] ||
                                (c[5] = (p) => {
                                  ;(i.value = !0), (s.value = !1)
                                }),
                              class: "w-full flex items-center justify-start gap-2",
                            },
                            [S0, ht(" A\xF1adir tarea ")]
                          ),
                          y("button", { onClick: c[6] || (c[6] = (p) => (s.value = !1)), class: "w-full flex items-center justify-start gap-2" }, [A0, ht(" Cancelar ")]),
                        ]))
                      : ve("", !0),
                  ]),
                ]),
              ]),
              r.value && e.array.tareas.length
                ? (U(),
                  q("div", T0, [
                    Re(u0),
                    (U(!0),
                    q(
                      Pe,
                      null,
                      Ut(e.array.tareas, (p, $) => (U(), Ge(r0, { key: $, array: p, onObtenerAll: c[7] || (c[7] = (b) => t("obtenerAll")) }, null, 8, ["array"]))),
                      128
                    )),
                  ]))
                : ve("", !0),
              (U(),
              Ge(Nt, { to: "body" }, [
                i.value
                  ? (U(),
                    q("div", M0, [
                      y("div", j0, [
                        R0,
                        Ft(
                          y(
                            "input",
                            {
                              "onUpdate:modelValue": c[8] || (c[8] = (p) => (o.value = p)),
                              onKeyup: c[9] || (c[9] = Ol((p) => a(), ["enter"])),
                              type: "text",
                              class: "card text-xs focus:outline-none p-2",
                              "w-full": "",
                              placeholder: "Describa la tarea...",
                            },
                            null,
                            544
                          ),
                          [[Lt, o.value]]
                        ),
                        y("button", { onClick: c[10] || (c[10] = (p) => a()), class: "w-full text-xs" }, "A\xF1adir"),
                        y("button", { onClick: c[11] || (c[11] = (p) => (i.value = !1)), class: "w-full text-xs" }, "Cancelar"),
                      ]),
                      y("div", { onClick: c[12] || (c[12] = (p) => (i.value = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                    ]))
                  : ve("", !0),
              ])),
            ],
            64
          )
        )
      )
    },
  }
var _a
const Au = typeof window < "u",
  D0 = (e) => typeof e == "function",
  F0 = (e) => typeof e == "string",
  Ss = () => {}
Au && ((_a = window == null ? void 0 : window.navigator) == null ? void 0 : _a.userAgent) && /iP(ad|hone|od)/.test(window.navigator.userAgent)
function Xr(e) {
  return typeof e == "function" ? e() : gt(e)
}
function N0(e, t) {
  function n(...r) {
    e(() => t.apply(this, r), { fn: t, thisArg: this, args: r })
  }
  return n
}
const Tu = (e) => e()
function L0(e = Tu) {
  const t = ne(!0)
  function n() {
    t.value = !1
  }
  function r() {
    t.value = !0
  }
  return {
    isActive: t,
    pause: n,
    resume: r,
    eventFilter: (...i) => {
      t.value && e(...i)
    },
  }
}
function U0(e) {
  return e
}
function Mu(e) {
  return Xu() ? (Zu(e), !0) : !1
}
function W0(e) {
  return typeof e == "function" ? ke(e) : ne(e)
}
function ju(e, t = !0) {
  Mi() ? pl(e) : t ? e() : as(e)
}
function H0(e = !1, t = {}) {
  const { truthyValue: n = !0, falsyValue: r = !1 } = t,
    s = $e(e),
    i = ne(e)
  function o(a) {
    if (arguments.length) return (i.value = a), i.value
    {
      const l = Xr(n)
      return (i.value = i.value === l ? Xr(r) : l), i.value
    }
  }
  return s ? o : [i, o]
}
var $a = Object.getOwnPropertySymbols,
  z0 = Object.prototype.hasOwnProperty,
  B0 = Object.prototype.propertyIsEnumerable,
  V0 = (e, t) => {
    var n = {}
    for (var r in e) z0.call(e, r) && t.indexOf(r) < 0 && (n[r] = e[r])
    if (e != null && $a) for (var r of $a(e)) t.indexOf(r) < 0 && B0.call(e, r) && (n[r] = e[r])
    return n
  }
function q0(e, t, n = {}) {
  const r = n,
    { eventFilter: s = Tu } = r,
    i = V0(r, ["eventFilter"])
  return Ve(e, N0(s, t), i)
}
var K0 = Object.defineProperty,
  Y0 = Object.defineProperties,
  G0 = Object.getOwnPropertyDescriptors,
  Zr = Object.getOwnPropertySymbols,
  Ru = Object.prototype.hasOwnProperty,
  Iu = Object.prototype.propertyIsEnumerable,
  xa = (e, t, n) => (t in e ? K0(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n)),
  Q0 = (e, t) => {
    for (var n in t || (t = {})) Ru.call(t, n) && xa(e, n, t[n])
    if (Zr) for (var n of Zr(t)) Iu.call(t, n) && xa(e, n, t[n])
    return e
  },
  J0 = (e, t) => Y0(e, G0(t)),
  X0 = (e, t) => {
    var n = {}
    for (var r in e) Ru.call(e, r) && t.indexOf(r) < 0 && (n[r] = e[r])
    if (e != null && Zr) for (var r of Zr(e)) t.indexOf(r) < 0 && Iu.call(e, r) && (n[r] = e[r])
    return n
  }
function Z0(e, t, n = {}) {
  const r = n,
    { eventFilter: s } = r,
    i = X0(r, ["eventFilter"]),
    { eventFilter: o, pause: a, resume: l, isActive: d } = L0(s)
  return { stop: q0(e, t, J0(Q0({}, i), { eventFilter: o })), pause: a, resume: l, isActive: d }
}
function eb(e) {
  var t
  const n = Xr(e)
  return (t = n == null ? void 0 : n.$el) != null ? t : n
}
const Dn = Au ? window : void 0
function tb(...e) {
  let t, n, r, s
  if ((F0(e[0]) ? (([n, r, s] = e), (t = Dn)) : ([t, n, r, s] = e), !t)) return Ss
  let i = Ss
  const o = Ve(
      () => eb(t),
      (l) => {
        i(),
          l &&
            (l.addEventListener(n, r, s),
            (i = () => {
              l.removeEventListener(n, r, s), (i = Ss)
            }))
      },
      { immediate: !0, flush: "post" }
    ),
    a = () => {
      o(), i()
    }
  return Mu(a), a
}
function nb(e, t = !1) {
  const n = ne(),
    r = () => (n.value = Boolean(e()))
  return r(), ju(r, t), n
}
function rb(e, t = {}) {
  const { window: n = Dn } = t,
    r = nb(() => n && "matchMedia" in n && typeof n.matchMedia == "function")
  let s
  const i = ne(!1),
    o = () => {
      !s || ("removeEventListener" in s ? s.removeEventListener("change", a) : s.removeListener(a))
    },
    a = () => {
      !r.value || (o(), (s = n.matchMedia(W0(e).value)), (i.value = s.matches), "addEventListener" in s ? s.addEventListener("change", a) : s.addListener(a))
    }
  return xt(a), Mu(() => o()), i
}
const oi = typeof globalThis < "u" ? globalThis : typeof window < "u" ? window : typeof global < "u" ? global : typeof self < "u" ? self : {},
  ai = "__vueuse_ssr_handlers__"
oi[ai] = oi[ai] || {}
const sb = oi[ai]
function Du(e, t) {
  return sb[e] || t
}
function ib(e) {
  return e == null
    ? "any"
    : e instanceof Set
    ? "set"
    : e instanceof Map
    ? "map"
    : e instanceof Date
    ? "date"
    : typeof e == "boolean"
    ? "boolean"
    : typeof e == "string"
    ? "string"
    : typeof e == "object" || Array.isArray(e)
    ? "object"
    : Number.isNaN(e)
    ? "any"
    : "number"
}
var ob = Object.defineProperty,
  ka = Object.getOwnPropertySymbols,
  ab = Object.prototype.hasOwnProperty,
  lb = Object.prototype.propertyIsEnumerable,
  Ca = (e, t, n) => (t in e ? ob(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n)),
  Pa = (e, t) => {
    for (var n in t || (t = {})) ab.call(t, n) && Ca(e, n, t[n])
    if (ka) for (var n of ka(t)) lb.call(t, n) && Ca(e, n, t[n])
    return e
  }
const ub = {
  boolean: { read: (e) => e === "true", write: (e) => String(e) },
  object: { read: (e) => JSON.parse(e), write: (e) => JSON.stringify(e) },
  number: { read: (e) => Number.parseFloat(e), write: (e) => String(e) },
  any: { read: (e) => e, write: (e) => String(e) },
  string: { read: (e) => e, write: (e) => String(e) },
  map: { read: (e) => new Map(JSON.parse(e)), write: (e) => JSON.stringify(Array.from(e.entries())) },
  set: { read: (e) => new Set(JSON.parse(e)), write: (e) => JSON.stringify(Array.from(e)) },
  date: { read: (e) => new Date(e), write: (e) => e.toISOString() },
}
function cb(e, t, n, r = {}) {
  var s
  const {
      flush: i = "pre",
      deep: o = !0,
      listenToStorageChanges: a = !0,
      writeDefaults: l = !0,
      mergeDefaults: d = !1,
      shallow: f,
      window: u = Dn,
      eventFilter: c,
      onError: p = (v) => {
        console.error(v)
      },
    } = r,
    $ = (f ? Za : ne)(t)
  if (!n)
    try {
      n = Du("getDefaultStorage", () => {
        var v
        return (v = Dn) == null ? void 0 : v.localStorage
      })()
    } catch (v) {
      p(v)
    }
  if (!n) return $
  const b = Xr(t),
    w = ib(b),
    g = (s = r.serializer) != null ? s : ub[w],
    { pause: k, resume: M } = Z0($, () => _($.value), { flush: i, deep: o, eventFilter: c })
  return u && a && tb(u, "storage", T), T(), $
  function _(v) {
    try {
      v == null ? n.removeItem(e) : n.setItem(e, g.write(v))
    } catch (A) {
      p(A)
    }
  }
  function P(v) {
    if (!(v && v.key !== e)) {
      k()
      try {
        const A = v ? v.newValue : n.getItem(e)
        if (A == null) return l && b !== null && n.setItem(e, g.write(b)), b
        if (!v && d) {
          const D = g.read(A)
          return D0(d) ? d(D, b) : w === "object" && !Array.isArray(D) ? Pa(Pa({}, b), D) : D
        } else return typeof A != "string" ? A : g.read(A)
      } catch (A) {
        p(A)
      } finally {
        M()
      }
    }
  }
  function T(v) {
    ;(v && v.key !== e) || ($.value = P(v))
  }
}
function Fu(e) {
  return rb("(prefers-color-scheme: dark)", e)
}
var fb = Object.defineProperty,
  Oa = Object.getOwnPropertySymbols,
  db = Object.prototype.hasOwnProperty,
  pb = Object.prototype.propertyIsEnumerable,
  Ea = (e, t, n) => (t in e ? fb(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n)),
  hb = (e, t) => {
    for (var n in t || (t = {})) db.call(t, n) && Ea(e, n, t[n])
    if (Oa) for (var n of Oa(t)) pb.call(t, n) && Ea(e, n, t[n])
    return e
  }
function mb(e = {}) {
  const {
      selector: t = "html",
      attribute: n = "class",
      initialValue: r = "auto",
      window: s = Dn,
      storage: i,
      storageKey: o = "vueuse-color-scheme",
      listenToStorageChanges: a = !0,
      storageRef: l,
      emitAuto: d,
    } = e,
    f = hb({ auto: "", light: "light", dark: "dark" }, e.modes || {}),
    u = Fu({ window: s }),
    c = ke(() => (u.value ? "dark" : "light")),
    p = l || (o == null ? ne(r) : cb(o, r, i, { window: s, listenToStorageChanges: a })),
    $ = ke({
      get() {
        return p.value === "auto" && !d ? c.value : p.value
      },
      set(k) {
        p.value = k
      },
    }),
    b = Du("updateHTMLAttrs", (k, M, _) => {
      const P = s == null ? void 0 : s.document.querySelector(k)
      if (!!P)
        if (M === "class") {
          const T = _.split(/\s/g)
          Object.values(f)
            .flatMap((v) => (v || "").split(/\s/g))
            .filter(Boolean)
            .forEach((v) => {
              T.includes(v) ? P.classList.add(v) : P.classList.remove(v)
            })
        } else P.setAttribute(M, _)
    })
  function w(k) {
    var M
    const _ = k === "auto" ? c.value : k
    b(t, n, (M = f[_]) != null ? M : _)
  }
  function g(k) {
    e.onChanged ? e.onChanged(k, w) : w(k)
  }
  return Ve($, g, { flush: "post", immediate: !0 }), d && Ve(c, () => g($.value), { flush: "post" }), ju(() => g($.value)), $
}
var gb = Object.defineProperty,
  vb = Object.defineProperties,
  yb = Object.getOwnPropertyDescriptors,
  Sa = Object.getOwnPropertySymbols,
  bb = Object.prototype.hasOwnProperty,
  wb = Object.prototype.propertyIsEnumerable,
  Aa = (e, t, n) => (t in e ? gb(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n)),
  _b = (e, t) => {
    for (var n in t || (t = {})) bb.call(t, n) && Aa(e, n, t[n])
    if (Sa) for (var n of Sa(t)) wb.call(t, n) && Aa(e, n, t[n])
    return e
  },
  $b = (e, t) => vb(e, yb(t))
function xb(e = {}) {
  const { valueDark: t = "dark", valueLight: n = "", window: r = Dn } = e,
    s = mb(
      $b(_b({}, e), {
        onChanged: (a, l) => {
          var d
          e.onChanged ? (d = e.onChanged) == null || d.call(e, a === "dark") : l(a)
        },
        modes: { dark: t, light: n },
      })
    ),
    i = Fu({ window: r })
  return ke({
    get() {
      return s.value === "dark"
    },
    set(a) {
      a === i.value ? (s.value = "auto") : (s.value = a ? "dark" : "light")
    },
  })
}
var Ta
;(function (e) {
  ;(e.UP = "UP"), (e.RIGHT = "RIGHT"), (e.DOWN = "DOWN"), (e.LEFT = "LEFT"), (e.NONE = "NONE")
})(Ta || (Ta = {}))
var kb = Object.defineProperty,
  Ma = Object.getOwnPropertySymbols,
  Cb = Object.prototype.hasOwnProperty,
  Pb = Object.prototype.propertyIsEnumerable,
  ja = (e, t, n) => (t in e ? kb(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n)),
  Ob = (e, t) => {
    for (var n in t || (t = {})) Cb.call(t, n) && ja(e, n, t[n])
    if (Ma) for (var n of Ma(t)) Pb.call(t, n) && ja(e, n, t[n])
    return e
  }
const Eb = {
  easeInSine: [0.12, 0, 0.39, 0],
  easeOutSine: [0.61, 1, 0.88, 1],
  easeInOutSine: [0.37, 0, 0.63, 1],
  easeInQuad: [0.11, 0, 0.5, 0],
  easeOutQuad: [0.5, 1, 0.89, 1],
  easeInOutQuad: [0.45, 0, 0.55, 1],
  easeInCubic: [0.32, 0, 0.67, 0],
  easeOutCubic: [0.33, 1, 0.68, 1],
  easeInOutCubic: [0.65, 0, 0.35, 1],
  easeInQuart: [0.5, 0, 0.75, 0],
  easeOutQuart: [0.25, 1, 0.5, 1],
  easeInOutQuart: [0.76, 0, 0.24, 1],
  easeInQuint: [0.64, 0, 0.78, 0],
  easeOutQuint: [0.22, 1, 0.36, 1],
  easeInOutQuint: [0.83, 0, 0.17, 1],
  easeInExpo: [0.7, 0, 0.84, 0],
  easeOutExpo: [0.16, 1, 0.3, 1],
  easeInOutExpo: [0.87, 0, 0.13, 1],
  easeInCirc: [0.55, 0, 1, 0.45],
  easeOutCirc: [0, 0.55, 0.45, 1],
  easeInOutCirc: [0.85, 0, 0.15, 1],
  easeInBack: [0.36, 0, 0.66, -0.56],
  easeOutBack: [0.34, 1.56, 0.64, 1],
  easeInOutBack: [0.68, -0.6, 0.32, 1.6],
}
Ob({ linear: U0 }, Eb)
const Sb = { class: "navbar px-4 md:px-16 z-50" },
  Ab = y(
    "div",
    { class: "flex items-center gap-2" },
    [y("h3", { class: "font-semibold" }, "MAPHG"), y("h4", { class: "text-xxs font-semibold rounded p-1 border border-black dark:border-white" }, "Auditor\xEDas")],
    -1
  ),
  Tb = { class: "flex items-center gap-2" },
  Mb = {
    key: 0,
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    fill: "none",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    class: "icono feather feather-sun",
  },
  jb = Ai(
    '<circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>',
    9
  ),
  Rb = [jb],
  Ib = {
    key: 1,
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    fill: "none",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    class: "icono feather feather-moon",
  },
  Db = y("path", { d: "M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" }, null, -1),
  Fb = [Db],
  Nb = y(
    "svg",
    {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 24 24",
      fill: "none",
      stroke: "currentColor",
      "stroke-width": "2",
      "stroke-linecap": "round",
      "stroke-linejoin": "round",
      class: "feather feather-globe icono",
    },
    [
      y("circle", { cx: "12", cy: "12", r: "10" }),
      y("line", { x1: "2", y1: "12", x2: "22", y2: "12" }),
      y("path", { d: "M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" }),
    ],
    -1
  ),
  Lb = { class: "font-semibold" },
  Ub = y(
    "button",
    null,
    [
      y(
        "svg",
        {
          xmlns: "http://www.w3.org/2000/svg",
          viewBox: "0 0 24 24",
          fill: "none",
          stroke: "currentColor",
          "stroke-width": "2",
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          class: "feather feather-menu icono",
        },
        [y("line", { x1: "3", y1: "12", x2: "21", y2: "12" }), y("line", { x1: "3", y1: "6", x2: "21", y2: "6" }), y("line", { x1: "3", y1: "18", x2: "21", y2: "18" })]
      ),
    ],
    -1
  ),
  Wb = { key: 0, class: "modal flex items-center justify-center" },
  Hb = { class: "z-50 card p-2 rounded-lg flex flex-col items-center justify-start gap-1 w-auto md:w-auto" },
  zb = { class: "w-full" },
  Bb = { key: 0, class: "w-full" },
  Vb = ["onClick"],
  qb = { key: 1 },
  Kb = { class: "w-full text-left" },
  Yb = ["onClick"],
  Gb = ["onClick"],
  Qb = {
    __name: "Navbar3r",
    emits: ["obtenerAll", "destinoSeleccionado"],
    setup(e, { emit: t }) {
      const n = xb(),
        r = H0(n),
        s = ne(!1),
        i = ne(""),
        o = ne([]),
        a = (d) => {
          localStorage.setItem("idDestino", d), t("obtenerAll")
        }
      return (
        (async () => {
          try {
            const d = { idUsuario: localStorage.getItem("usuario"), idDestino: localStorage.getItem("idDestino"), apartado: "auditorias", accion: "sesion" },
              u = await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(d) })).json()
            u.response == "SUCCESS" &&
              ((o.value = u.data.menuDestinos),
              u.data.destinosPermitidos.forEach((c) => {
                c.idDestino == localStorage.getItem("idDestino") && ((i.value = c.ubicacion), t("destinoSeleccionado", c.ubicacion))
              }))
          } catch (d) {
            ;(o.value = []), console.log(d)
          }
        })(),
        (d, f) => (
          U(),
          q(
            Pe,
            null,
            [
              y("div", Sb, [
                Ab,
                y("div", Tb, [
                  y("button", { onClick: f[0] || (f[0] = (u) => gt(r)()) }, [gt(n) ? (U(), q("svg", Mb, Rb)) : (U(), q("svg", Ib, Fb))]),
                  y("button", { onClick: f[1] || (f[1] = (u) => (s.value = !0)), class: "flex items-center gap-2" }, [Nb, y("h4", Lb, _e(i.value), 1)]),
                  Ub,
                ]),
              ]),
              (U(),
              Ge(Nt, { to: "body" }, [
                s.value
                  ? (U(),
                    q("div", Wb, [
                      y("div", Hb, [
                        (U(!0),
                        q(
                          Pe,
                          null,
                          Ut(
                            o.value,
                            (u, c) => (
                              U(),
                              q("div", zb, [
                                c == "AA_princial"
                                  ? (U(),
                                    q("div", Bb, [
                                      y(
                                        "button",
                                        { onClick: (p) => (a(u[0].idDestino), (i.value = u[0].ubicacion), (s.value = !1), d.$emit("destinoSeleccionado", u[0].ubicacion)), class: "w-full" },
                                        _e(u[0].ubicacion),
                                        9,
                                        Vb
                                      ),
                                    ]))
                                  : ve("", !0),
                                c != "AA_princial" && c != "" ? (U(), q("div", qb, [y("button", Kb, _e(c), 1)])) : ve("", !0),
                                (U(!0),
                                q(
                                  Pe,
                                  null,
                                  Ut(
                                    u,
                                    (p, $) => (
                                      U(),
                                      q("div", null, [
                                        c != "AA_princial" && c != ""
                                          ? (U(),
                                            q(
                                              "button",
                                              {
                                                key: 0,
                                                onClick: (b) => (a(p.idDestino), (i.value = p.ubicacion), (s.value = !1), d.$emit("destinoSeleccionado", p.ubicacion)),
                                                class: "w-full text-left",
                                              },
                                              _e(p.ubicacion),
                                              9,
                                              Yb
                                            ))
                                          : ve("", !0),
                                        c != "AA_princial" && c == ""
                                          ? (U(),
                                            q(
                                              "button",
                                              {
                                                key: 1,
                                                onClick: (b) => (a(p.idDestino), (i.value = p.ubicacion), (s.value = !1), d.$emit("destinoSeleccionado", p.ubicacion)),
                                                class: "w-full mb-1 text-left",
                                              },
                                              _e(p.ubicacion),
                                              9,
                                              Gb
                                            ))
                                          : ve("", !0),
                                      ])
                                    )
                                  ),
                                  256
                                )),
                              ])
                            )
                          ),
                          256
                        )),
                      ]),
                      y("div", { onClick: f[2] || (f[2] = (u) => (s.value = !1)), class: "absolute z-10 bg-black bg-opacity-50 w-full h-full" }),
                    ]))
                  : ve("", !0),
              ])),
            ],
            64
          )
        )
      )
    },
  }
const Ee = (e) => (ll("data-v-27c5319a"), (e = e()), ul(), e),
  Jb = { class: "flex flex-col items-start justify-center gap-2 p-2 w-full" },
  Xb = { class: "w-full md:w-3/5 xl:w-3/5 lg:w-3/5 flex flex-row items-center justify-between flex-wrap gap-2 self-center" },
  Zb = { class: "flex w-full sm:w-auto md:w-auto flex-col items-start justify-center flex-none" },
  e1 = { class: "leading-none font-bold" },
  t1 = Ee(() => y("h4", { class: "leading-none font-light" }, "Avance auditor\xEDa 2022", -1)),
  n1 = { class: "flex flex-col items-center justify-center self-stretch" },
  r1 = { class: "leading-none font-extralight" },
  s1 = Ee(() => y("h4", { class: "leading-none font-light" }, "Actividades", -1)),
  i1 = { class: "flex flex-col items-start justify-center self-stretch" },
  o1 = { class: "flex items-center gap-1" },
  a1 = Ee(() => y("div", { class: "w-2 h-2 rounded-sm bg-green-400" }, null, -1)),
  l1 = { class: "leading-none font-light" },
  u1 = { class: "flex items-center gap-1" },
  c1 = Ee(() => y("div", { class: "w-2 h-2 rounded-sm bg-yellow-400" }, null, -1)),
  f1 = { class: "leading-none font-light" },
  d1 = { class: "flex flex-col items-start justify-center self-stretch" },
  p1 = { class: "flex items-center gap-1" },
  h1 = Ee(() => y("div", { class: "w-2 h-2 rounded-sm bg-red-400" }, null, -1)),
  m1 = { class: "leading-none font-light" },
  g1 = { class: "flex items-center gap-1" },
  v1 = Ee(() => y("div", { class: "w-2 h-2 rounded-sm bg-blue-400" }, null, -1)),
  y1 = { class: "leading-none font-light" },
  b1 = { class: "w-full md:w-3/5 xl:w-3/5 lg:w-3/5 self-center flex items-center justify-start bg-neutral-100 dark:bg-neutral-700 p-1 rounded-xl overflow-hidden gap-1" },
  w1 = { class: "w-full md:w-3/5 xl:w-3/5 lg:w-3/5 self-center flex flex-wrap items-center justify-start bg-neutral-100 dark:bg-neutral-700 py-1 px-2 rounded-xl overflow-hidden gap-1" },
  _1 = { class: "flex justify-center items-center gap-2 w-full flex-wrap md:w-auto" },
  $1 = Ee(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-5 h-5 flex-none" },
      [
        y("path", {
          "stroke-linecap": "round",
          "stroke-linejoin": "round",
          d: "M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75",
        }),
      ],
      -1
    )
  ),
  x1 = Ee(() => y("input", { checked: "", type: "radio", name: "Filtrado", class: "flex-none checked:bg-purple-500 checked:border-purple-300", id: "Todo", value: "Todo" }, null, -1)),
  k1 = Ee(() => y("label", { class: "text-xxs", for: "Todo" }, "Todo", -1)),
  C1 = [x1, k1],
  P1 = Ee(() => y("input", { type: "radio", name: "Filtrado", class: "flex-none checked:bg-green-500 checked:border-green-300", id: "Finalizado", value: "Finalizado" }, null, -1)),
  O1 = Ee(() => y("label", { class: "text-xxs", for: "Finalizado" }, "Finalizado", -1)),
  E1 = [P1, O1],
  S1 = Ee(() => y("input", { type: "radio", name: "Filtrado", class: "flex-none checked:bg-yellow-500 checked:border-yellow-300", id: "En Proceso", value: "En proceso" }, null, -1)),
  A1 = Ee(() => y("label", { class: "text-xxs", for: "En proceso" }, "En Proceso", -1)),
  T1 = [S1, A1],
  M1 = Ee(() => y("input", { type: "radio", name: "Filtrado", class: "flex-none checked:bg-red-500 checked:border-red-300", id: "P. Aprovaci\xF3n", value: "P. aprovaci\xF3n" }, null, -1)),
  j1 = Ee(() => y("label", { class: "text-xxs", for: "P. aprovaci\xF3n" }, "P. Aprovaci\xF3n", -1)),
  R1 = [M1, j1],
  I1 = Ee(() => y("input", { type: "radio", name: "Filtrado", class: "flex-none checked:bg-blue-500 checked:border-blue-300", id: "P. Proveedor", value: "P. proveedor" }, null, -1)),
  D1 = Ee(() => y("label", { class: "text-xxs", for: "P. proveedor" }, "P. Proveedor", -1)),
  F1 = [I1, D1],
  N1 = { class: "w-full md:w-3/5 xl:w-3/5 lg:w-3/5 self-center flex flex-wrap items-center justify-start p-2 rounded-xl gap-1 divide-y divide-gray-50 dark:divide-neutral-800" },
  L1 = { class: "flex gap-2 items-center justify-start flex-wrap" },
  U1 = Ee(() =>
    y(
      "svg",
      { xmlns: "http://www.w3.org/2000/svg", fill: "none", viewBox: "0 0 24 24", "stroke-width": "1.5", stroke: "currentColor", class: "w-4 h-4" },
      [y("path", { "stroke-linecap": "round", "stroke-linejoin": "round", d: "M12 4.5v15m7.5-7.5h-15" })],
      -1
    )
  ),
  W1 = Ai(
    '<button class="py-1 h-auto items-center flex gap-1 text-xxs" data-v-27c5319a><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" data-v-27c5319a><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" data-v-27c5319a></path></svg> Excel </button><button class="py-1 h-auto items-center flex gap-1 text-xxs" data-v-27c5319a><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" data-v-27c5319a><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" data-v-27c5319a></path></svg> Pdf </button><div class="relative inline-block w-10 flex-none align-middle select-none transition duration-200 ease-in" data-v-27c5319a><input checked type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-2 border-neutral-200 dark:border-neutral-800 appearance-none cursor-pointer" data-v-27c5319a><label for="toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-neutral-200 dark:bg-neutral-800 cursor-pointer" data-v-27c5319a></label></div><label for="toggle" class="text-xxs" data-v-27c5319a>Agrupar</label>',
    4
  ),
  H1 = { key: 0, class: "modal flex items-center justify-center" },
  z1 = { class: "z-50 bg-white dark:bg-black p-2 rounded-lg flex flex-col items-center justify-start gap-2" },
  B1 = Ee(() => y("p", null, "A\xF1adir nuevo grupo", -1)),
  V1 = {
    __name: "Home",
    setup(e) {
      const t = ne(!1),
        n = ne(""),
        r = (f) => {
          n.value = f
        },
        s = ne([]),
        i = ne({ tareasTotalGlobal: 0, tareasTotalPorcentajeGlobal: 0, tareasEnProcesoGlobal: 0, tareasPProveedorGlobal: 0, tareasPAprovacionGlobal: 0, tareasFinalizadoGlobal: 0 }),
        o = ne(""),
        a = ne({ palabra: "", estado: "" }),
        l = async () => {
          try {
            const f = {
                idDestino: localStorage.getItem("idDestino"),
                idUsuario: localStorage.getItem("usuario"),
                apartado: "auditorias",
                accion: "all",
                palabra: a.value.palabra,
                estado: a.value.estado,
              },
              c = await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(f) })).json()
            c.response == "SUCCESS" && ((s.value = c.data.data), (i.value = c.data.dataGlobales))
          } catch (f) {
            ;(s.value = []), console.log(f)
          }
        }
      l()
      const d = async () => {
        if (!(!o.value.length || o.value.length == 1))
          try {
            const f = {
                idUsuario: localStorage.getItem("usuario"),
                idDestino: localStorage.getItem("idDestino"),
                apartado: "auditorias",
                accion: "addGrupo",
                grupo: o.value,
                fechaCreado: Jr(new Date(), "yyyy-MM-dd KK:mm:ss"),
              },
              c = await (await fetch("https://maphg.com/europa/api_auditorias/", { method: "POST", body: JSON.stringify(f) })).json()
            c.response == "SUCCESS" && ((s.value = c.data.data), (i.value = c.data.dataGlobales), (o.value = ""), (t.value = !1))
          } catch (f) {
            ;(s.value = []), console.log(f)
          }
      }
      return (f, u) => (
        U(),
        q(
          Pe,
          null,
          [
            Re(Qb, { onObtenerAll: u[0] || (u[0] = (c) => l()), onDestinoSeleccionado: r }),
            y("div", Jb, [
              y("div", Xb, [
                y("div", Zb, [y("h1", e1, _e(n.value), 1), t1]),
                y("div", n1, [y("h1", r1, _e(i.value.tareasTotalGlobal), 1), s1]),
                y("div", i1, [
                  y("div", o1, [a1, y("h4", l1, _e((i.value.tareasFinalizadoGlobal * i.value.tareasTotalPorcentajeGlobal).toFixed(1)) + "% Finalizadas", 1)]),
                  y("div", u1, [c1, y("h4", f1, _e((i.value.tareasEnProcesoGlobal * i.value.tareasTotalPorcentajeGlobal).toFixed(1)) + "% En Proceso", 1)]),
                ]),
                y("div", d1, [
                  y("div", p1, [h1, y("h4", m1, _e((i.value.tareasPAprovacionGlobal * i.value.tareasTotalPorcentajeGlobal).toFixed(1)) + "% P. Aprovaci\xF3n", 1)]),
                  y("div", g1, [v1, y("h4", y1, _e((i.value.tareasPProveedorGlobal * i.value.tareasTotalPorcentajeGlobal).toFixed(1)) + "% P. Proveedor", 1)]),
                ]),
              ]),
              y("div", b1, [
                i.value.tareasFinalizadoGlobal > 0
                  ? (U(), q("div", { key: 0, style: tt({ width: i.value.tareasFinalizadoGlobal * i.value.tareasTotalPorcentajeGlobal + "%" }), class: "h-full bg-green-400 p-2 rounded-lg" }, null, 4))
                  : ve("", !0),
                i.value.tareasEnProcesoGlobal > 0
                  ? (U(), q("div", { key: 1, style: tt({ width: i.value.tareasEnProcesoGlobal * i.value.tareasTotalPorcentajeGlobal + "%" }), class: "h-full bg-yellow-400 p-2 rounded-lg" }, null, 4))
                  : ve("", !0),
                i.value.tareasPAprovacionGlobal > 0
                  ? (U(), q("div", { key: 2, style: tt({ width: i.value.tareasPAprovacionGlobal * i.value.tareasTotalPorcentajeGlobal + "%" }), class: "h-full bg-red-400 p-2 rounded-lg" }, null, 4))
                  : ve("", !0),
                i.value.tareasPProveedorGlobal > 0
                  ? (U(), q("div", { key: 3, style: tt({ width: i.value.tareasPProveedorGlobal * i.value.tareasTotalPorcentajeGlobal + "%" }), class: "h-full bg-blue-400 p-2 rounded-lg" }, null, 4))
                  : ve("", !0),
              ]),
              y("div", w1, [
                y("div", _1, [
                  $1,
                  y("div", { onClick: u[1] || (u[1] = (c) => (a.value.estado = "")), class: "flex items-center gap-1" }, C1),
                  y("div", { onClick: u[2] || (u[2] = (c) => (a.value.estado = "Finalizado")), class: "flex items-center gap-1" }, E1),
                  y("div", { onClick: u[3] || (u[3] = (c) => (a.value.estado = "En Proceso")), class: "flex items-center gap-1" }, T1),
                  y("div", { onClick: u[4] || (u[4] = (c) => (a.value.estado = "P. Aprovaci\xF3n")), class: "flex items-center gap-1" }, R1),
                  y("div", { onClick: u[5] || (u[5] = (c) => (a.value.estado = "P. Proveedor")), class: "flex items-center gap-1" }, F1),
                ]),
                Ft(
                  y(
                    "input",
                    {
                      "onUpdate:modelValue": u[6] || (u[6] = (c) => (a.value.palabra = c)),
                      type: "search",
                      class: "w-full md:w-auto card rounded-full text-xs px-2 py-1 focus:border-purple-500 border-2 border-transparent focus:outline-none",
                      placeholder: "Buscar...",
                    },
                    null,
                    512
                  ),
                  [[Lt, a.value.palabra]]
                ),
                y("button", { onClick: u[7] || (u[7] = (c) => l()), class: "text-xxs px-1 h-auto py-1" }, "Buscar"),
              ]),
              y("div", N1, [
                y("div", L1, [y("button", { onClick: u[8] || (u[8] = (c) => (t.value = !0)), class: "p-1 h-auto items-center flex gap-1 text-xxs" }, [U1, ht(" A\xF1adir grupo ")]), W1]),
                (U(!0),
                q(
                  Pe,
                  null,
                  Ut(s.value, (c, p) => (U(), Ge(I0, { key: p, array: c, onObtenerAll: u[9] || (u[9] = ($) => l()) }, null, 8, ["array"]))),
                  128
                )),
              ]),
            ]),
            (U(),
            Ge(Nt, { to: "body" }, [
              t.value
                ? (U(),
                  q("div", H1, [
                    y("div", z1, [
                      B1,
                      Ft(
                        y(
                          "input",
                          {
                            type: "text",
                            class: "card text-xs focus:outline-none p-2",
                            "w-full": "",
                            placeholder: "Nombre del grupo...",
                            "onUpdate:modelValue": u[10] || (u[10] = (c) => (o.value = c)),
                          },
                          null,
                          512
                        ),
                        [[Lt, o.value]]
                      ),
                      y("button", { onClick: u[11] || (u[11] = (c) => d()), class: "w-full text-xs" }, "A\xF1adir"),
                      y("button", { onClick: u[12] || (u[12] = (c) => (t.value = !1)), class: "w-full text-xs" }, "Cancelar"),
                    ]),
                    y("div", { onClick: u[13] || (u[13] = (c) => (t.value = !1)), class: "absolute z-10 bg-black bg-opacity-80 w-full h-full" }),
                  ]))
                : ve("", !0),
            ])),
          ],
          64
        )
      )
    },
  },
  q1 = Yi(V1, [["__scopeId", "data-v-27c5319a"]]),
  K1 = fp({ history: Ed(), routes: [{ path: "/", name: "Home", component: q1 }] })
ld(pp).use(K1).use(Mg, Lg).mount("#app")
