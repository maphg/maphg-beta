/*!
 * Chart.js v2.9.3
 * https://www.chartjs.org
 * (c) 2019 Chart.js Contributors
 * Released under the MIT License
 */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(function () { try { return require('moment'); } catch (e) { } }()) :
        typeof define === 'function' && define.amd ? define(['require'], function (require) { return factory(function () { try { return require('moment'); } catch (e) { } }()); }) :
            (global = global || self, global.Chart = factory(global.moment));
}(this, (function (moment) {
    'use strict';

    moment = moment && moment.hasOwnProperty('default') ? moment['default'] : moment;

    function createCommonjsModule(fn, module) {
        return module = { exports: {} }, fn(module, module.exports), module.exports;
    }

    function getCjsExportFromNamespace(n) {
        return n && n['default'] || n;
    }

    var colorName = {
        "aliceblue": [240, 248, 255],
        "antiquewhite": [250, 235, 215],
        "aqua": [0, 255, 255],
        "aquamarine": [127, 255, 212],
        "azure": [240, 255, 255],
        "beige": [245, 245, 220],
        "bisque": [255, 228, 196],
        "black": [0, 0, 0],
        "blanchedalmond": [255, 235, 205],
        "blue": [0, 0, 255],
        "blueviolet": [138, 43, 226],
        "brown": [165, 42, 42],
        "burlywood": [222, 184, 135],
        "cadetblue": [95, 158, 160],
        "chartreuse": [127, 255, 0],
        "chocolate": [210, 105, 30],
        "coral": [255, 127, 80],
        "cornflowerblue": [100, 149, 237],
        "cornsilk": [255, 248, 220],
        "crimson": [220, 20, 60],
        "cyan": [0, 255, 255],
        "darkblue": [0, 0, 139],
        "darkcyan": [0, 139, 139],
        "darkgoldenrod": [184, 134, 11],
        "darkgray": [169, 169, 169],
        "darkgreen": [0, 100, 0],
        "darkgrey": [169, 169, 169],
        "darkkhaki": [189, 183, 107],
        "darkmagenta": [139, 0, 139],
        "darkolivegreen": [85, 107, 47],
        "darkorange": [255, 140, 0],
        "darkorchid": [153, 50, 204],
        "darkred": [139, 0, 0],
        "darksalmon": [233, 150, 122],
        "darkseagreen": [143, 188, 143],
        "darkslateblue": [72, 61, 139],
        "darkslategray": [47, 79, 79],
        "darkslategrey": [47, 79, 79],
        "darkturquoise": [0, 206, 209],
        "darkviolet": [148, 0, 211],
        "deeppink": [255, 20, 147],
        "deepskyblue": [0, 191, 255],
        "dimgray": [105, 105, 105],
        "dimgrey": [105, 105, 105],
        "dodgerblue": [30, 144, 255],
        "firebrick": [178, 34, 34],
        "floralwhite": [255, 250, 240],
        "forestgreen": [34, 139, 34],
        "fuchsia": [255, 0, 255],
        "gainsboro": [220, 220, 220],
        "ghostwhite": [248, 248, 255],
        "gold": [255, 215, 0],
        "goldenrod": [218, 165, 32],
        "gray": [128, 128, 128],
        "green": [0, 128, 0],
        "greenyellow": [173, 255, 47],
        "grey": [128, 128, 128],
        "honeydew": [240, 255, 240],
        "hotpink": [255, 105, 180],
        "indianred": [205, 92, 92],
        "indigo": [75, 0, 130],
        "ivory": [255, 255, 240],
        "khaki": [240, 230, 140],
        "lavender": [230, 230, 250],
        "lavenderblush": [255, 240, 245],
        "lawngreen": [124, 252, 0],
        "lemonchiffon": [255, 250, 205],
        "lightblue": [173, 216, 230],
        "lightcoral": [240, 128, 128],
        "lightcyan": [224, 255, 255],
        "lightgoldenrodyellow": [250, 250, 210],
        "lightgray": [211, 211, 211],
        "lightgreen": [144, 238, 144],
        "lightgrey": [211, 211, 211],
        "lightpink": [255, 182, 193],
        "lightsalmon": [255, 160, 122],
        "lightseagreen": [32, 178, 170],
        "lightskyblue": [135, 206, 250],
        "lightslategray": [119, 136, 153],
        "lightslategrey": [119, 136, 153],
        "lightsteelblue": [176, 196, 222],
        "lightyellow": [255, 255, 224],
        "lime": [0, 255, 0],
        "limegreen": [50, 205, 50],
        "linen": [250, 240, 230],
        "magenta": [255, 0, 255],
        "maroon": [128, 0, 0],
        "mediumaquamarine": [102, 205, 170],
        "mediumblue": [0, 0, 205],
        "mediumorchid": [186, 85, 211],
        "mediumpurple": [147, 112, 219],
        "mediumseagreen": [60, 179, 113],
        "mediumslateblue": [123, 104, 238],
        "mediumspringgreen": [0, 250, 154],
        "mediumturquoise": [72, 209, 204],
        "mediumvioletred": [199, 21, 133],
        "midnightblue": [25, 25, 112],
        "mintcream": [245, 255, 250],
        "mistyrose": [255, 228, 225],
        "moccasin": [255, 228, 181],
        "navajowhite": [255, 222, 173],
        "navy": [0, 0, 128],
        "oldlace": [253, 245, 230],
        "olive": [128, 128, 0],
        "olivedrab": [107, 142, 35],
        "orange": [255, 165, 0],
        "orangered": [255, 69, 0],
        "orchid": [218, 112, 214],
        "palegoldenrod": [238, 232, 170],
        "palegreen": [152, 251, 152],
        "paleturquoise": [175, 238, 238],
        "palevioletred": [219, 112, 147],
        "papayawhip": [255, 239, 213],
        "peachpuff": [255, 218, 185],
        "peru": [205, 133, 63],
        "pink": [255, 192, 203],
        "plum": [221, 160, 221],
        "powderblue": [176, 224, 230],
        "purple": [128, 0, 128],
        "rebeccapurple": [102, 51, 153],
        "red": [255, 0, 0],
        "rosybrown": [188, 143, 143],
        "royalblue": [65, 105, 225],
        "saddlebrown": [139, 69, 19],
        "salmon": [250, 128, 114],
        "sandybrown": [244, 164, 96],
        "seagreen": [46, 139, 87],
        "seashell": [255, 245, 238],
        "sienna": [160, 82, 45],
        "silver": [192, 192, 192],
        "skyblue": [135, 206, 235],
        "slateblue": [106, 90, 205],
        "slategray": [112, 128, 144],
        "slategrey": [112, 128, 144],
        "snow": [255, 250, 250],
        "springgreen": [0, 255, 127],
        "steelblue": [70, 130, 180],
        "tan": [210, 180, 140],
        "teal": [0, 128, 128],
        "thistle": [216, 191, 216],
        "tomato": [255, 99, 71],
        "turquoise": [64, 224, 208],
        "violet": [238, 130, 238],
        "wheat": [245, 222, 179],
        "white": [255, 255, 255],
        "whitesmoke": [245, 245, 245],
        "yellow": [255, 255, 0],
        "yellowgreen": [154, 205, 50]
    };

    var conversions = createCommonjsModule(function (module) {
        /* MIT license */


        // NOTE: conversions should only return primitive values (i.e. arrays, or
        //       values that give correct `typeof` results).
        //       do not use box values types (i.e. Number(), String(), etc.)

        var reverseKeywords = {};
        for (var key in colorName) {
            if (colorName.hasOwnProperty(key)) {
                reverseKeywords[colorName[key]] = key;
            }
        }

        var convert = module.exports = {
            rgb: { channels: 3, labels: 'rgb' },
            hsl: { channels: 3, labels: 'hsl' },
            hsv: { channels: 3, labels: 'hsv' },
            hwb: { channels: 3, labels: 'hwb' },
            cmyk: { channels: 4, labels: 'cmyk' },
            xyz: { channels: 3, labels: 'xyz' },
            lab: { channels: 3, labels: 'lab' },
            lch: { channels: 3, labels: 'lch' },
            hex: { channels: 1, labels: ['hex'] },
            keyword: { channels: 1, labels: ['keyword'] },
            ansi16: { channels: 1, labels: ['ansi16'] },
            ansi256: { channels: 1, labels: ['ansi256'] },
            hcg: { channels: 3, labels: ['h', 'c', 'g'] },
            apple: { channels: 3, labels: ['r16', 'g16', 'b16'] },
            gray: { channels: 1, labels: ['gray'] }
        };

        // hide .channels and .labels properties
        for (var model in convert) {
            if (convert.hasOwnProperty(model)) {
                if (!('channels' in convert[model])) {
                    throw new Error('missing channels property: ' + model);
                }

                if (!('labels' in convert[model])) {
                    throw new Error('missing channel labels property: ' + model);
                }

                if (convert[model].labels.length !== convert[model].channels) {
                    throw new Error('channel and label counts mismatch: ' + model);
                }

                var channels = convert[model].channels;
                var labels = convert[model].labels;
                delete convert[model].channels;
                delete convert[model].labels;
                Object.defineProperty(convert[model], 'channels', { value: channels });
                Object.defineProperty(convert[model], 'labels', { value: labels });
            }
        }

        convert.rgb.hsl = function (rgb) {
            var r = rgb[0] / 255;
            var g = rgb[1] / 255;
            var b = rgb[2] / 255;
            var min = Math.min(r, g, b);
            var max = Math.max(r, g, b);
            var delta = max - min;
            var h;
            var s;
            var l;

            if (max === min) {
                h = 0;
            } else if (r === max) {
                h = (g - b) / delta;
            } else if (g === max) {
                h = 2 + (b - r) / delta;
            } else if (b === max) {
                h = 4 + (r - g) / delta;
            }

            h = Math.min(h * 60, 360);

            if (h < 0) {
                h += 360;
            }

            l = (min + max) / 2;

            if (max === min) {
                s = 0;
            } else if (l <= 0.5) {
                s = delta / (max + min);
            } else {
                s = delta / (2 - max - min);
            }

            return [h, s * 100, l * 100];
        };

        convert.rgb.hsv = function (rgb) {
            var rdif;
            var gdif;
            var bdif;
            var h;
            var s;

            var r = rgb[0] / 255;
            var g = rgb[1] / 255;
            var b = rgb[2] / 255;
            var v = Math.max(r, g, b);
            var diff = v - Math.min(r, g, b);
            var diffc = function (c) {
                return (v - c) / 6 / diff + 1 / 2;
            };

            if (diff === 0) {
                h = s = 0;
            } else {
                s = diff / v;
                rdif = diffc(r);
                gdif = diffc(g);
                bdif = diffc(b);

                if (r === v) {
                    h = bdif - gdif;
                } else if (g === v) {
                    h = (1 / 3) + rdif - bdif;
                } else if (b === v) {
                    h = (2 / 3) + gdif - rdif;
                }
                if (h < 0) {
                    h += 1;
                } else if (h > 1) {
                    h -= 1;
                }
            }

            return [
                h * 360,
                s * 100,
                v * 100
            ];
        };

        convert.rgb.hwb = function (rgb) {
            var r = rgb[0];
            var g = rgb[1];
            var b = rgb[2];
            var h = convert.rgb.hsl(rgb)[0];
            var w = 1 / 255 * Math.min(r, Math.min(g, b));

            b = 1 - 1 / 255 * Math.max(r, Math.max(g, b));

            return [h, w * 100, b * 100];
        };

        convert.rgb.cmyk = function (rgb) {
            var r = rgb[0] / 255;
            var g = rgb[1] / 255;
            var b = rgb[2] / 255;
            var c;
            var m;
            var y;
            var k;

            k = Math.min(1 - r, 1 - g, 1 - b);
            c = (1 - r - k) / (1 - k) || 0;
            m = (1 - g - k) / (1 - k) || 0;
            y = (1 - b - k) / (1 - k) || 0;

            return [c * 100, m * 100, y * 100, k * 100];
        };

        /**
         * See https://en.m.wikipedia.org/wiki/Euclidean_distance#Squared_Euclidean_distance
         * */
        function comparativeDistance(x, y) {
            return (
                Math.pow(x[0] - y[0], 2) +
                Math.pow(x[1] - y[1], 2) +
                Math.pow(x[2] - y[2], 2)
            );
        }

        convert.rgb.keyword = function (rgb) {
            var reversed = reverseKeywords[rgb];
            if (reversed) {
                return reversed;
            }

            var currentClosestDistance = Infinity;
            var currentClosestKeyword;

            for (var keyword in colorName) {
                if (colorName.hasOwnProperty(keyword)) {
                    var value = colorName[keyword];

                    // Compute comparative distance
                    var distance = comparativeDistance(rgb, value);

                    // Check if its less, if so set as closest
                    if (distance < currentClosestDistance) {
                        currentClosestDistance = distance;
                        currentClosestKeyword = keyword;
                    }
                }
            }

            return currentClosestKeyword;
        };

        convert.keyword.rgb = function (keyword) {
            return colorName[keyword];
        };

        convert.rgb.xyz = function (rgb) {
            var r = rgb[0] / 255;
            var g = rgb[1] / 255;
            var b = rgb[2] / 255;

            // assume sRGB
            r = r > 0.04045 ? Math.pow(((r + 0.055) / 1.055), 2.4) : (r / 12.92);
            g = g > 0.04045 ? Math.pow(((g + 0.055) / 1.055), 2.4) : (g / 12.92);
            b = b > 0.04045 ? Math.pow(((b + 0.055) / 1.055), 2.4) : (b / 12.92);

            var x = (r * 0.4124) + (g * 0.3576) + (b * 0.1805);
            var y = (r * 0.2126) + (g * 0.7152) + (b * 0.0722);
            var z = (r * 0.0193) + (g * 0.1192) + (b * 0.9505);

            return [x * 100, y * 100, z * 100];
        };

        convert.rgb.lab = function (rgb) {
            var xyz = convert.rgb.xyz(rgb);
            var x = xyz[0];
            var y = xyz[1];
            var z = xyz[2];
            var l;
            var a;
            var b;

            x /= 95.047;
            y /= 100;
            z /= 108.883;

            x = x > 0.008856 ? Math.pow(x, 1 / 3) : (7.787 * x) + (16 / 116);
            y = y > 0.008856 ? Math.pow(y, 1 / 3) : (7.787 * y) + (16 / 116);
            z = z > 0.008856 ? Math.pow(z, 1 / 3) : (7.787 * z) + (16 / 116);

            l = (116 * y) - 16;
            a = 500 * (x - y);
            b = 200 * (y - z);

            return [l, a, b];
        };

        convert.hsl.rgb = function (hsl) {
            var h = hsl[0] / 360;
            var s = hsl[1] / 100;
            var l = hsl[2] / 100;
            var t1;
            var t2;
            var t3;
            var rgb;
            var val;

            if (s === 0) {
                val = l * 255;
                return [val, val, val];
            }

            if (l < 0.5) {
                t2 = l * (1 + s);
            } else {
                t2 = l + s - l * s;
            }

            t1 = 2 * l - t2;

            rgb = [0, 0, 0];
            for (var i = 0; i < 3; i++) {
                t3 = h + 1 / 3 * -(i - 1);
                if (t3 < 0) {
                    t3++;
                }
                if (t3 > 1) {
                    t3--;
                }

                if (6 * t3 < 1) {
                    val = t1 + (t2 - t1) * 6 * t3;
                } else if (2 * t3 < 1) {
                    val = t2;
                } else if (3 * t3 < 2) {
                    val = t1 + (t2 - t1) * (2 / 3 - t3) * 6;
                } else {
                    val = t1;
                }

                rgb[i] = val * 255;
            }

            return rgb;
        };

        convert.hsl.hsv = function (hsl) {
            var h = hsl[0];
            var s = hsl[1] / 100;
            var l = hsl[2] / 100;
            var smin = s;
            var lmin = Math.max(l, 0.01);
            var sv;
            var v;

            l *= 2;
            s *= (l <= 1) ? l : 2 - l;
            smin *= lmin <= 1 ? lmin : 2 - lmin;
            v = (l + s) / 2;
            sv = l === 0 ? (2 * smin) / (lmin + smin) : (2 * s) / (l + s);

            return [h, sv * 100, v * 100];
        };

        convert.hsv.rgb = function (hsv) {
            var h = hsv[0] / 60;
            var s = hsv[1] / 100;
            var v = hsv[2] / 100;
            var hi = Math.floor(h) % 6;

            var f = h - Math.floor(h);
            var p = 255 * v * (1 - s);
            var q = 255 * v * (1 - (s * f));
            var t = 255 * v * (1 - (s * (1 - f)));
            v *= 255;

            switch (hi) {
                case 0:
                    return [v, t, p];
                case 1:
                    return [q, v, p];
                case 2:
                    return [p, v, t];
                case 3:
                    return [p, q, v];
                case 4:
                    return [t, p, v];
                case 5:
                    return [v, p, q];
            }
        };

        convert.hsv.hsl = function (hsv) {
            var h = hsv[0];
            var s = hsv[1] / 100;
            var v = hsv[2] / 100;
            var vmin = Math.max(v, 0.01);
            var lmin;
            var sl;
            var l;

            l = (2 - s) * v;
            lmin = (2 - s) * vmin;
            sl = s * vmin;
            sl /= (lmin <= 1) ? lmin : 2 - lmin;
            sl = sl || 0;
            l /= 2;

            return [h, sl * 100, l * 100];
        };

        // http://dev.w3.org/csswg/css-color/#hwb-to-rgb
        convert.hwb.rgb = function (hwb) {
            var h = hwb[0] / 360;
            var wh = hwb[1] / 100;
            var bl = hwb[2] / 100;
            var ratio = wh + bl;
            var i;
            var v;
            var f;
            var n;

            // wh + bl cant be > 1
            if (ratio > 1) {
                wh /= ratio;
                bl /= ratio;
            }

            i = Math.floor(6 * h);
            v = 1 - bl;
            f = 6 * h - i;

            if ((i & 0x01) !== 0) {
                f = 1 - f;
            }

            n = wh + f * (v - wh); // linear interpolation

            var r;
            var g;
            var b;
            switch (i) {
                default:
                case 6:
                case 0: r = v; g = n; b = wh; break;
                case 1: r = n; g = v; b = wh; break;
                case 2: r = wh; g = v; b = n; break;
                case 3: r = wh; g = n; b = v; break;
                case 4: r = n; g = wh; b = v; break;
                case 5: r = v; g = wh; b = n; break;
            }

            return [r * 255, g * 255, b * 255];
        };

        convert.cmyk.rgb = function (cmyk) {
            var c = cmyk[0] / 100;
            var m = cmyk[1] / 100;
            var y = cmyk[2] / 100;
            var k = cmyk[3] / 100;
            var r;
            var g;
            var b;

            r = 1 - Math.min(1, c * (1 - k) + k);
            g = 1 - Math.min(1, m * (1 - k) + k);
            b = 1 - Math.min(1, y * (1 - k) + k);

            return [r * 255, g * 255, b * 255];
        };

        convert.xyz.rgb = function (xyz) {
            var x = xyz[0] / 100;
            var y = xyz[1] / 100;
            var z = xyz[2] / 100;
            var r;
            var g;
            var b;

            r = (x * 3.2406) + (y * -1.5372) + (z * -0.4986);
            g = (x * -0.9689) + (y * 1.8758) + (z * 0.0415);
            b = (x * 0.0557) + (y * -0.2040) + (z * 1.0570);

            // assume sRGB
            r = r > 0.0031308
                ? ((1.055 * Math.pow(r, 1.0 / 2.4)) - 0.055)
                : r * 12.92;

            g = g > 0.0031308
                ? ((1.055 * Math.pow(g, 1.0 / 2.4)) - 0.055)
                : g * 12.92;

            b = b > 0.0031308
                ? ((1.055 * Math.pow(b, 1.0 / 2.4)) - 0.055)
                : b * 12.92;

            r = Math.min(Math.max(0, r), 1);
            g = Math.min(Math.max(0, g), 1);
            b = Math.min(Math.max(0, b), 1);

            return [r * 255, g * 255, b * 255];
        };

        convert.xyz.lab = function (xyz) {
            var x = xyz[0];
            var y = xyz[1];
            var z = xyz[2];
            var l;
            var a;
            var b;

            x /= 95.047;
            y /= 100;
            z /= 108.883;

            x = x > 0.008856 ? Math.pow(x, 1 / 3) : (7.787 * x) + (16 / 116);
            y = y > 0.008856 ? Math.pow(y, 1 / 3) : (7.787 * y) + (16 / 116);
            z = z > 0.008856 ? Math.pow(z, 1 / 3) : (7.787 * z) + (16 / 116);

            l = (116 * y) - 16;
            a = 500 * (x - y);
            b = 200 * (y - z);

            return [l, a, b];
        };

        convert.lab.xyz = function (lab) {
            var l = lab[0];
            var a = lab[1];
            var b = lab[2];
            var x;
            var y;
            var z;

            y = (l + 16) / 116;
            x = a / 500 + y;
            z = y - b / 200;

            var y2 = Math.pow(y, 3);
            var x2 = Math.pow(x, 3);
            var z2 = Math.pow(z, 3);
            y = y2 > 0.008856 ? y2 : (y - 16 / 116) / 7.787;
            x = x2 > 0.008856 ? x2 : (x - 16 / 116) / 7.787;
            z = z2 > 0.008856 ? z2 : (z - 16 / 116) / 7.787;

            x *= 95.047;
            y *= 100;
            z *= 108.883;

            return [x, y, z];
        };

        convert.lab.lch = function (lab) {
            var l = lab[0];
            var a = lab[1];
            var b = lab[2];
            var hr;
            var h;
            var c;

            hr = Math.atan2(b, a);
            h = hr * 360 / 2 / Math.PI;

            if (h < 0) {
                h += 360;
            }

            c = Math.sqrt(a * a + b * b);

            return [l, c, h];
        };

        convert.lch.lab = function (lch) {
            var l = lch[0];
            var c = lch[1];
            var h = lch[2];
            var a;
            var b;
            var hr;

            hr = h / 360 * 2 * Math.PI;
            a = c * Math.cos(hr);
            b = c * Math.sin(hr);

            return [l, a, b];
        };

        convert.rgb.ansi16 = function (args) {
            var r = args[0];
            var g = args[1];
            var b = args[2];
            var value = 1 in arguments ? arguments[1] : convert.rgb.hsv(args)[2]; // hsv -> ansi16 optimization

            value = Math.round(value / 50);

            if (value === 0) {
                return 30;
            }

            var ansi = 30
                + ((Math.round(b / 255) << 2)
                    | (Math.round(g / 255) << 1)
                    | Math.round(r / 255));

            if (value === 2) {
                ansi += 60;
            }

            return ansi;
        };

        convert.hsv.ansi16 = function (args) {
            // optimization here; we already know the value and don't need to get
            // it converted for us.
            return convert.rgb.ansi16(convert.hsv.rgb(args), args[2]);
        };

        convert.rgb.ansi256 = function (args) {
            var r = args[0];
            var g = args[1];
            var b = args[2];

            // we use the extended greyscale palette here, with the exception of
            // black and white. normal palette only has 4 greyscale shades.
            if (r === g && g === b) {
                if (r < 8) {
                    return 16;
                }

                if (r > 248) {
                    return 231;
                }

                return Math.round(((r - 8) / 247) * 24) + 232;
            }

            var ansi = 16
                + (36 * Math.round(r / 255 * 5))
                + (6 * Math.round(g / 255 * 5))
                + Math.round(b / 255 * 5);

            return ansi;
        };

        convert.ansi16.rgb = function (args) {
            var color = args % 10;

            // handle greyscale
            if (color === 0 || color === 7) {
                if (args > 50) {
                    color += 3.5;
                }

                color = color / 10.5 * 255;

                return [color, color, color];
            }

            var mult = (~~(args > 50) + 1) * 0.5;
            var r = ((color & 1) * mult) * 255;
            var g = (((color >> 1) & 1) * mult) * 255;
            var b = (((color >> 2) & 1) * mult) * 255;

            return [r, g, b];
        };

        convert.ansi256.rgb = function (args) {
            // handle greyscale
            if (args >= 232) {
                var c = (args - 232) * 10 + 8;
                return [c, c, c];
            }

            args -= 16;

            var rem;
            var r = Math.floor(args / 36) / 5 * 255;
            var g = Math.floor((rem = args % 36) / 6) / 5 * 255;
            var b = (rem % 6) / 5 * 255;

            return [r, g, b];
        };

        convert.rgb.hex = function (args) {
            var integer = ((Math.round(args[0]) & 0xFF) << 16)
                + ((Math.round(args[1]) & 0xFF) << 8)
                + (Math.round(args[2]) & 0xFF);

            var string = integer.toString(16).toUpperCase();
            return '000000'.substring(string.length) + string;
        };

        convert.hex.rgb = function (args) {
            var match = args.toString(16).match(/[a-f0-9]{6}|[a-f0-9]{3}/i);
            if (!match) {
                return [0, 0, 0];
            }

            var colorString = match[0];

            if (match[0].length === 3) {
                colorString = colorString.split('').map(function (char) {
                    return char + char;
                }).join('');
            }

            var integer = parseInt(colorString, 16);
            var r = (integer >> 16) & 0xFF;
            var g = (integer >> 8) & 0xFF;
            var b = integer & 0xFF;

            return [r, g, b];
        };

        convert.rgb.hcg = function (rgb) {
            var r = rgb[0] / 255;
            var g = rgb[1] / 255;
            var b = rgb[2] / 255;
            var max = Math.max(Math.max(r, g), b);
            var min = Math.min(Math.min(r, g), b);
            var chroma = (max - min);
            var grayscale;
            var hue;

            if (chroma < 1) {
                grayscale = min / (1 - chroma);
            } else {
                grayscale = 0;
            }

            if (chroma <= 0) {
                hue = 0;
            } else
                if (max === r) {
                    hue = ((g - b) / chroma) % 6;
                } else
                    if (max === g) {
                        hue = 2 + (b - r) / chroma;
                    } else {
                        hue = 4 + (r - g) / chroma + 4;
                    }

            hue /= 6;
            hue %= 1;

            return [hue * 360, chroma * 100, grayscale * 100];
        };

        convert.hsl.hcg = function (hsl) {
            var s = hsl[1] / 100;
            var l = hsl[2] / 100;
            var c = 1;
            var f = 0;

            if (l < 0.5) {
                c = 2.0 * s * l;
            } else {
                c = 2.0 * s * (1.0 - l);
            }

            if (c < 1.0) {
                f = (l - 0.5 * c) / (1.0 - c);
            }

            return [hsl[0], c * 100, f * 100];
        };

        convert.hsv.hcg = function (hsv) {
            var s = hsv[1] / 100;
            var v = hsv[2] / 100;

            var c = s * v;
            var f = 0;

            if (c < 1.0) {
                f = (v - c) / (1 - c);
            }

            return [hsv[0], c * 100, f * 100];
        };

        convert.hcg.rgb = function (hcg) {
            var h = hcg[0] / 360;
            var c = hcg[1] / 100;
            var g = hcg[2] / 100;

            if (c === 0.0) {
                return [g * 255, g * 255, g * 255];
            }

            var pure = [0, 0, 0];
            var hi = (h % 1) * 6;
            var v = hi % 1;
            var w = 1 - v;
            var mg = 0;

            switch (Math.floor(hi)) {
                case 0:
                    pure[0] = 1; pure[1] = v; pure[2] = 0; break;
                case 1:
                    pure[0] = w; pure[1] = 1; pure[2] = 0; break;
                case 2:
                    pure[0] = 0; pure[1] = 1; pure[2] = v; break;
                case 3:
                    pure[0] = 0; pure[1] = w; pure[2] = 1; break;
                case 4:
                    pure[0] = v; pure[1] = 0; pure[2] = 1; break;
                default:
                    pure[0] = 1; pure[1] = 0; pure[2] = w;
            }

            mg = (1.0 - c) * g;

            return [
                (c * pure[0] + mg) * 255,
                (c * pure[1] + mg) * 255,
                (c * pure[2] + mg) * 255
            ];
        };

        convert.hcg.hsv = function (hcg) {
            var c = hcg[1] / 100;
            var g = hcg[2] / 100;

            var v = c + g * (1.0 - c);
            var f = 0;

            if (v > 0.0) {
                f = c / v;
            }

            return [hcg[0], f * 100, v * 100];
        };

        convert.hcg.hsl = function (hcg) {
            var c = hcg[1] / 100;
            var g = hcg[2] / 100;

            var l = g * (1.0 - c) + 0.5 * c;
            var s = 0;

            if (l > 0.0 && l < 0.5) {
                s = c / (2 * l);
            } else
                if (l >= 0.5 && l < 1.0) {
                    s = c / (2 * (1 - l));
                }

            return [hcg[0], s * 100, l * 100];
        };

        convert.hcg.hwb = function (hcg) {
            var c = hcg[1] / 100;
            var g = hcg[2] / 100;
            var v = c + g * (1.0 - c);
            return [hcg[0], (v - c) * 100, (1 - v) * 100];
        };

        convert.hwb.hcg = function (hwb) {
            var w = hwb[1] / 100;
            var b = hwb[2] / 100;
            var v = 1 - b;
            var c = v - w;
            var g = 0;

            if (c < 1) {
                g = (v - c) / (1 - c);
            }

            return [hwb[0], c * 100, g * 100];
        };

        convert.apple.rgb = function (apple) {
            return [(apple[0] / 65535) * 255, (apple[1] / 65535) * 255, (apple[2] / 65535) * 255];
        };

        convert.rgb.apple = function (rgb) {
            return [(rgb[0] / 255) * 65535, (rgb[1] / 255) * 65535, (rgb[2] / 255) * 65535];
        };

        convert.gray.rgb = function (args) {
            return [args[0] / 100 * 255, args[0] / 100 * 255, args[0] / 100 * 255];
        };

        convert.gray.hsl = convert.gray.hsv = function (args) {
            return [0, 0, args[0]];
        };

        convert.gray.hwb = function (gray) {
            return [0, 100, gray[0]];
        };

        convert.gray.cmyk = function (gray) {
            return [0, 0, 0, gray[0]];
        };

        convert.gray.lab = function (gray) {
            return [gray[0], 0, 0];
        };

        convert.gray.hex = function (gray) {
            var val = Math.round(gray[0] / 100 * 255) & 0xFF;
            var integer = (val << 16) + (val << 8) + val;

            var string = integer.toString(16).toUpperCase();
            return '000000'.substring(string.length) + string;
        };

        convert.rgb.gray = function (rgb) {
            var val = (rgb[0] + rgb[1] + rgb[2]) / 3;
            return [val / 255 * 100];
        };
    });
    var conversions_1 = conversions.rgb;
    var conversions_2 = conversions.hsl;
    var conversions_3 = conversions.hsv;
    var conversions_4 = conversions.hwb;
    var conversions_5 = conversions.cmyk;
    var conversions_6 = conversions.xyz;
    var conversions_7 = conversions.lab;
    var conversions_8 = conversions.lch;
    var conversions_9 = conversions.hex;
    var conversions_10 = conversions.keyword;
    var conversions_11 = conversions.ansi16;
    var conversions_12 = conversions.ansi256;
    var conversions_13 = conversions.hcg;
    var conversions_14 = conversions.apple;
    var conversions_15 = conversions.gray;

    /*
        this function routes a model to all other models.
    
        all functions that are routed have a property `.conversion` attached
        to the returned synthetic function. This property is an array
        of strings, each with the steps in between the 'from' and 'to'
        color models (inclusive).
    
        conversions that are not possible simply are not included.
    */

    function buildGraph() {
        var graph = {};
        // https://jsperf.com/object-keys-vs-for-in-with-closure/3
        var models = Object.keys(conversions);

        for (var len = models.length, i = 0; i < len; i++) {
            graph[models[i]] = {
                // http://jsperf.com/1-vs-infinity
                // micro-opt, but this is simple.
                distance: -1,
                parent: null
            };
        }

        return graph;
    }

    // https://en.wikipedia.org/wiki/Breadth-first_search
    function deriveBFS(fromModel) {
        var graph = buildGraph();
        var queue = [fromModel]; // unshift -> queue -> pop

        graph[fromModel].distance = 0;

        while (queue.length) {
            var current = queue.pop();
            var adjacents = Object.keys(conversions[current]);

            for (var len = adjacents.length, i = 0; i < len; i++) {
                var adjacent = adjacents[i];
                var node = graph[adjacent];

                if (node.distance === -1) {
                    node.distance = graph[current].distance + 1;
                    node.parent = current;
                    queue.unshift(adjacent);
                }
            }
        }

        return graph;
    }

    function link(from, to) {
        return function (args) {
            return to(from(args));
        };
    }

    function wrapConversion(toModel, graph) {
        var path = [graph[toModel].parent, toModel];
        var fn = conversions[graph[toModel].parent][toModel];

        var cur = graph[toModel].parent;
        while (graph[cur].parent) {
            path.unshift(graph[cur].parent);
            fn = link(conversions[graph[cur].parent][cur], fn);
            cur = graph[cur].parent;
        }

        fn.conversion = path;
        return fn;
    }

    var route = function (fromModel) {
        var graph = deriveBFS(fromModel);
        var conversion = {};

        var models = Object.keys(graph);
        for (var len = models.length, i = 0; i < len; i++) {
            var toModel = models[i];
            var node = graph[toModel];

            if (node.parent === null) {
                // no possible conversion, or this node is the source model.
                continue;
            }

            conversion[toModel] = wrapConversion(toModel, graph);
        }

        return conversion;
    };

    var convert = {};

    var models = Object.keys(conversions);

    function wrapRaw(fn) {
        var wrappedFn = function (args) {
            if (args === undefined || args === null) {
                return args;
            }

            if (arguments.length > 1) {
                args = Array.prototype.slice.call(arguments);
            }

            return fn(args);
        };

        // preserve .conversion property if there is one
        if ('conversion' in fn) {
            wrappedFn.conversion = fn.conversion;
        }

        return wrappedFn;
    }

    function wrapRounded(fn) {
        var wrappedFn = function (args) {
            if (args === undefined || args === null) {
                return args;
            }

            if (arguments.length > 1) {
                args = Array.prototype.slice.call(arguments);
            }

            var result = fn(args);

            // we're assuming the result is an array here.
            // see notice in conversions.js; don't use box types
            // in conversion functions.
            if (typeof result === 'object') {
                for (var len = result.length, i = 0; i < len; i++) {
                    result[i] = Math.round(result[i]);
                }
            }

            return result;
        };

        // preserve .conversion property if there is one
        if ('conversion' in fn) {
            wrappedFn.conversion = fn.conversion;
        }

        return wrappedFn;
    }

    models.forEach(function (fromModel) {
        convert[fromModel] = {};

        Object.defineProperty(convert[fromModel], 'channels', { value: conversions[fromModel].channels });
        Object.defineProperty(convert[fromModel], 'labels', { value: conversions[fromModel].labels });

        var routes = route(fromModel);
        var routeModels = Object.keys(routes);

        routeModels.forEach(function (toModel) {
            var fn = routes[toModel];

            convert[fromModel][toModel] = wrapRounded(fn);
            convert[fromModel][toModel].raw = wrapRaw(fn);
        });
    });

    var colorConvert = convert;

    var colorName$1 = {
        "aliceblue": [240, 248, 255],
        "antiquewhite": [250, 235, 215],
        "aqua": [0, 255, 255],
        "aquamarine": [127, 255, 212],
        "azure": [240, 255, 255],
        "beige": [245, 245, 220],
        "bisque": [255, 228, 196],
        "black": [0, 0, 0],
        "blanchedalmond": [255, 235, 205],
        "blue": [0, 0, 255],
        "blueviolet": [138, 43, 226],
        "brown": [165, 42, 42],
        "burlywood": [222, 184, 135],
        "cadetblue": [95, 158, 160],
        "chartreuse": [127, 255, 0],
        "chocolate": [210, 105, 30],
        "coral": [255, 127, 80],
        "cornflowerblue": [100, 149, 237],
        "cornsilk": [255, 248, 220],
        "crimson": [220, 20, 60],
        "cyan": [0, 255, 255],
        "darkblue": [0, 0, 139],
        "darkcyan": [0, 139, 139],
        "darkgoldenrod": [184, 134, 11],
        "darkgray": [169, 169, 169],
        "darkgreen": [0, 100, 0],
        "darkgrey": [169, 169, 169],
        "darkkhaki": [189, 183, 107],
        "darkmagenta": [139, 0, 139],
        "darkolivegreen": [85, 107, 47],
        "darkorange": [255, 140, 0],
        "darkorchid": [153, 50, 204],
        "darkred": [139, 0, 0],
        "darksalmon": [233, 150, 122],
        "darkseagreen": [143, 188, 143],
        "darkslateblue": [72, 61, 139],
        "darkslategray": [47, 79, 79],
        "darkslategrey": [47, 79, 79],
        "darkturquoise": [0, 206, 209],
        "darkviolet": [148, 0, 211],
        "deeppink": [255, 20, 147],
        "deepskyblue": [0, 191, 255],
        "dimgray": [105, 105, 105],
        "dimgrey": [105, 105, 105],
        "dodgerblue": [30, 144, 255],
        "firebrick": [178, 34, 34],
        "floralwhite": [255, 250, 240],
        "forestgreen": [34, 139, 34],
        "fuchsia": [255, 0, 255],
        "gainsboro": [220, 220, 220],
        "ghostwhite": [248, 248, 255],
        "gold": [255, 215, 0],
        "goldenrod": [218, 165, 32],
        "gray": [128, 128, 128],
        "green": [0, 128, 0],
        "greenyellow": [173, 255, 47],
        "grey": [128, 128, 128],
        "honeydew": [240, 255, 240],
        "hotpink": [255, 105, 180],
        "indianred": [205, 92, 92],
        "indigo": [75, 0, 130],
        "ivory": [255, 255, 240],
        "khaki": [240, 230, 140],
        "lavender": [230, 230, 250],
        "lavenderblush": [255, 240, 245],
        "lawngreen": [124, 252, 0],
        "lemonchiffon": [255, 250, 205],
        "lightblue": [173, 216, 230],
        "lightcoral": [240, 128, 128],
        "lightcyan": [224, 255, 255],
        "lightgoldenrodyellow": [250, 250, 210],
        "lightgray": [211, 211, 211],
        "lightgreen": [144, 238, 144],
        "lightgrey": [211, 211, 211],
        "lightpink": [255, 182, 193],
        "lightsalmon": [255, 160, 122],
        "lightseagreen": [32, 178, 170],
        "lightskyblue": [135, 206, 250],
        "lightslategray": [119, 136, 153],
        "lightslategrey": [119, 136, 153],
        "lightsteelblue": [176, 196, 222],
        "lightyellow": [255, 255, 224],
        "lime": [0, 255, 0],
        "limegreen": [50, 205, 50],
        "linen": [250, 240, 230],
        "magenta": [255, 0, 255],
        "maroon": [128, 0, 0],
        "mediumaquamarine": [102, 205, 170],
        "mediumblue": [0, 0, 205],
        "mediumorchid": [186, 85, 211],
        "mediumpurple": [147, 112, 219],
        "mediumseagreen": [60, 179, 113],
        "mediumslateblue": [123, 104, 238],
        "mediumspringgreen": [0, 250, 154],
        "mediumturquoise": [72, 209, 204],
        "mediumvioletred": [199, 21, 133],
        "midnightblue": [25, 25, 112],
        "mintcream": [245, 255, 250],
        "mistyrose": [255, 228, 225],
        "moccasin": [255, 228, 181],
        "navajowhite": [255, 222, 173],
        "navy": [0, 0, 128],
        "oldlace": [253, 245, 230],
        "olive": [128, 128, 0],
        "olivedrab": [107, 142, 35],
        "orange": [255, 165, 0],
        "orangered": [255, 69, 0],
        "orchid": [218, 112, 214],
        "palegoldenrod": [238, 232, 170],
        "palegreen": [152, 251, 152],
        "paleturquoise": [175, 238, 238],
        "palevioletred": [219, 112, 147],
        "papayawhip": [255, 239, 213],
        "peachpuff": [255, 218, 185],
        "peru": [205, 133, 63],
        "pink": [255, 192, 203],
        "plum": [221, 160, 221],
        "powderblue": [176, 224, 230],
        "purple": [128, 0, 128],
        "rebeccapurple": [102, 51, 153],
        "red": [255, 0, 0],
        "rosybrown": [188, 143, 143],
        "royalblue": [65, 105, 225],
        "saddlebrown": [139, 69, 19],
        "salmon": [250, 128, 114],
        "sandybrown": [244, 164, 96],
        "seagreen": [46, 139, 87],
        "seashell": [255, 245, 238],
        "sienna": [160, 82, 45],
        "silver": [192, 192, 192],
        "skyblue": [135, 206, 235],
        "slateblue": [106, 90, 205],
        "slategray": [112, 128, 144],
        "slategrey": [112, 128, 144],
        "snow": [255, 250, 250],
        "springgreen": [0, 255, 127],
        "steelblue": [70, 130, 180],
        "tan": [210, 180, 140],
        "teal": [0, 128, 128],
        "thistle": [216, 191, 216],
        "tomato": [255, 99, 71],
        "turquoise": [64, 224, 208],
        "violet": [238, 130, 238],
        "wheat": [245, 222, 179],
        "white": [255, 255, 255],
        "whitesmoke": [245, 245, 245],
        "yellow": [255, 255, 0],
        "yellowgreen": [154, 205, 50]
    };

    /* MIT license */


    var colorString = {
        getRgba: getRgba,
        getHsla: getHsla,
        getRgb: getRgb,
        getHsl: getHsl,
        getHwb: getHwb,
        getAlpha: getAlpha,

        hexString: hexString,
        rgbString: rgbString,
        rgbaString: rgbaString,
        percentString: percentString,
        percentaString: percentaString,
        hslString: hslString,
        hslaString: hslaString,
        hwbString: hwbString,
        keyword: keyword
    };

    function getRgba(string) {
        if (!string) {
            return;
        }
        var abbr = /^#([a-fA-F0-9]{3,4})$/i,
            hex = /^#([a-fA-F0-9]{6}([a-fA-F0-9]{2})?)$/i,
            rgba = /^rgba?\(\s*([+-]?\d+)\s*,\s*([+-]?\d+)\s*,\s*([+-]?\d+)\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)$/i,
            per = /^rgba?\(\s*([+-]?[\d\.]+)\%\s*,\s*([+-]?[\d\.]+)\%\s*,\s*([+-]?[\d\.]+)\%\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)$/i,
            keyword = /(\w+)/;

        var rgb = [0, 0, 0],
            a = 1,
            match = string.match(abbr),
            hexAlpha = "";
        if (match) {
            match = match[1];
            hexAlpha = match[3];
            for (var i = 0; i < rgb.length; i++) {
                rgb[i] = parseInt(match[i] + match[i], 16);
            }
            if (hexAlpha) {
                a = Math.round((parseInt(hexAlpha + hexAlpha, 16) / 255) * 100) / 100;
            }
        }
        else if (match = string.match(hex)) {
            hexAlpha = match[2];
            match = match[1];
            for (var i = 0; i < rgb.length; i++) {
                rgb[i] = parseInt(match.slice(i * 2, i * 2 + 2), 16);
            }
            if (hexAlpha) {
                a = Math.round((parseInt(hexAlpha, 16) / 255) * 100) / 100;
            }
        }
        else if (match = string.match(rgba)) {
            for (var i = 0; i < rgb.length; i++) {
                rgb[i] = parseInt(match[i + 1]);
            }
            a = parseFloat(match[4]);
        }
        else if (match = string.match(per)) {
            for (var i = 0; i < rgb.length; i++) {
                rgb[i] = Math.round(parseFloat(match[i + 1]) * 2.55);
            }
            a = parseFloat(match[4]);
        }
        else if (match = string.match(keyword)) {
            if (match[1] == "transparent") {
                return [0, 0, 0, 0];
            }
            rgb = colorName$1[match[1]];
            if (!rgb) {
                return;
            }
        }

        for (var i = 0; i < rgb.length; i++) {
            rgb[i] = scale(rgb[i], 0, 255);
        }
        if (!a && a != 0) {
            a = 1;
        }
        else {
            a = scale(a, 0, 1);
        }
        rgb[3] = a;
        return rgb;
    }

    function getHsla(string) {
        if (!string) {
            return;
        }
        var hsl = /^hsla?\(\s*([+-]?\d+)(?:deg)?\s*,\s*([+-]?[\d\.]+)%\s*,\s*([+-]?[\d\.]+)%\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)/;
        var match = string.match(hsl);
        if (match) {
            var alpha = parseFloat(match[4]);
            var h = scale(parseInt(match[1]), 0, 360),
                s = scale(parseFloat(match[2]), 0, 100),
                l = scale(parseFloat(match[3]), 0, 100),
                a = scale(isNaN(alpha) ? 1 : alpha, 0, 1);
            return [h, s, l, a];
        }
    }

    function getHwb(string) {
        if (!string) {
            return;
        }
        var hwb = /^hwb\(\s*([+-]?\d+)(?:deg)?\s*,\s*([+-]?[\d\.]+)%\s*,\s*([+-]?[\d\.]+)%\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)/;
        var match = string.match(hwb);
        if (match) {
            var alpha = parseFloat(match[4]);
            var h = scale(parseInt(match[1]), 0, 360),
                w = scale(parseFloat(match[2]), 0, 100),
                b = scale(parseFloat(match[3]), 0, 100),
                a = scale(isNaN(alpha) ? 1 : alpha, 0, 1);
            return [h, w, b, a];
        }
    }

    function getRgb(string) {
        var rgba = getRgba(string);
        return rgba && rgba.slice(0, 3);
    }

    function getHsl(string) {
        var hsla = getHsla(string);
        return hsla && hsla.slice(0, 3);
    }

    function getAlpha(string) {
        var vals = getRgba(string);
        if (vals) {
            return vals[3];
        }
        else if (vals = getHsla(string)) {
            return vals[3];
        }
        else if (vals = getHwb(string)) {
            return vals[3];
        }
    }

    // generators
    function hexString(rgba, a) {
        var a = (a !== undefined && rgba.length === 3) ? a : rgba[3];
        return "#" + hexDouble(rgba[0])
            + hexDouble(rgba[1])
            + hexDouble(rgba[2])
            + (
                (a >= 0 && a < 1)
                    ? hexDouble(Math.round(a * 255))
                    : ""
            );
    }

    function rgbString(rgba, alpha) {
        if (alpha < 1 || (rgba[3] && rgba[3] < 1)) {
            return rgbaString(rgba, alpha);
        }
        return "rgb(" + rgba[0] + ", " + rgba[1] + ", " + rgba[2] + ")";
    }

    function rgbaString(rgba, alpha) {
        if (alpha === undefined) {
            alpha = (rgba[3] !== undefined ? rgba[3] : 1);
        }
        return "rgba(" + rgba[0] + ", " + rgba[1] + ", " + rgba[2]
            + ", " + alpha + ")";
    }

    function percentString(rgba, alpha) {
        if (alpha < 1 || (rgba[3] && rgba[3] < 1)) {
            return percentaString(rgba, alpha);
        }
        var r = Math.round(rgba[0] / 255 * 100),
            g = Math.round(rgba[1] / 255 * 100),
            b = Math.round(rgba[2] / 255 * 100);

        return "rgb(" + r + "%, " + g + "%, " + b + "%)";
    }

    function percentaString(rgba, alpha) {
        var r = Math.round(rgba[0] / 255 * 100),
            g = Math.round(rgba[1] / 255 * 100),
            b = Math.round(rgba[2] / 255 * 100);
        return "rgba(" + r + "%, " + g + "%, " + b + "%, " + (alpha || rgba[3] || 1) + ")";
    }

    function hslString(hsla, alpha) {
        if (alpha < 1 || (hsla[3] && hsla[3] < 1)) {
            return hslaString(hsla, alpha);
        }
        return "hsl(" + hsla[0] + ", " + hsla[1] + "%, " + hsla[2] + "%)";
    }

    function hslaString(hsla, alpha) {
        if (alpha === undefined) {
            alpha = (hsla[3] !== undefined ? hsla[3] : 1);
        }
        return "hsla(" + hsla[0] + ", " + hsla[1] + "%, " + hsla[2] + "%, "
            + alpha + ")";
    }

    // hwb is a bit different than rgb(a) & hsl(a) since there is no alpha specific syntax
    // (hwb have alpha optional & 1 is default value)
    function hwbString(hwb, alpha) {
        if (alpha === undefined) {
            alpha = (hwb[3] !== undefined ? hwb[3] : 1);
        }
        return "hwb(" + hwb[0] + ", " + hwb[1] + "%, " + hwb[2] + "%"
            + (alpha !== undefined && alpha !== 1 ? ", " + alpha : "") + ")";
    }

    function keyword(rgb) {
        return reverseNames[rgb.slice(0, 3)];
    }

    // helpers
    function scale(num, min, max) {
        return Math.min(Math.max(min, num), max);
    }

    function hexDouble(num) {
        var str = num.toString(16).toUpperCase();
        return (str.length < 2) ? "0" + str : str;
    }


    //create a list of reverse color names
    var reverseNames = {};
    for (var name in colorName$1) {
        reverseNames[colorName$1[name]] = name;
    }

    /* MIT license */



    var Color = function (obj) {
        if (obj instanceof Color) {
            return obj;
        }
        if (!(this instanceof Color)) {
            return new Color(obj);
        }

        this.valid = false;
        this.values = {
            rgb: [0, 0, 0],
            hsl: [0, 0, 0],
            hsv: [0, 0, 0],
            hwb: [0, 0, 0],
            cmyk: [0, 0, 0, 0],
            alpha: 1
        };

        // parse Color() argument
        var vals;
        if (typeof obj === 'string') {
            vals = colorString.getRgba(obj);
            if (vals) {
                this.setValues('rgb', vals);
            } else if (vals = colorString.getHsla(obj)) {
                this.setValues('hsl', vals);
            } else if (vals = colorString.getHwb(obj)) {
                this.setValues('hwb', vals);
            }
        } else if (typeof obj === 'object') {
            vals = obj;
            if (vals.r !== undefined || vals.red !== undefined) {
                this.setValues('rgb', vals);
            } else if (vals.l !== undefined || vals.lightness !== undefined) {
                this.setValues('hsl', vals);
            } else if (vals.v !== undefined || vals.value !== undefined) {
                this.setValues('hsv', vals);
            } else if (vals.w !== undefined || vals.whiteness !== undefined) {
                this.setValues('hwb', vals);
            } else if (vals.c !== undefined || vals.cyan !== undefined) {
                this.setValues('cmyk', vals);
            }
        }
    };

    Color.prototype = {
        isValid: function () {
            return this.valid;
        },
        rgb: function () {
            return this.setSpace('rgb', arguments);
        },
        hsl: function () {
            return this.setSpace('hsl', arguments);
        },
        hsv: function () {
            return this.setSpace('hsv', arguments);
        },
        hwb: function () {
            return this.setSpace('hwb', arguments);
        },
        cmyk: function () {
            return this.setSpace('cmyk', arguments);
        },

        rgbArray: function () {
            return this.values.rgb;
        },
        hslArray: function () {
            return this.values.hsl;
        },
        hsvArray: function () {
            return this.values.hsv;
        },
        hwbArray: function () {
            var values = this.values;
            if (values.alpha !== 1) {
                return values.hwb.concat([values.alpha]);
            }
            return values.hwb;
        },
        cmykArray: function () {
            return this.values.cmyk;
        },
        rgbaArray: function () {
            var values = this.values;
            return values.rgb.concat([values.alpha]);
        },
        hslaArray: function () {
            var values = this.values;
            return values.hsl.concat([values.alpha]);
        },
        alpha: function (val) {
            if (val === undefined) {
                return this.values.alpha;
            }
            this.setValues('alpha', val);
            return this;
        },

        red: function (val) {
            return this.setChannel('rgb', 0, val);
        },
        green: function (val) {
            return this.setChannel('rgb', 1, val);
        },
        blue: function (val) {
            return this.setChannel('rgb', 2, val);
        },
        hue: function (val) {
            if (val) {
                val %= 360;
                val = val < 0 ? 360 + val : val;
            }
            return this.setChannel('hsl', 0, val);
        },
        saturation: function (val) {
            return this.setChannel('hsl', 1, val);
        },
        lightness: function (val) {
            return this.setChannel('hsl', 2, val);
        },
        saturationv: function (val) {
            return this.setChannel('hsv', 1, val);
        },
        whiteness: function (val) {
            return this.setChannel('hwb', 1, val);
        },
        blackness: function (val) {
            return this.setChannel('hwb', 2, val);
        },
        value: function (val) {
            return this.setChannel('hsv', 2, val);
        },
        cyan: function (val) {
            return this.setChannel('cmyk', 0, val);
        },
        magenta: function (val) {
            return this.setChannel('cmyk', 1, val);
        },
        yellow: function (val) {
            return this.setChannel('cmyk', 2, val);
        },
        black: function (val) {
            return this.setChannel('cmyk', 3, val);
        },

        hexString: function () {
            return colorString.hexString(this.values.rgb);
        },
        rgbString: function () {
            return colorString.rgbString(this.values.rgb, this.values.alpha);
        },
        rgbaString: function () {
            return colorString.rgbaString(this.values.rgb, this.values.alpha);
        },
        percentString: function () {
            return colorString.percentString(this.values.rgb, this.values.alpha);
        },
        hslString: function () {
            return colorString.hslString(this.values.hsl, this.values.alpha);
        },
        hslaString: function () {
            return colorString.hslaString(this.values.hsl, this.values.alpha);
        },
        hwbString: function () {
            return colorString.hwbString(this.values.hwb, this.values.alpha);
        },
        keyword: function () {
            return colorString.keyword(this.values.rgb, this.values.alpha);
        },

        rgbNumber: function () {
            var rgb = this.values.rgb;
            return (rgb[0] << 16) | (rgb[1] << 8) | rgb[2];
        },

        luminosity: function () {
            // http://www.w3.org/TR/WCAG20/#relativeluminancedef
            var rgb = this.values.rgb;
            var lum = [];
            for (var i = 0; i < rgb.length; i++) {
                var chan = rgb[i] / 255;
                lum[i] = (chan <= 0.03928) ? chan / 12.92 : Math.pow(((chan + 0.055) / 1.055), 2.4);
            }
            return 0.2126 * lum[0] + 0.7152 * lum[1] + 0.0722 * lum[2];
        },

        contrast: function (color2) {
            // http://www.w3.org/TR/WCAG20/#contrast-ratiodef
            var lum1 = this.luminosity();
            var lum2 = color2.luminosity();
            if (lum1 > lum2) {
                return (lum1 + 0.05) / (lum2 + 0.05);
            }
            return (lum2 + 0.05) / (lum1 + 0.05);
        },

        level: function (color2) {
            var contrastRatio = this.contrast(color2);
            if (contrastRatio >= 7.1) {
                return 'AAA';
            }

            return (contrastRatio >= 4.5) ? 'AA' : '';
        },

        dark: function () {
            // YIQ equation from http://24ways.org/2010/calculating-color-contrast
            var rgb = this.values.rgb;
            var yiq = (rgb[0] * 299 + rgb[1] * 587 + rgb[2] * 114) / 1000;
            return yiq < 128;
        },

        light: function () {
            return !this.dark();
        },

        negate: function () {
            var rgb = [];
            for (var i = 0; i < 3; i++) {
                rgb[i] = 255 - this.values.rgb[i];
            }
            this.setValues('rgb', rgb);
            return this;
        },

        lighten: function (ratio) {
            var hsl = this.values.hsl;
            hsl[2] += hsl[2] * ratio;
            this.setValues('hsl', hsl);
            return this;
        },

        darken: function (ratio) {
            var hsl = this.values.hsl;
            hsl[2] -= hsl[2] * ratio;
            this.setValues('hsl', hsl);
            return this;
        },

        saturate: function (ratio) {
            var hsl = this.values.hsl;
            hsl[1] += hsl[1] * ratio;
            this.setValues('hsl', hsl);
            return this;
        },

        desaturate: function (ratio) {
            var hsl = this.values.hsl;
            hsl[1] -= hsl[1] * ratio;
            this.setValues('hsl', hsl);
            return this;
        },

        whiten: function (ratio) {
            var hwb = this.values.hwb;
            hwb[1] += hwb[1] * ratio;
            this.setValues('hwb', hwb);
            return this;
        },

        blacken: function (ratio) {
            var hwb = this.values.hwb;
            hwb[2] += hwb[2] * ratio;
            this.setValues('hwb', hwb);
            return this;
        },

        greyscale: function () {
            var rgb = this.values.rgb;
            // http://en.wikipedia.org/wiki/Grayscale#Converting_color_to_grayscale
            var val = rgb[0] * 0.3 + rgb[1] * 0.59 + rgb[2] * 0.11;
            this.setValues('rgb', [val, val, val]);
            return this;
        },

        clearer: function (ratio) {
            var alpha = this.values.alpha;
            this.setValues('alpha', alpha - (alpha * ratio));
            return this;
        },

        opaquer: function (ratio) {
            var alpha = this.values.alpha;
            this.setValues('alpha', alpha + (alpha * ratio));
            return this;
        },

        rotate: function (degrees) {
            var hsl = this.values.hsl;
            var hue = (hsl[0] + degrees) % 360;
            hsl[0] = hue < 0 ? 360 + hue : hue;
            this.setValues('hsl', hsl);
            return this;
        },

        /**
         * Ported from sass implementation in C
         * https://github.com/sass/libsass/blob/0e6b4a2850092356aa3ece07c6b249f0221caced/functions.cpp#L209
         */
        mix: function (mixinColor, weight) {
            var color1 = this;
            var color2 = mixinColor;
            var p = weight === undefined ? 0.5 : weight;

            var w = 2 * p - 1;
            var a = color1.alpha() - color2.alpha();

            var w1 = (((w * a === -1) ? w : (w + a) / (1 + w * a)) + 1) / 2.0;
            var w2 = 1 - w1;

            return this
                .rgb(
                    w1 * color1.red() + w2 * color2.red(),
                    w1 * color1.green() + w2 * color2.green(),
                    w1 * color1.blue() + w2 * color2.blue()
                )
                .alpha(color1.alpha() * p + color2.alpha() * (1 - p));
        },

        toJSON: function () {
            return this.rgb();
        },

        clone: function () {
            // NOTE(SB): using node-clone creates a dependency to Buffer when using browserify,
            // making the final build way to big to embed in Chart.js. So let's do it manually,
            // assuming that values to clone are 1 dimension arrays containing only numbers,
            // except 'alpha' which is a number.
            var result = new Color();
            var source = this.values;
            var target = result.values;
            var value, type;

            for (var prop in source) {
                if (source.hasOwnProperty(prop)) {
                    value = source[prop];
                    type = ({}).toString.call(value);
                    if (type === '[object Array]') {
                        target[prop] = value.slice(0);
                    } else if (type === '[object Number]') {
                        target[prop] = value;
                    } else {
                        console.error('unexpected color value:', value);
                    }
                }
            }

            return result;
        }
    };

    Color.prototype.spaces = {
        rgb: ['red', 'green', 'blue'],
        hsl: ['hue', 'saturation', 'lightness'],
        hsv: ['hue', 'saturation', 'value'],
        hwb: ['hue', 'whiteness', 'blackness'],
        cmyk: ['cyan', 'magenta', 'yellow', 'black']
    };

    Color.prototype.maxes = {
        rgb: [255, 255, 255],
        hsl: [360, 100, 100],
        hsv: [360, 100, 100],
        hwb: [360, 100, 100],
        cmyk: [100, 100, 100, 100]
    };

    Color.prototype.getValues = function (space) {
        var values = this.values;
        var vals = {};

        for (var i = 0; i < space.length; i++) {
            vals[space.charAt(i)] = values[space][i];
        }

        if (values.alpha !== 1) {
            vals.a = values.alpha;
        }

        // {r: 255, g: 255, b: 255, a: 0.4}
        return vals;
    };

    Color.prototype.setValues = function (space, vals) {
        var values = this.values;
        var spaces = this.spaces;
        var maxes = this.maxes;
        var alpha = 1;
        var i;

        this.valid = true;

        if (space === 'alpha') {
            alpha = vals;
        } else if (vals.length) {
            // [10, 10, 10]
            values[space] = vals.slice(0, space.length);
            alpha = vals[space.length];
        } else if (vals[space.charAt(0)] !== undefined) {
            // {r: 10, g: 10, b: 10}
            for (i = 0; i < space.length; i++) {
                values[space][i] = vals[space.charAt(i)];
            }

            alpha = vals.a;
        } else if (vals[spaces[space][0]] !== undefined) {
            // {red: 10, green: 10, blue: 10}
            var chans = spaces[space];

            for (i = 0; i < space.length; i++) {
                values[space][i] = vals[chans[i]];
            }

            alpha = vals.alpha;
        }

        values.alpha = Math.max(0, Math.min(1, (alpha === undefined ? values.alpha : alpha)));

        if (space === 'alpha') {
            return false;
        }

        var capped;

        // cap values of the space prior converting all values
        for (i = 0; i < space.length; i++) {
            capped = Math.max(0, Math.min(maxes[space][i], values[space][i]));
            values[space][i] = Math.round(capped);
        }

        // convert to all the other color spaces
        for (var sname in spaces) {
            if (sname !== space) {
                values[sname] = colorConvert[space][sname](values[space]);
            }
        }

        return true;
    };

    Color.prototype.setSpace = function (space, args) {
        var vals = args[0];

        if (vals === undefined) {
            // color.rgb()
            return this.getValues(space);
        }

        // color.rgb(10, 10, 10)
        if (typeof vals === 'number') {
            vals = Array.prototype.slice.call(args);
        }

        this.setValues(space, vals);
        return this;
    };

    Color.prototype.setChannel = function (space, index, val) {
        var svalues = this.values[space];
        if (val === undefined) {
            // color.red()
            return svalues[index];
        } else if (val === svalues[index]) {
            // color.red(color.red())
            return this;
        }

        // color.red(100)
        svalues[index] = val;
        this.setValues(space, svalues);

        return this;
    };

    if (typeof window !== 'undefined') {
        window.Color = Color;
    }

    var chartjsColor = Color;

    /**
     * @namespace Chart.helpers
     */
    var helpers = {
        /**
         * An empty function that can be used, for example, for optional callback.
         */
        noop: function () { },

        /**
         * Returns a unique id, sequentially generated from a global variable.
         * @returns {number}
         * @function
         */
        uid: (function () {
            var id = 0;
            return function () {
                return id++;
            };
        }()),

        /**
         * Returns true if `value` is neither null nor undefined, else returns false.
         * @param {*} value - The value to test.
         * @returns {boolean}
         * @since 2.7.0
         */
        isNullOrUndef: function (value) {
            return value === null || typeof value === 'undefined';
        },

        /**
         * Returns true if `value` is an array (including typed arrays), else returns false.
         * @param {*} value - The value to test.
         * @returns {boolean}
         * @function
         */
        isArray: function (value) {
            if (Array.isArray && Array.isArray(value)) {
                return true;
            }
            var type = Object.prototype.toString.call(value);
            if (type.substr(0, 7) === '[object' && type.substr(-6) === 'Array]') {
                return true;
            }
            return false;
        },

        /**
         * Returns true if `value` is an object (excluding null), else returns false.
         * @param {*} value - The value to test.
         * @returns {boolean}
         * @since 2.7.0
         */
        isObject: function (value) {
            return value !== null && Object.prototype.toString.call(value) === '[object Object]';
        },

        /**
         * Returns true if `value` is a finite number, else returns false
         * @param {*} value  - The value to test.
         * @returns {boolean}
         */
        isFinite: function (value) {
            return (typeof value === 'number' || value instanceof Number) && isFinite(value);
        },

        /**
         * Returns `value` if defined, else returns `defaultValue`.
         * @param {*} value - The value to return if defined.
         * @param {*} defaultValue - The value to return if `value` is undefined.
         * @returns {*}
         */
        valueOrDefault: function (value, defaultValue) {
            return typeof value === 'undefined' ? defaultValue : value;
        },

        /**
         * Returns value at the given `index` in array if defined, else returns `defaultValue`.
         * @param {Array} value - The array to lookup for value at `index`.
         * @param {number} index - The index in `value` to lookup for value.
         * @param {*} defaultValue - The value to return if `value[index]` is undefined.
         * @returns {*}
         */
        valueAtIndexOrDefault: function (value, index, defaultValue) {
            return helpers.valueOrDefault(helpers.isArray(value) ? value[index] : value, defaultValue);
        },

        /**
         * Calls `fn` with the given `args` in the scope defined by `thisArg` and returns the
         * value returned by `fn`. If `fn` is not a function, this method returns undefined.
         * @param {function} fn - The function to call.
         * @param {Array|undefined|null} args - The arguments with which `fn` should be called.
         * @param {object} [thisArg] - The value of `this` provided for the call to `fn`.
         * @returns {*}
         */
        callback: function (fn, args, thisArg) {
            if (fn && typeof fn.call === 'function') {
                return fn.apply(thisArg, args);
            }
        },

        /**
         * Note(SB) for performance sake, this method should only be used when loopable type
         * is unknown or in none intensive code (not called often and small loopable). Else
         * it's preferable to use a regular for() loop and save extra function calls.
         * @param {object|Array} loopable - The object or array to be iterated.
         * @param {function} fn - The function to call for each item.
         * @param {object} [thisArg] - The value of `this` provided for the call to `fn`.
         * @param {boolean} [reverse] - If true, iterates backward on the loopable.
         */
        each: function (loopable, fn, thisArg, reverse) {
            var i, len, keys;
            if (helpers.isArray(loopable)) {
                len = loopable.length;
                if (reverse) {
                    for (i = len - 1; i >= 0; i--) {
                        fn.call(thisArg, loopable[i], i);
                    }
                } else {
                    for (i = 0; i < len; i++) {
                        fn.call(thisArg, loopable[i], i);
                    }
                }
            } else if (helpers.isObject(loopable)) {
                keys = Object.keys(loopable);
                len = keys.length;
                for (i = 0; i < len; i++) {
                    fn.call(thisArg, loopable[keys[i]], keys[i]);
                }
            }
        },

        /**
         * Returns true if the `a0` and `a1` arrays have the same content, else returns false.
         * @see https://stackoverflow.com/a/14853974
         * @param {Array} a0 - The array to compare
         * @param {Array} a1 - The array to compare
         * @returns {boolean}
         */
        arrayEquals: function (a0, a1) {
            var i, ilen, v0, v1;

            if (!a0 || !a1 || a0.length !== a1.length) {
                return false;
            }

            for (i = 0, ilen = a0.length; i < ilen; ++i) {
                v0 = a0[i];
                v1 = a1[i];

                if (v0 instanceof Array && v1 instanceof Array) {
                    if (!helpers.arrayEquals(v0, v1)) {
                        return false;
                    }
                } else if (v0 !== v1) {
                    // NOTE: two different object instances will never be equal: {x:20} != {x:20}
                    return false;
                }
            }

            return true;
        },

        /**
         * Returns a deep copy of `source` without keeping references on objects and arrays.
         * @param {*} source - The value to clone.
         * @returns {*}
         */
        clone: function (source) {
            if (helpers.isArray(source)) {
                return source.map(helpers.clone);
            }

            if (helpers.isObject(source)) {
                var target = {};
                var keys = Object.keys(source);
                var klen = keys.length;
                var k = 0;

                for (; k < klen; ++k) {
                    target[keys[k]] = helpers.clone(source[keys[k]]);
                }

                return target;
            }

            return source;
        },

        /**
         * The default merger when Chart.helpers.merge is called without merger option.
         * Note(SB): also used by mergeConfig and mergeScaleConfig as fallback.
         * @private
         */
        _merger: function (key, target, source, options) {
            var tval = target[key];
            var sval = source[key];

            if (helpers.isObject(tval) && helpers.isObject(sval)) {
                helpers.merge(tval, sval, options);
            } else {
                target[key] = helpers.clone(sval);
            }
        },

        /**
         * Merges source[key] in target[key] only if target[key] is undefined.
         * @private
         */
        _mergerIf: function (key, target, source) {
            var tval = target[key];
            var sval = source[key];

            if (helpers.isObject(tval) && helpers.isObject(sval)) {
                helpers.mergeIf(tval, sval);
            } else if (!target.hasOwnProperty(key)) {
                target[key] = helpers.clone(sval);
            }
        },

        /**
         * Recursively deep copies `source` properties into `target` with the given `options`.
         * IMPORTANT: `target` is not cloned and will be updated with `source` properties.
         * @param {object} target - The target object in which all sources are merged into.
         * @param {object|object[]} source - Object(s) to merge into `target`.
         * @param {object} [options] - Merging options:
         * @param {function} [options.merger] - The merge method (key, target, source, options)
         * @returns {object} The `target` object.
         */
        merge: function (target, source, options) {
            var sources = helpers.isArray(source) ? source : [source];
            var ilen = sources.length;
            var merge, i, keys, klen, k;

            if (!helpers.isObject(target)) {
                return target;
            }

            options = options || {};
            merge = options.merger || helpers._merger;

            for (i = 0; i < ilen; ++i) {
                source = sources[i];
                if (!helpers.isObject(source)) {
                    continue;
                }

                keys = Object.keys(source);
                for (k = 0, klen = keys.length; k < klen; ++k) {
                    merge(keys[k], target, source, options);
                }
            }

            return target;
        },

        /**
         * Recursively deep copies `source` properties into `target` *only* if not defined in target.
         * IMPORTANT: `target` is not cloned and will be updated with `source` properties.
         * @param {object} target - The target object in which all sources are merged into.
         * @param {object|object[]} source - Object(s) to merge into `target`.
         * @returns {object} The `target` object.
         */
        mergeIf: function (target, source) {
            return helpers.merge(target, source, { merger: helpers._mergerIf });
        },

        /**
         * Applies the contents of two or more objects together into the first object.
         * @param {object} target - The target object in which all objects are merged into.
         * @param {object} arg1 - Object containing additional properties to merge in target.
         * @param {object} argN - Additional objects containing properties to merge in target.
         * @returns {object} The `target` object.
         */
        extend: Object.assign || function (target) {
            return helpers.merge(target, [].slice.call(arguments, 1), {
                merger: function (key, dst, src) {
                    dst[key] = src[key];
                }
            });
        },

        /**
         * Basic javascript inheritance based on the model created in Backbone.js
         */
        inherits: function (extensions) {
            var me = this;
            var ChartElement = (extensions && extensions.hasOwnProperty('constructor')) ? extensions.constructor : function () {
                return me.apply(this, arguments);
            };

            var Surrogate = function () {
                this.constructor = ChartElement;
            };

            Surrogate.prototype = me.prototype;
            ChartElement.prototype = new Surrogate();
            ChartElement.extend = helpers.inherits;

            if (extensions) {
                helpers.extend(ChartElement.prototype, extensions);
            }

            ChartElement.__super__ = me.prototype;
            return ChartElement;
        },

        _deprecated: function (scope, value, previous, current) {
            if (value !== undefined) {
                console.warn(scope + ': "' + previous +
                    '" is deprecated. Please use "' + current + '" instead');
            }
        }
    };

    var helpers_core = helpers;

    // DEPRECATIONS

    /**
     * Provided for backward compatibility, use Chart.helpers.callback instead.
     * @function Chart.helpers.callCallback
     * @deprecated since version 2.6.0
     * @todo remove at version 3
     * @private
     */
    helpers.callCallback = helpers.callback;

    /**
     * Provided for backward compatibility, use Array.prototype.indexOf instead.
     * Array.prototype.indexOf compatibility: Chrome, Opera, Safari, FF1.5+, IE9+
     * @function Chart.helpers.indexOf
     * @deprecated since version 2.7.0
     * @todo remove at version 3
     * @private
     */
    helpers.indexOf = function (array, item, fromIndex) {
        return Array.prototype.indexOf.call(array, item, fromIndex);
    };

    /**
     * Provided for backward compatibility, use Chart.helpers.valueOrDefault instead.
     * @function Chart.helpers.getValueOrDefault
     * @deprecated since version 2.7.0
     * @todo remove at version 3
     * @private
     */
    helpers.getValueOrDefault = helpers.valueOrDefault;

    /**
     * Provided for backward compatibility, use Chart.helpers.valueAtIndexOrDefault instead.
     * @function Chart.helpers.getValueAtIndexOrDefault
     * @deprecated since version 2.7.0
     * @todo remove at version 3
     * @private
     */
    helpers.getValueAtIndexOrDefault = helpers.valueAtIndexOrDefault;

    /**
     * Easing functions adapted from Robert Penner's easing equations.
     * @namespace Chart.helpers.easingEffects
     * @see http://www.robertpenner.com/easing/
     */
    var effects = {
        linear: function (t) {
            return t;
        },

        easeInQuad: function (t) {
            return t * t;
        },

        easeOutQuad: function (t) {
            return -t * (t - 2);
        },

        easeInOutQuad: function (t) {
            if ((t /= 0.5) < 1) {
                return 0.5 * t * t;
            }
            return -0.5 * ((--t) * (t - 2) - 1);
        },

        easeInCubic: function (t) {
            return t * t * t;
        },

        easeOutCubic: function (t) {
            return (t = t - 1) * t * t + 1;
        },

        easeInOutCubic: function (t) {
            if ((t /= 0.5) < 1) {
                return 0.5 * t * t * t;
            }
            return 0.5 * ((t -= 2) * t * t + 2);
        },

        easeInQuart: function (t) {
            return t * t * t * t;
        },

        easeOutQuart: function (t) {
            return -((t = t - 1) * t * t * t - 1);
        },

        easeInOutQuart: function (t) {
            if ((t /= 0.5) < 1) {
                return 0.5 * t * t * t * t;
            }
            return -0.5 * ((t -= 2) * t * t * t - 2);
        },

        easeInQuint: function (t) {
            return t * t * t * t * t;
        },

        easeOutQuint: function (t) {
            return (t = t - 1) * t * t * t * t + 1;
        },

        easeInOutQuint: function (t) {
            if ((t /= 0.5) < 1) {
                return 0.5 * t * t * t * t * t;
            }
            return 0.5 * ((t -= 2) * t * t * t * t + 2);
        },

        easeInSine: function (t) {
            return -Math.cos(t * (Math.PI / 2)) + 1;
        },

        easeOutSine: function (t) {
            return Math.sin(t * (Math.PI / 2));
        },

        easeInOutSine: function (t) {
            return -0.5 * (Math.cos(Math.PI * t) - 1);
        },

        easeInExpo: function (t) {
            return (t === 0) ? 0 : Math.pow(2, 10 * (t - 1));
        },

        easeOutExpo: function (t) {
            return (t === 1) ? 1 : -Math.pow(2, -10 * t) + 1;
        },

        easeInOutExpo: function (t) {
            if (t === 0) {
                return 0;
            }
            if (t === 1) {
                return 1;
            }
            if ((t /= 0.5) < 1) {
                return 0.5 * Math.pow(2, 10 * (t - 1));
            }
            return 0.5 * (-Math.pow(2, -10 * --t) + 2);
        },

        easeInCirc: function (t) {
            if (t >= 1) {
                return t;
            }
            return -(Math.sqrt(1 - t * t) - 1);
        },

        easeOutCirc: function (t) {
            return Math.sqrt(1 - (t = t - 1) * t);
        },

        easeInOutCirc: function (t) {
            if ((t /= 0.5) < 1) {
                return -0.5 * (Math.sqrt(1 - t * t) - 1);
            }
            return 0.5 * (Math.sqrt(1 - (t -= 2) * t) + 1);
        },

        easeInElastic: function (t) {
            var s = 1.70158;
            var p = 0;
            var a = 1;
            if (t === 0) {
                return 0;
            }
            if (t === 1) {
                return 1;
            }
            if (!p) {
                p = 0.3;
            }
            if (a < 1) {
                a = 1;
                s = p / 4;
            } else {
                s = p / (2 * Math.PI) * Math.asin(1 / a);
            }
            return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t - s) * (2 * Math.PI) / p));
        },

        easeOutElastic: function (t) {
            var s = 1.70158;
            var p = 0;
            var a = 1;
            if (t === 0) {
                return 0;
            }
            if (t === 1) {
                return 1;
            }
            if (!p) {
                p = 0.3;
            }
            if (a < 1) {
                a = 1;
                s = p / 4;
            } else {
                s = p / (2 * Math.PI) * Math.asin(1 / a);
            }
            return a * Math.pow(2, -10 * t) * Math.sin((t - s) * (2 * Math.PI) / p) + 1;
        },

        easeInOutElastic: function (t) {
            var s = 1.70158;
            var p = 0;
            var a = 1;
            if (t === 0) {
                return 0;
            }
            if ((t /= 0.5) === 2) {
                return 1;
            }
            if (!p) {
                p = 0.45;
            }
            if (a < 1) {
                a = 1;
                s = p / 4;
            } else {
                s = p / (2 * Math.PI) * Math.asin(1 / a);
            }
            if (t < 1) {
                return -0.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t - s) * (2 * Math.PI) / p));
            }
            return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t - s) * (2 * Math.PI) / p) * 0.5 + 1;
        },
        easeInBack: function (t) {
            var s = 1.70158;
            return t * t * ((s + 1) * t - s);
        },

        easeOutBack: function (t) {
            var s = 1.70158;
            return (t = t - 1) * t * ((s + 1) * t + s) + 1;
        },

        easeInOutBack: function (t) {
            var s = 1.70158;
            if ((t /= 0.5) < 1) {
                return 0.5 * (t * t * (((s *= (1.525)) + 1) * t - s));
            }
            return 0.5 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2);
        },

        easeInBounce: function (t) {
            return 1 - effects.easeOutBounce(1 - t);
        },

        easeOutBounce: function (t) {
            if (t < (1 / 2.75)) {
                return 7.5625 * t * t;
            }
            if (t < (2 / 2.75)) {
                return 7.5625 * (t -= (1.5 / 2.75)) * t + 0.75;
            }
            if (t < (2.5 / 2.75)) {
                return 7.5625 * (t -= (2.25 / 2.75)) * t + 0.9375;
            }
            return 7.5625 * (t -= (2.625 / 2.75)) * t + 0.984375;
        },

        easeInOutBounce: function (t) {
            if (t < 0.5) {
                return effects.easeInBounce(t * 2) * 0.5;
            }
            return effects.easeOutBounce(t * 2 - 1) * 0.5 + 0.5;
        }
    };

    var helpers_easing = {
        effects: effects
    };

    // DEPRECATIONS

    /**
     * Provided for backward compatibility, use Chart.helpers.easing.effects instead.
     * @function Chart.helpers.easingEffects
     * @deprecated since version 2.7.0
     * @todo remove at version 3
     * @private
     */
    helpers_core.easingEffects = effects;

    var PI = Math.PI;
    var RAD_PER_DEG = PI / 180;
    var DOUBLE_PI = PI * 2;
    var HALF_PI = PI / 2;
    var QUARTER_PI = PI / 4;
    var TWO_THIRDS_PI = PI * 2 / 3;

    /**
     * @namespace Chart.helpers.canvas
     */
    var exports$1 = {
        /**
         * Clears the entire canvas associated to the given `chart`.
         * @param {Chart} chart - The chart for which to clear the canvas.
         */
        clear: function (chart) {
            chart.ctx.clearRect(0, 0, chart.width, chart.height);
        },

        /**
         * Creates a "path" for a rectangle with rounded corners at position (x, y) with a
         * given size (width, height) and the same `radius` for all corners.
         * @param {CanvasRenderingContext2D} ctx - The canvas 2D Context.
         * @param {number} x - The x axis of the coordinate for the rectangle starting point.
         * @param {number} y - The y axis of the coordinate for the rectangle starting point.
         * @param {number} width - The rectangle's width.
         * @param {number} height - The rectangle's height.
         * @param {number} radius - The rounded amount (in pixels) for the four corners.
         * @todo handle `radius` as top-left, top-right, bottom-right, bottom-left array/object?
         */
        roundedRect: function (ctx, x, y, width, height, radius) {
            if (radius) {
                var r = Math.min(radius, height / 2, width / 2);
                var left = x + r;
                var top = y + r;
                var right = x + width - r;
                var bottom = y + height - r;

                ctx.moveTo(x, top);
                if (left < right && top < bottom) {
                    ctx.arc(left, top, r, -PI, -HALF_PI);
                    ctx.arc(right, top, r, -HALF_PI, 0);
                    ctx.arc(right, bottom, r, 0, HALF_PI);
                    ctx.arc(left, bottom, r, HALF_PI, PI);
                } else if (left < right) {
                    ctx.moveTo(left, y);
                    ctx.arc(right, top, r, -HALF_PI, HALF_PI);
                    ctx.arc(left, top, r, HALF_PI, PI + HALF_PI);
                } else if (top < bottom) {
                    ctx.arc(left, top, r, -PI, 0);
                    ctx.arc(left, bottom, r, 0, PI);
                } else {
                    ctx.arc(left, top, r, -PI, PI);
                }
                ctx.closePath();
                ctx.moveTo(x, y);
            } else {
                ctx.rect(x, y, width, height);
            }
        },

        drawPoint: function (ctx, style, radius, x, y, rotation) {
            var type, xOffset, yOffset, size, cornerRadius;
            var rad = (rotation || 0) * RAD_PER_DEG;

            if (style && typeof style === 'object') {
                type = style.toString();
                if (type === '[object HTMLImageElement]' || type === '[object HTMLCanvasElement]') {
                    ctx.save();
                    ctx.translate(x, y);
                    ctx.rotate(rad);
                    ctx.drawImage(style, -style.width / 2, -style.height / 2, style.width, style.height);
                    ctx.restore();
                    return;
                }
            }

            if (isNaN(radius) || radius <= 0) {
                return;
            }

            ctx.beginPath();

            switch (style) {
                // Default includes circle
                default:
                    ctx.arc(x, y, radius, 0, DOUBLE_PI);
                    ctx.closePath();
                    break;
                case 'triangle':
                    ctx.moveTo(x + Math.sin(rad) * radius, y - Math.cos(rad) * radius);
                    rad += TWO_THIRDS_PI;
                    ctx.lineTo(x + Math.sin(rad) * radius, y - Math.cos(rad) * radius);
                    rad += TWO_THIRDS_PI;
                    ctx.lineTo(x + Math.sin(rad) * radius, y - Math.cos(rad) * radius);
                    ctx.closePath();
                    break;
                case 'rectRounded':
                    // NOTE: the rounded rect implementation changed to use `arc` instead of
                    // `quadraticCurveTo` since it generates better results when rect is
                    // almost a circle. 0.516 (instead of 0.5) produces results with visually
                    // closer proportion to the previous impl and it is inscribed in the
                    // circle with `radius`. For more details, see the following PRs:
                    // https://github.com/chartjs/Chart.js/issues/5597
                    // https://github.com/chartjs/Chart.js/issues/5858
                    cornerRadius = radius * 0.516;
                    size = radius - cornerRadius;
                    xOffset = Math.cos(rad + QUARTER_PI) * size;
                    yOffset = Math.sin(rad + QUARTER_PI) * size;
                    ctx.arc(x - xOffset, y - yOffset, cornerRadius, rad - PI, rad - HALF_PI);
                    ctx.arc(x + yOffset, y - xOffset, cornerRadius, rad - HALF_PI, rad);
                    ctx.arc(x + xOffset, y + yOffset, cornerRadius, rad, rad + HALF_PI);
                    ctx.arc(x - yOffset, y + xOffset, cornerRadius, rad + HALF_PI, rad + PI);
                    ctx.closePath();
                    break;
                case 'rect':
                    if (!rotation) {
                        size = Math.SQRT1_2 * radius;
                        ctx.rect(x - size, y - size, 2 * size, 2 * size);
                        break;
                    }
                    rad += QUARTER_PI;
                /* falls through */
                case 'rectRot':
                    xOffset = Math.cos(rad) * radius;
                    yOffset = Math.sin(rad) * radius;
                    ctx.moveTo(x - xOffset, y - yOffset);
                    ctx.lineTo(x + yOffset, y - xOffset);
                    ctx.lineTo(x + xOffset, y + yOffset);
                    ctx.lineTo(x - yOffset, y + xOffset);
                    ctx.closePath();
                    break;
                case 'crossRot':
                    rad += QUARTER_PI;
                /* falls through */
                case 'cross':
                    xOffset = Math.cos(rad) * radius;
                    yOffset = Math.sin(rad) * radius;
                    ctx.moveTo(x - xOffset, y - yOffset);
                    ctx.lineTo(x + xOffset, y + yOffset);
                    ctx.moveTo(x + yOffset, y - xOffset);
                    ctx.lineTo(x - yOffset, y + xOffset);
                    break;
                case 'star':
                    xOffset = Math.cos(rad) * radius;
                    yOffset = Math.sin(rad) * radius;
                    ctx.moveTo(x - xOffset, y - yOffset);
                    ctx.lineTo(x + xOffset, y + yOffset);
                    ctx.moveTo(x + yOffset, y - xOffset);
                    ctx.lineTo(x - yOffset, y + xOffset);
                    rad += QUARTER_PI;
                    xOffset = Math.cos(rad) * radius;
                    yOffset = Math.sin(rad) * radius;
                    ctx.moveTo(x - xOffset, y - yOffset);
                    ctx.lineTo(x + xOffset, y + yOffset);
                    ctx.moveTo(x + yOffset, y - xOffset);
                    ctx.lineTo(x - yOffset, y + xOffset);
                    break;
                case 'line':
                    xOffset = Math.cos(rad) * radius;
                    yOffset = Math.sin(rad) * radius;
                    ctx.moveTo(x - xOffset, y - yOffset);
                    ctx.lineTo(x + xOffset, y + yOffset);
                    break;
                case 'dash':
                    ctx.moveTo(x, y);
                    ctx.lineTo(x + Math.cos(rad) * radius, y + Math.sin(rad) * radius);
                    break;
            }

            ctx.fill();
            ctx.stroke();
        },

        /**
         * Returns true if the point is inside the rectangle
         * @param {object} point - The point to test
         * @param {object} area - The rectangle
         * @returns {boolean}
         * @private
         */
        _isPointInArea: function (point, area) {
            var epsilon = 1e-6; // 1e-6 is margin in pixels for accumulated error.

            return point.x > area.left - epsilon && point.x < area.right + epsilon &&
                point.y > area.top - epsilon && point.y < area.bottom + epsilon;
        },

        clipArea: function (ctx, area) {
            ctx.save();
            ctx.beginPath();
            ctx.rect(area.left, area.top, area.right - area.left, area.bottom - area.top);
            ctx.clip();
        },

        unclipArea: function (ctx) {
            ctx.restore();
        },

        lineTo: function (ctx, previous, target, flip) {
            var stepped = target.steppedLine;
            if (stepped) {
                if (stepped === 'middle') {
                    var midpoint = (previous.x + target.x) / 2.0;
                    ctx.lineTo(midpoint, flip ? target.y : previous.y);
                    ctx.lineTo(midpoint, flip ? previous.y : target.y);
                } else if ((stepped === 'after' && !flip) || (stepped !== 'after' && flip)) {
                    ctx.lineTo(previous.x, target.y);
                } else {
                    ctx.lineTo(target.x, previous.y);
                }
                ctx.lineTo(target.x, target.y);
                return;
            }

            if (!target.tension) {
                ctx.lineTo(target.x, target.y);
                return;
            }

            ctx.bezierCurveTo(
                flip ? previous.controlPointPreviousX : previous.controlPointNextX,
                flip ? previous.controlPointPreviousY : previous.controlPointNextY,
                flip ? target.controlPointNextX : target.controlPointPreviousX,
                flip ? target.controlPointNextY : target.controlPointPreviousY,
                target.x,
                target.y);
        }
    };

    var helpers_canvas = exports$1;

    // DEPRECATIONS

    /**
     * Provided for backward compatibility, use Chart.helpers.canvas.clear instead.
     * @namespace Chart.helpers.clear
     * @deprecated since version 2.7.0
     * @todo remove at version 3
     * @private
     */
    helpers_core.clear = exports$1.clear;

    /**
     * Provided for backward compatibility, use Chart.helpers.canvas.roundedRect instead.
     * @namespace Chart.helpers.drawRoundedRectangle
     * @deprecated since version 2.7.0
     * @todo remove at version 3
     * @private
     */
    helpers_core.drawRoundedRectangle = function (ctx) {
        ctx.beginPath();
        exports$1.roundedRect.apply(exports$1, arguments);
    };

    var defaults = {
        /**
         * @private
         */
        _set: function (scope, values) {
            return helpers_core.merge(this[scope] || (this[scope] = {}), values);
        }
    };

    // TODO(v3): remove 'global' from namespace.  all default are global and
    // there's inconsistency around which options are under 'global'
    defaults._set('global', {
        defaultColor: 'rgba(0,0,0,0.1)',
        defaultFontColor: '#666',
        defaultFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
        defaultFontSize: 12,
        defaultFontStyle: 'normal',
        defaultLineHeight: 1.2,
        showLines: true
    });

    var core_defaults = defaults;

    var valueOrDefault = helpers_core.valueOrDefault;

    /**
     * Converts the given font object into a CSS font string.
     * @param {object} font - A font object.
     * @return {string} The CSS font string. See https://developer.mozilla.org/en-US/docs/Web/CSS/font
     * @private
     */
    function toFontString(font) {
        if (!font || helpers_core.isNullOrUndef(font.size) || helpers_core.isNullOrUndef(font.family)) {
            return null;
        }

        return (font.style ? font.style + ' ' : '')
            + (font.weight ? font.weight + ' ' : '')
            + font.size + 'px '
            + font.family;
    }

    /**
     * @alias Chart.helpers.options
     * @namespace
     */
    var helpers_options = {
        /**
         * Converts the given line height `value` in pixels for a specific font `size`.
         * @param {number|string} value - The lineHeight to parse (eg. 1.6, '14px', '75%', '1.6em').
         * @param {number} size - The font size (in pixels) used to resolve relative `value`.
         * @returns {number} The effective line height in pixels (size * 1.2 if value is invalid).
         * @see https://developer.mozilla.org/en-US/docs/Web/CSS/line-height
         * @since 2.7.0
         */
        toLineHeight: function (value, size) {
            var matches = ('' + value).match(/^(normal|(\d+(?:\.\d+)?)(px|em|%)?)$/);
            if (!matches || matches[1] === 'normal') {
                return size * 1.2;
            }

            value = +matches[2];

            switch (matches[3]) {
                case 'px':
                    return value;
                case '%':
                    value /= 100;
                    break;
            }

            return size * value;
        },

        /**
         * Converts the given value into a padding object with pre-computed width/height.
         * @param {number|object} value - If a number, set the value to all TRBL component,
         *  else, if and object, use defined properties and sets undefined ones to 0.
         * @returns {object} The padding values (top, right, bottom, left, width, height)
         * @since 2.7.0
         */
        toPadding: function (value) {
            var t, r, b, l;

            if (helpers_core.isObject(value)) {
                t = +value.top || 0;
                r = +value.right || 0;
                b = +value.bottom || 0;
                l = +value.left || 0;
            } else {
                t = r = b = l = +value || 0;
            }

            return {
                top: t,
                right: r,
                bottom: b,
                left: l,
                height: t + b,
                width: l + r
            };
        },

        /**
         * Parses font options and returns the font object.
         * @param {object} options - A object that contains font options to be parsed.
         * @return {object} The font object.
         * @todo Support font.* options and renamed to toFont().
         * @private
         */
        _parseFont: function (options) {
            var globalDefaults = core_defaults.global;
            var size = valueOrDefault(options.fontSize, globalDefaults.defaultFontSize);
            var font = {
                family: valueOrDefault(options.fontFamily, globalDefaults.defaultFontFamily),
                lineHeight: helpers_core.options.toLineHeight(valueOrDefault(options.lineHeight, globalDefaults.defaultLineHeight), size),
                size: size,
                style: valueOrDefault(options.fontStyle, globalDefaults.defaultFontStyle),
                weight: null,
                string: ''
            };

            font.string = toFontString(font);
            return font;
        },

/**
 * Evaluates the given `inputs` sequentially and returns the first defined value.
 * @param {Array} inputs - An array of values, falling back to the last value.
 * @param {object} [context] - If defined and the current value is a function, the value
 * is called with `context` as first argument and the result becomes the new input.
 * @param {number} [index] - If defined and the current value is an array, the value
 * at `index` become the new input.
 * @param {object} [info] - object to return information about resolution in
 * @param {boolean} [info.cacheable] - W