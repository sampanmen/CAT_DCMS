//! moment.js
//! version : 2.9.0
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com

(function (undefined) {
    /************************************
        Constants
    ************************************/

    var moment,
        VERSION = '2.9.0',
        // the global-scope this is NOT the global object in Node.js
        globalScope = (typeof global !== 'undefined' && (typeof window === 'undefined' || window === global.window)) ? global : this,
        oldGlobalMoment,
        round = Math.round,
        hasOwnProperty = Object.prototype.hasOwnProperty,
        i,

        YEAR = 0,
        MONTH = 1,
        DATE = 2,
        HOUR = 3,
        MINUTE = 4,
        SECOND = 5,
        MILLISECOND = 6,

        // internal storage for locale config files
        locales = {},

        // extra moment internal properties (plugins register props here)
        momentProperties = [],

        // check for nodeJS
        hasModule = (typeof module !== 'undefined' && module && module.exports),

        // ASP.NET json date format regex
        aspNetJsonRegex = /^\/?Date\((\-?\d+)/i,
        aspNetTimeSpanJsonRegex = /(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/,

        // from http://docs.closure-library.googlecode.com/git/closure_goog_date_date.js.source.html
        // somewhat more in line with 4.4.3.2 2004 spec, but allows decimal anywhere
        isoDurationRegex = /^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/,

        // format tokens
        formattingTokens = /(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Q|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,4}|x|X|zz?|ZZ?|.)/g,
        localFormattingTokens = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,

        // parsing token regexes
        parseTokenOneOrTwoDigits = /\d\d?/, // 0 - 99
        parseTokenOneToThreeDigits = /\d{1,3}/, // 0 - 999
        parseTokenOneToFourDigits = /\d{1,4}/, // 0 - 9999
        parseTokenOneToSixDigits = /[+\-]?\d{1,6}/, // -999,999 - 999,999
        parseTokenDigits = /\d+/, // nonzero number of digits
        parseTokenWord = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i, // any word (or two) characters or numbers including two/three word month in arabic.
        parseTokenTimezone = /Z|[\+\-]\d\d:?\d\d/gi, // +00:00 -00:00 +0000 -0000 or Z
        parseTokenT = /T/i, // T (ISO separator)
        parseTokenOffsetMs = /[\+\-]?\d+/, // 1234567890123
        parseTokenTimestampMs = /[\+\-]?\d+(\.\d{1,3})?/, // 123456789 123456789.123

        //strict parsing regexes
        parseTokenOneDigit = /\d/, // 0 - 9
        parseTokenTwoDigits = /\d\d/, // 00 - 99
        parseTokenThreeDigits = /\d{3}/, // 000 - 999
        parseTokenFourDigits = /\d{4}/, // 0000 - 9999
        parseTokenSixDigits = /[+-]?\d{6}/, // -999,999 - 999,999
        parseTokenSignedNumber = /[+-]?\d+/, // -inf - inf

        // iso 8601 regex
        // 0000-00-00 0000-W00 or 0000-W00-0 + T + 00 or 00:00 or 00:00:00 or 00:00:00.000 + +00:00 or +0000 or +00)
        isoRegex = /^\s*(?:[+-]\d{6}|\d{4})-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,

        isoFormat = 'YYYY-MM-DDTHH:mm:ssZ',

        isoDates = [
            ['YYYYYY-MM-DD', /[+-]\d{6}-\d{2}-\d{2}/],
            ['YYYY-MM-DD', /\d{4}-\d{2}-\d{2}/],
            ['GGGG-[W]WW-E', /\d{4}-W\d{2}-\d/],
            ['GGGG-[W]WW', /\d{4}-W\d{2}/],
            ['YYYY-DDD', /\d{4}-\d{3}/]
        ],

        // iso time formats and regexes
        isoTimes = [
            ['HH:mm:ss.SSSS', /(T| )\d\d:\d\d:\d\d\.\d+/],
            ['HH:mm:ss', /(T| )\d\d:\d\d:\d\d/],
            ['HH:mm', /(T| )\d\d:\d\d/],
            ['HH', /(T| )\d\d/]
        ],

        // timezone chunker '+10:00' > ['10', '00'] or '-1530' > ['-', '15', '30']
        parseTimezoneChunker = /([\+\-]|\d\d)/gi,

        // getter and setter names
        proxyGettersAndSetters = 'Date|Hours|Minutes|Seconds|Milliseconds'.split('|'),
        unitMillisecondFactors = {
            'Milliseconds' : 1,
            'Seconds' : 1e3,
            'Minutes' : 6e4,
            'Hours' : 36e5,
            'Days' : 864e5,
            'Months' : 2592e6,
            'Years' : 31536e6
        },

        unitAliases = {
            ms : 'millisecond',
            s : 'second',
            m : 'minute',
            h : 'hour',
            d : 'day',
            D : 'date',
            w : 'week',
            W : 'isoWeek',
            M : 'month',
            Q : 'quarter',
            y : 'year',
            DDD : 'dayOfYear',
            e : 'weekday',
            E : 'isoWeekday',
            gg: 'weekYear',
            GG: 'isoWeekYear'
        },

        camelFunctions = {
            dayofyear : 'dayOfYear',
            isoweekday : 'isoWeekday',
            isoweek : 'isoWeek',
            weekyear : 'weekYear',
            isoweekyear : 'isoWeekYear'
        },

        // format function strings
        formatFunctions = {},

        // default relative time thresholds
        relativeTimeThresholds = {
            s: 45,  // seconds to minute
            m: 45,  // minutes to hour
            h: 22,  // hours to day
            d: 26,  // days to month
            M: 11   // months to year
        },

        // tokens to ordinalize and pad
        ordinalizeTokens = 'DDD w W M D d'.split(' '),
        paddedTokens = 'M D H h m s w W'.split(' '),

        formatTokenFunctions = {
            M    : function () {
                return this.month() + 1;
            },
            MMM  : function (format) {
                return this.localeData().monthsShort(this, format);
            },
            MMMM : function (format) {
                return this.localeData().months(this, format);
            },
            D    : function () {
                return this.date();
            },
            DDD  : function () {
                return this.dayOfYear();
            },
            d    : function () {
                return this.day();
            },
            dd   : function (format) {
                return this.localeData().weekdaysMin(this, format);
            },
            ddd  : function (format) {
                return this.localeData().weekdaysShort(this, format);
            },
            dddd : function (format) {
                return this.localeData().weekdays(this, format);
            },
            w    : function () {
                return this.week();
            },
            W    : function () {
                return this.isoWeek();
            },
            YY   : function () {
                return leftZeroFill(this.year() % 100, 2);
            },
            YYYY : function () {
                return leftZeroFill(this.year(), 4);
            },
            YYYYY : function () {
                return leftZeroFill(this.year(), 5);
            },
            YYYYYY : function () {
                var y = this.year(), sign = y >= 0 ? '+' : '-';
                return sign + leftZeroFill(Math.abs(y), 6);
            },
            gg   : function () {
                return leftZeroFill(this.weekYear() % 100, 2);
            },
            gggg : function () {
                return leftZeroFill(this.weekYear(), 4);
            },
            ggggg : function () {
                return leftZeroFill(this.weekYear(), 5);
            },
            GG   : function () {
                return leftZeroFill(this.isoWeekYear() % 100, 2);
            },
            GGGG : function () {
                return leftZeroFill(this.isoWeekYear(), 4);
            },
            GGGGG : function () {
                return leftZeroFill(this.isoWeekYear(), 5);
            },
            e : function () {
                return this.weekday();
            },
            E : function () {
                return this.isoWeekday();
            },
            a    : function () {
                return this.localeData().meridiem(this.hours(), this.minutes(), true);
            },
            A    : function () {
                return this.localeData().meridiem(this.hours(), this.minutes(), false);
            },
            H    : function () {
                return this.hours();
            },
            h    : function () {
                return this.hours() % 12 || 12;
            },
            m    : function () {
                return this.minutes();
            },
            s    : function () {
                return this.seconds();
            },
            S    : function () {
                return toInt(this.milliseconds() / 100);
            },
            SS   : function () {
                return leftZeroFill(toInt(this.milliseconds() / 10), 2);
            },
            SSS  : function () {
                return leftZeroFill(this.milliseconds(), 3);
            },
            SSSS : function () {
                return leftZeroFill(this.milliseconds(), 3);
            },
            Z    : function () {
                var a = this.utcOffset(),
                    b = '+';
                if (a < 0) {
                    a = -a;
                    b = '-';
                }
                return b + leftZeroFill(toInt(a / 60), 2) + ':' + leftZeroFill(toInt(a) % 60, 2);
            },
            ZZ   : function () {
                var a = this.utcOffset(),
                    b = '+';
                if (a < 0) {
                    a = -a;
                    b = '-';
                }
                return b + leftZeroFill(toInt(a / 60), 2) + leftZeroFill(toInt(a) % 60, 2);
            },
            z : function () {
                return this.zoneAbbr();
            },
            zz : function () {
                return this.zoneName();
            },
            x    : function () {
                return this.valueOf();
            },
            X    : function () {
                return this.unix();
            },
            Q : function () {
                return this.quarter();
            }
        },

        deprecations = {},

        lists = ['months', 'monthsShort', 'weekdays', 'weekdaysShort', 'weekdaysMin'],

        updateInProgress = false;

    // Pick the first defined of two or three arguments. dfl comes from
    // default.
    function dfl(a, b, c) {
        switch (arguments.length) {
            case 2: return a != null ? a : b;
            case 3: return a != null ? a : b != null ? b : c;
            default: throw new Error('Implement me');
        }
    }

    function hasOwnProp(a, b) {
        return hasOwnProperty.call(a, b);
    }

    function defaultParsingFlags() {
        // We need to deep clone this object, and es5 standard is not very
        // helpful.
        return {
            empty : false,
            unusedTokens : [],
            unusedInput : [],
            overflow : -2,
            charsLeftOver : 0,
            nullInput : false,
            invalidMonth : null,
            invalidFormat : false,
            userInvalidated : false,
            iso: false
        };
    }

    function printMsg(msg) {
        if (moment.suppressDeprecationWarnings === false &&
                typeof console !== 'undefined' && console.warn) {
            console.warn('Deprecation warning: ' + msg);
        }
    }

    function deprecate(msg, fn) {
        var firstTime = true;
        return extend(function () {
            if (firstTime) {
                printMsg(msg);
                firstTime = false;
            }
            return fn.apply(this, arguments);
        }, fn);
    }

    function deprecateSimple(name, msg) {
        if (!deprecations[name]) {
            printMsg(msg);
            deprecations[name] = true;
        }
    }

    function padToken(func, count) {
        return function (a) {
            return leftZeroFill(func.call(this, a), count);
        };
    }
    function ordinalizeToken(func, period) {
        return function (a) {
            return this.localeData().ordinal(func.call(this, a), period);
        };
    }

    function monthDiff(a, b) {
        // difference in months
        var wholeMonthDiff = ((b.year() - a.year()) * 12) + (b.month() - a.month()),
            // b is in (anchor - 1 month, anchor + 1 month)
            anchor = a.clone().add(wholeMonthDiff, 'months'),
            anchor2, adjust;

        if (b - anchor < 0) {
            anchor2 = a.clone().add(wholeMonthDiff - 1, 'months');
            // linear across the month
            adjust = (b - anchor) / (anchor - anchor2);
        } else {
            anchor2 = a.clone().add(wholeMonthDiff + 1, 'months');
            // linear across the month
            adjust = (b - anchor) / (anchor2 - anchor);
        }

        return -(wholeMonthDiff + adjust);
    }

    while (ordinalizeTokens.length) {
        i = ordinalizeTokens.pop();
        formatTokenFunctions[i + 'o'] = ordinalizeToken(formatTokenFunctions[i], i);
    }
    while (paddedTokens.length) {
        i = paddedTokens.pop();
        formatTokenFunctions[i + i] = padToken(formatTokenFunctions[i], 2);
    }
    formatTokenFunctions.DDDD = padToken(formatTokenFunctions.DDD, 3);


    function meridiemFixWrap(locale, hour, meridiem) {
        var isPm;

        if (meridiem == null) {
            // nothing to do
            return hour;
        }
        if (locale.meridiemHour != null) {
            return locale.meridiemHour(hour, meridiem);
        } else if (locale.isPM != null) {
            // Fallback
            isPm = locale.isPM(meridiem);
            if (isPm && hour < 12) {
                hour += 12;
            }
            if (!isPm && hour === 12) {
                hour = 0;
            }
            return hour;
        } else {
            // thie is not supposed to happen
            return hour;
        }
    }

    /************************************
        Constructors
    ************************************/

    function Locale() {
    }

    // Moment prototype object
    function Moment(config, skipOverflow) {
        if (skipOverflow !== false) {
            checkOverflow(config);
        }
        copyConfig(this, config);
        this._d = new Date(+config._d);
        // Prevent infinite loop in case updateOffset creates new moment
        // objects.
        if (updateInProgress === false) {
            updateInProgress = true;
            moment.updateOffset(this);
            updateInProgress = false;
        }
    }

    // Duration Constructor
    function Duration(duration) {
        var normalizedInput = normalizeObjectUnits(duration),
            years = normalizedInput.year || 0,
            quarters = normalizedInput.quarter || 0,
            months = normalizedInput.month || 0,
            weeks = normalizedInput.week || 0,
            days = normalizedInput.day || 0,
            hours = normalizedInput.hour || 0,
            minutes = normalizedInput.minute || 0,
            seconds = normalizedInput.second || 0,
            milliseconds = normalizedInput.millisecond || 0;

        // representation for dateAddRemove
        this._milliseconds = +milliseconds +
            seconds * 1e3 + // 1000
            minutes * 6e4 + // 1000 * 60
            hours * 36e5; // 1000 * 60 * 60
        // Because of dateAddRemove treats 24 hours as different from a
        // day when working around DST, we need to store them separately
        this._days = +days +
            weeks * 7;
        // It is impossible translate months into days without knowing
        // which months you are are talking about, so we have to store
        // it separately.
        this._months = +months +
            quarters * 3 +
            years * 12;

        this._data = {};

        this._locale = moment.localeData();

        this._bubble();
    }

    /************************************
        Helpers
    ************************************/


    function extend(a, b) {
        for (var i in b) {
            if (hasOwnProp(b, i)) {
                a[i] = b[i];
            }
        }

        if (hasOwnProp(b, 'toString')) {
            a.toString = b.toString;
        }

        if (hasOwnProp(b, 'valueOf')) {
            a.valueOf = b.valueOf;
        }

        return a;
    }

    function copyConfig(to, from) {
        var i, prop, val;

        if (typeof from._isAMomentObject !== 'undefined') {
            to._isAMomentObject = from._isAMomentObject;
        }
        if (typeof from._i !== 'undefined') {
            to._i = from._i;
        }
        if (typeof from._f !== 'undefined') {
            to._f = from._f;
        }
        if (typeof from._l !== 'undefined') {
            to._l = from._l;
        }
        if (typeof from._strict !== 'undefined') {
            to._strict = from._strict;
        }
        if (typeof from._tzm !== 'undefined') {
            to._tzm = from._tzm;
        }
        if (typeof from._isUTC !== 'undefined') {
            to._isUTC = from._isUTC;
        }
        if (typeof from._offset !== 'undefined') {
            to._offset = from._offset;
        }
        if (typeof from._pf !== 'undefined') {
            to._pf = from._pf;
        }
        if (typeof from._locale !== 'undefined') {
            to._locale = from._locale;
        }

        if (momentProperties.length > 0) {
            for (i in momentProperties) {
                prop = momentProperties[i];
                val = from[prop];
                if (typeof val !== 'undefined') {
                    to[prop] = val;
                }
            }
        }

        return to;
    }

    function absRound(number) {
        if (number < 0) {
            return Math.ceil(number);
        } else {
            return Math.floor(number);
        }
    }

    // left zero fill a number
    // see http://jsperf.com/left-zero-filling for performance comparison
    function leftZeroFill(number, targetLength, forceSign) {
        var output = '' + Math.abs(number),
            sign = number >= 0;

        while (output.length < targetLength) {
            output = '0' + output;
        }
        return (sign ? (forceSign ? '+' : '') : '-') + output;
    }

    function positiveMomentsDifference(base, other) {
        var res = {milliseconds: 0, months: 0};

        res.months = other.month() - base.month() +
            (other.year() - base.year()) * 12;
        if (base.clone().add(res.months, 'M').isAfter(other)) {
            --res.months;
        }

        res.milliseconds = +other - +(base.clone().add(res.months, 'M'));

        return res;
    }

    function momentsDifference(base, other) {
        var res;
        other = makeAs(other, base);
        if (base.isBefore(other)) {
            res = positiveMomentsDifference(base, other);
        } else {
            res = positiveMomentsDifference(other, base);
            res.milliseconds = -res.milliseconds;
            res.months = -res.months;
        }

        return res;
    }

    // TODO: remove 'name' arg after deprecation is removed
    function createAdder(direction, name) {
        return function (val, period) {
            var dur, tmp;
            //invert the arguments, but complain about it
            if (period !== null && !isNaN(+period)) {
                deprecateSimple(name, 'moment().' + name  + '(period, number) is deprecated. Please use moment().' + name + '(number, period).');
                tmp = val; val = period; period = tmp;
            }

            val = typeof val === 'string' ? +val : val;
            dur = moment.duration(val, period);
            addOrSubtractDurationFromMoment(this, dur, direction);
            return this;
        };
    }

    function addOrSubtractDurationFromMoment(mom, duration, isAdding, updateOffset) {
        var milliseconds = duration._milliseconds,
            days = duration._days,
            months = duration._months;
        updateOffset = updateOffset == null ? true : updateOffset;

        if (milliseconds) {
            mom._d.setTime(+mom._d + milliseconds * isAdding);
        }
        if (days) {
            rawSetter(mom, 'Date', rawGetter(mom, 'Date') + days * isAdding);
        }
        if (months) {
            rawMonthSetter(mom, rawGetter(mom, 'Month') + months * isAdding);
        }
        if (updateOffset) {
            moment.updateOffset(mom, days || months);
        }
    }

    // check if is an array
    function isArray(input) {
        return Object.prototype.toString.call(input) === '[object Array]';
    }

    function isDate(input) {
        return Object.prototype.toString.call(input) === '[object Date]' ||
            input instanceof Date;
    }

    // compare two arrays, return the number of differences
    function compareArrays(array1, array2, dontConvert) {
        var len = Math.min(array1.length, array2.length),
            lengthDiff = Math.abs(array1.length - array2.length),
            diffs = 0,
            i;
        for (i = 0; i < len; i++) {
            if ((dontConvert && array1[i] !== array2[i]) ||
                (!dontConvert && toInt(array1[i]) !== toInt(array2[i]))) {
                diffs++;
            }
        }
        return diffs + lengthDiff;
    }

    function normalizeUnits(units) {
        if (units) {
            var lowered = units.toLowerCase().replace(/(.)s$/, '$1');
            units = unitAliases[units] || camelFunctions[lowered] || lowered;
        }
        return units;
    }

    function normalizeObjectUnits(inputObject) {
        var normalizedInput = {},
            normalizedProp,
            prop;

        for (prop in inputObject) {
            if (hasOwnProp(inputObject, prop)) {
                normalizedProp = normalizeUnits(prop);
                if (normalizedProp) {
                    normalizedInput[normalizedProp] = inputObject[prop];
                }
            }
        }

        return normalizedInput;
    }

    function makeList(field) {
        var count, setter;

        if (field.indexOf('week') === 0) {
            count = 7;
            setter = 'day';
        }
        else if (field.indexOf('month') === 0) {
            count = 12;
            setter = 'month';
        }
        else {
            return;
        }

        moment[field] = function (format, index) {
            var i, getter,
                method = moment._locale[field],
                results = [];

            if (typeof format === 'number') {
                index = format;
                format = undefined;
            }

            getter = function (i) {
                var m = moment().utc().set(setter, i);
                return method.call(moment._locale, m, format || '');
            };

            if (index != null) {
                return getter(index);
            }
            else {
                for (i = 0; i < count; i++) {
                    results.push(getter(i));
                }
                return results;
            }
        };
    }

    function toInt(argumentForCoercion) {
        var coercedNumber = +argumentForCoercion,
            value = 0;

        if (coercedNumber !== 0 && isFinite(coercedNumber)) {
            if (coercedNumber >= 0) {
                value = Math.floor(coercedNumber);
            } else {
                value = Math.ceil(coercedNumber);
            }
        }

        return value;
    }

    function daysInMonth(year, month) {
        return new Date(Date.UTC(year, month + 1, 0)).getUTCDate();
    }

    function weeksInYear(year, dow, doy) {
        return weekOfYear(moment([year, 11, 31 + dow - doy]), dow, doy).week;
    }

    function daysInYear(year) {
        return isLeapYear(year) ? 366 : 365;
    }

    function isLeapYear(year) {
        return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
    }

    function checkOverflow(m) {
        var overflow;
        if (m._a && m._pf.overflow === -2) {
            overflow =
                m._a[MONTH] < 0 || m._a[MONTH] > 11 ? MONTH :
                m._a[DATE] < 1 || m._a[DATE] > daysInMonth(m._a[YEAR], m._a[MONTH]) ? DATE :
                m._a[HOUR] < 0 || m._a[HOUR] > 24 ||
                    (m._a[HOUR] === 24 && (m._a[MINUTE] !== 0 ||
                                           m._a[SECOND] !== 0 ||
                                           m._a[MILLISECOND] !== 0)) ? HOUR :
                m._a[MINUTE] < 0 || m._a[MINUTE] > 59 ? MINUTE :
                m._a[SECOND] < 0 || m._a[SECOND] > 59 ? SECOND :
                m._a[MILLISECOND] < 0 || m._a[MILLISECOND] > 999 ? MILLISECOND :
                -1;

            if (m._pf._overflowDayOfYear && (overflow < YEAR || overflow > DATE)) {
                overflow = DATE;
            }

            m._pf.overflow = overflow;
        }
    }

    function isValid(m) {
        if (m._isValid == null) {
            m._isValid = !isNaN(m._d.getTime()) &&
                m._pf.overflow < 0 &&
                !m._pf.empty &&
                !m._pf.invalidMonth &&
                !m._pf.nullInput &&
                !m._pf.invalidFormat &&
                !m._pf.userInvalidated;

            if (m._strict) {
                m._isValid = m._isValid &&
                    m._pf.charsLeftOver === 0 &&
                    m._pf.unusedTokens.length === 0 &&
                    m._pf.bigHour === undefined;
            }
        }
        return m._isValid;
    }

    function normalizeLocale(key) {
        return key ? key.toLowerCase().replace('_', '-') : key;
    }

    // pick the locale from the array
    // try ['en-au', 'en-gb'] as 'en-au', 'en-gb', 'en', as in move through the list trying each
    // substring from most specific to least, but move to the next array item if it's a more specific variant than the current root
    function chooseLocale(names) {
        var i = 0, j, next, locale, split;

        while (i < names.length) {
            split = normalizeLocale(names[i]).split('-');
            j = split.length;
            next = normalizeLocale(names[i + 1]);
            next = next ? next.split('-') : null;
            while (j > 0) {
                locale = loadLocale(split.slice(0, j).join('-'));
                if (locale) {
                    return locale;
                }
                if (next && next.length >= j && compareArrays(split, next, true) >= j - 1) {
                    //the next array item is better than a shallower substring of this one
                    break;
                }
                j--;
            }
            i++;
        }
        return null;
    }

    function loadLocale(name) {
        var oldLocale = null;
        if (!locales[name] && hasModule) {
            try {
                oldLocale = moment.locale();
                require('./locale/' + name);
                // because defineLocale currently also sets the global locale, we want to undo that for lazy loaded locales
                moment.locale(oldLocale);
            } catch (e) { }
        }
        return locales[name];
    }

    // Return a moment from input, that is local/utc/utcOffset equivalent to
    // model.
    function makeAs(input, model) {
        var res, diff;
        if (model._isUTC) {
            res = model.clone();
            diff = (moment.isMoment(input) || isDate(input) ?
                    +input : +moment(input)) - (+res);
            // Use low-level api, because this fn is low-level api.
            res._d.setTime(+res._d + diff);
            moment.updateOffset(res, false);
            return res;
        } else {
            return moment(input).local();
        }
    }

    /************************************
        Locale
    ************************************/


    extend(Locale.prototype, {

        set : function (config) {
            var prop, i;
            for (i in config) {
                prop = config[i];
                if (typeof prop === 'function') {
                    this[i] = prop;
                } else {
                    this['_' + i] = prop;
                }
            }
            // Lenient ordinal parsing accepts just a number in addition to
            // number + (possibly) stuff coming from _ordinalParseLenient.
            this._ordinalParseLenient = new RegExp(this._ordinalParse.source + '|' + /\d{1,2}/.source);
        },

        _months : 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
        months : function (m) {
            return this._months[m.month()];
        },

        _monthsShort : 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
        monthsShort : function (m) {
            return this._monthsShort[m.month()];
        },

        monthsParse : function (monthName, format, strict) {
            var i, mom, regex;

            if (!this._monthsParse) {
                this._monthsParse = [];
                this._longMonthsParse = [];
                this._shortMonthsParse = [];
            }

            for (i = 0; i < 12; i++) {
                // make the regex if we don't have it already
                mom = moment.utc([2000, i]);
                if (strict && !this._longMonthsParse[i]) {
                    this._longMonthsParse[i] = new RegExp('^' + this.months(mom, '').replace('.', '') + '$', 'i');
                    this._shortMonthsParse[i] = new RegExp('^' + this.monthsShort(mom, '').replace('.', '') + '$', 'i');
                }
                if (!strict && !this._monthsParse[i]) {
                    regex = '^' + this.months(mom, '') + '|^' + this.monthsShort(mom, '');
                    this._monthsParse[i] = new RegExp(regex.replace('.', ''), 'i');
                }
                // test the regex
                if (strict && format === 'MMMM' && this._longMonthsParse[i].test(monthName)) {
                    return i;
                } else if (strict && format === 'MMM' && this._shortMonthsParse[i].test(monthName)) {
                    return i;
                } else if (!strict && this._monthsParse[i].test(monthName)) {
                    return i;
                }
            }
        },

        _weekdays : 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
        weekdays : function (m) {
            return this._weekdays[m.day()];
        },

        _weekdaysShort : 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
        weekdaysShort : function (m) {
            return this._weekdaysShort[m.day()];
        },

        _weekdaysMin : 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
        weekdaysMin : function (m) {
            return this._weekdaysMin[m.day()];
        },

        weekdaysParse : function (weekdayName) {
            var i, mom, regex;

            if (!this._weekdaysParse) {
                this._weekdaysParse = [];
            }

            for (i = 0; i < 7; i++) {
                // make the regex if we don't have it already
                if (!this._weekdaysParse[i]) {
                    mom = moment([2000, 1]).day(i);
                    regex = '^' + this.weekdays(mom, '') + '|^' + this.weekdaysShort(mom, '') + '|^' + this.weekdaysMin(mom, '');
                    this._weekdaysParse[i] = new RegExp(regex.replace('.', ''), 'i');
                }
                // test the regex
                if (this._weekdaysParse[i].test(weekdayName)) {
                    return i;
                }
            }
        },

        _longDateFormat : {
            LTS : 'h:mm:ss A',
            LT : 'h:mm A',
            L : 'MM/DD/YYYY',
            LL : 'MMMM D, YYYY',
            LLL : 'MMMM D, YYYY LT',
            LLLL : 'dddd, MMMM D, YYYY LT'
        },
        longDateFormat : function (key) {
            var output = this._longDateFormat[key];
            if (!output && this._longDateFormat[key.toUpperCase()]) {
                output = this._longDateFormat[key.toUpperCase()].replace(/MMMM|MM|DD|dddd/g, function (val) {
                    return val.slice(1);
                });
                this._longDateFormat[key] = output;
            }
            return output;
        },

        isPM : function (input) {
            // IE8 Quirks Mode & IE7 Standards Mode do not allow accessing strings like arrays
            // Using charAt should be more compatible.
            return ((input + '').toLowerCase().charAt(0) === 'p');
        },

        _meridiemParse : /[ap]\.?m?\.?/i,
        meridiem : function (hours, minutes, isLower) {
            if (hours > 11) {
                return isLower ? 'pm' : 'PM';
            } else {
                return isLower ? 'am' : 'AM';
            }
        },


        _calendar : {
            sameDay : '[Today at] LT',
            nextDay : '[Tomorrow at] LT',
            nextWeek : 'dddd [at] LT',
            lastDay : '[Yesterday at] LT',
            lastWeek : '[Last] dddd [at] LT',
            sameElse : 'L'
        },
        calendar : function (key, mom, now) {
            var output = this._calendar[key];
            return typeof output === 'function' ? output.apply(mom, [now]) : output;
        },

        _relativeTime : {
            future : 'in %s',
            past : '%s ago',
            s : 'a few seconds',
            m : 'a minute',
            mm : '%d minutes',
            h : 'an hour',
            hh : '%d hours',
            d : 'a day',
            dd : '%d days',
            M : 'a month',
            MM : '%d months',
            y : 'a year',
            yy : '%d years'
        },

        relativeTime : function (number, withoutSuffix, string, isFuture) {
            var output = this._relativeTime[string];
            return (typeof output === 'function') ?
                output(number, withoutSuffix, string, isFuture) :
                output.replace(/%d/i, number);
        },

        pastFuture : function (diff, output) {
            var format = this._relativeTime[diff > 0 ? 'future' : 'past'];
            return typeof format === 'function' ? format(output) : format.replace(/%s/i, output);
        },

        ordinal : function (number) {
            return this._ordinal.replace('%d', number);
        },
        _ordinal : '%d',
        _ordinalParse : /\d{1,2}/,

        preparse : function (string) {
            return string;
        },

        postformat : function (string) {
            return string;
        },

        week : function (mom) {
            return weekOfYear(mom, this._week.dow, this._week.doy).week;
        },

        _week : {
            dow : 0, // Sunday is the first day of the week.
            doy : 6  // The week that contains Jan 1st is the first week of the year.
        },

        firstDayOfWeek : function () {
            return this._week.dow;
        },

        firstDayOfYear : function () {
            return this._week.doy;
        },

        _invalidDate: 'Invalid date',
        invalidDate: function () {
            return this._invalidDate;
        }
    });

    /************************************
        Formatting
    ************************************/


    function removeFormattingTokens(input) {
        if (input.match(/\[[\s\S]/)) {
            return input.replace(/^\[|\]$/g, '');
        }
        return input.replace(/\\/g, '');
    }

    function makeFormatFunction(format) {
        var array = format.match(formattingTokens), i, length;

        for (i = 0, length = array.length; i < length; i++) {
            if (formatTokenFunctions[array[i]]) {
                array[i] = formatTokenFunctions[array[i]];
            } else {
                array[i] = removeFormattingTokens(array[i]);
            }
        }

        return function (mom) {
            var output = '';
            for (i = 0; i < length; i++) {
                output += array[i] instanceof Function ? array[i].call(mom, format) : array[i];
            }
            return output;
        };
    }

    // format date using native date object
    function formatMoment(m, format) {
        if (!m.isValid()) {
            return m.localeData().invalidDate();
        }

        format = expandFormat(format, m.localeData());

        if (!formatFunctions[format]) {
            formatFunctions[format] = makeFormatFunction(format);
        }

        return formatFunctions[format](m);
    }

    function expandFormat(format, locale) {
        var i = 5;

        function replaceLongDateFormatTokens(input) {
            return locale.longDateFormat(input) || input;
        }

        localFormattingTokens.lastIndex = 0;
        while (i >= 0 && localFormattingTokens.test(format)) {
            format = format.replace(localFormattingTokens, replaceLongDateFormatTokens);
            localFormattingTokens.lastIndex = 0;
            i -= 1;
        }

        return format;
    }


    /************************************
        Parsing
    ************************************/


    // get the regex to find the next token
    function getParseRegexForToken(token, config) {
        var a, strict = config._strict;
        switch (token) {
        case 'Q':
            return parseTokenOneDigit;
        case 'DDDD':
            return parseTokenThreeDigits;
        case 'YYYY':
        case 'GGGG':
        case 'gggg':
            return strict ? parseTokenFourDigits : parseTokenOneToFourDigits;
        case 'Y':
        case 'G':
        case 'g':
            return parseTokenSignedNumber;
        case 'YYYYYY':
        case 'YYYYY':
        case 'GGGGG':
        case 'ggggg':
            return strict ? parseTokenSixDigits : parseTokenOneToSixDigits;
        case 'S':
            if (strict) {
                return parseTokenOneDigit;
            }
            /* falls through */
        case 'SS':
            if (strict) {
                return parseTokenTwoDigits;
            }
            /* falls through */
        case 'SSS':
            if (strict) {
                return parseTokenThreeDigits;
            }
            /* falls through */
        case 'DDD':
            return parseTokenOneToThreeDigits;
        case 'MMM':
        case 'MMMM':
        case 'dd':
        case 'ddd':
        case 'dddd':
            return parseTokenWord;
        case 'a':
        case 'A':
            return config._locale._meridiemParse;
        case 'x':
            return parseTokenOffsetMs;
        case 'X':
            return parseTokenTimestampMs;
        case 'Z':
        case 'ZZ':
            return parseTokenTimezone;
        case 'T':
            return parseTokenT;
        case 'SSSS':
            return parseTokenDigits;
        case 'MM':
        case 'DD':
        case 'YY':
        case 'GG':
        case 'gg':
        case 'HH':
        case 'hh':
        case 'mm':
        case 'ss':
        case 'ww':
        case 'WW':
            return strict ? parseTokenTwoDigits : parseTokenOneOrTwoDigits;
        case 'M':
        case 'D':
        case 'd':
        case 'H':
        case 'h':
        case 'm':
        case 's':
        case 'w':
        case 'W':
        case 'e':
        case 'E':
            return parseTokenOneOrTwoDigits;
        case 'Do':
            return strict ? config._locale._ordinalParse : config._locale._ordinalParseLenient;
        default :
            a = new RegExp(regexpEscape(unescapeFormat(token.replace('\\', '')), 'i'));
            return a;
        }
    }

    function utcOffsetFromString(string) {
        string = string || '';
        var possibleTzMatches = (string.match(parseTokenTimezone) || []),
            tzChunk = possibleTzMatches[possibleTzMatches.length - 1] || [],
            parts = (tzChunk + '').match(parseTimezoneChunker) || ['-', 0, 0],
            minutes = +(parts[1] * 60) + toInt(parts[2]);

        return parts[0] === '+' ? minutes : -minutes;
    }

    // function to convert string input to date
    function addTimeToArrayFromToken(token, input, config) {
        var a, datePartArray = config._a;

        switch (token) {
        // QUARTER
        case 'Q':
            if (input != null) {
                datePartArray[MONTH] = (toInt(input) - 1) * 3;
            }
            break;
        // MONTH
        case 'M' : // fall through to MM
        case 'MM' :
            if (input != null) {
                datePartArray[MONTH] = toInt(input) - 1;
            }
            break;
        case 'MMM' : // fall through to MMMM
        case 'MMMM' :
            a = config._locale.monthsParse(input, token, config._strict);
            // if we didn't find a month name, mark the date as invalid.
            if (a != null) {
                datePartArray[MONTH] = a;
            } else {
                config._pf.invalidMonth = input;
            }
            break;
        // DAY OF MONTH
        case 'D' : // fall through to DD
        case 'DD' :
            if (input != null) {
                datePartArray[DATE] = toInt(input);
            }
            break;
        case 'Do' :
            if (input != null) {
                datePartArray[DATE] = toInt(parseInt(
                            input.match(/\d{1,2}/)[0], 10));
            }
            break;
        // DAY OF YEAR
        case 'DDD' : // fall through to DDDD
        case 'DDDD' :
            if (input != null) {
                config._dayOfYear = toInt(input);
            }

            break;
        // YEAR
        case 'YY' :
            datePartArray[YEAR] = moment.parseTwoDigitYear(input);
            break;
        case 'YYYY' :
        case 'YYYYY' :
        case 'YYYYYY' :
            datePartArray[YEAR] = toInt(input);
            break;
        // AM / PM
        case 'a' : // fall through to A
        case 'A' :
            config._meridiem = input;
            // config._isPm = config._locale.isPM(input);
            break;
        // HOUR
        case 'h' : // fall through to hh
        case 'hh' :
            config._pf.bigHour = true;
            /* falls through */
        case 'H' : // fall through to HH
        case 'HH' :
            datePartArray[HOUR] = toInt(input);
            break;
        // MINUTE
        case 'm' : // fall through to mm
        case 'mm' :
            datePartArray[MINUTE] = toInt(input);
            break;
        // SECOND
        case 's' : // fall through to ss
        case 'ss' :
            datePartArray[SECOND] = toInt(input);
            break;
        // MILLISECOND
        case 'S' :
        case 'SS' :
        case 'SSS' :
        case 'SSSS' :
            datePartArray[MILLISECOND] = toInt(('0.' + input) * 1000);
            break;
        // UNIX OFFSET (MILLISECONDS)
        case 'x':
            config._d = new Date(toInt(input));
            break;
        // UNIX TIMESTAMP WITH MS
        case 'X':
            config._d = new Date(parseFloat(input) * 1000);
            break;
        // TIMEZONE
        case 'Z' : // fall through to ZZ
        case 'ZZ' :
            config._useUTC = true;
            config._tzm = utcOffsetFromString(input);
            break;
        // WEEKDAY - human
        case 'dd':
        case 'ddd':
        case 'dddd':
            a = config._locale.weekdaysParse(input);
            // if we didn't get a weekday name, mark the date as invalid
            if (a != null) {
                config._w = config._w || {};
                config._w['d'] = a;
            } else {
                config._pf.invalidWeekday = input;
            }
            break;
        // WEEK, WEEK DAY - numeric
        case 'w':
        case 'ww':
        case 'W':
        case 'WW':
        case 'd':
        case 'e':
        case 'E':
            token = token.substr(0, 1);
            /* falls through */
        case 'gggg':
        case 'GGGG':
        case 'GGGGG':
            token = token.substr(0, 2);
            if (input) {
                config._w = config._w || {};
                config._w[token] = toInt(input);
            }
            break;
        case 'gg':
        case 'GG':
            config._w = config._w || {};
            config._w[token] = moment.parseTwoDigitYear(input);
        }
    }

    function dayOfYearFromWeekInfo(config) {
        var w, weekYear, week, weekday, dow, doy, temp;

        w = config._w;
        if (w.GG != null || w.W != null || w.E != null) {
            dow = 1;
            doy = 4;

            // TODO: We need to take the current isoWeekYear, but that depends on
            // how we interpret now (local, utc, fixed offset). So create
            // a now version of current config (take local/utc/offset flags, and
            // create now).
            weekYear = dfl(w.GG, config._a[YEAR], weekOfYear(moment(), 1, 4).year);
            week = dfl(w.W, 1);
            weekday = dfl(w.E, 1);
        } else {
            dow = config._locale._week.dow;
            doy = config._locale._week.doy;

            weekYear = dfl(w.gg, config._a[YEAR], weekOfYear(moment(), dow, doy).year);
            week = dfl(w.w, 1);

            if (w.d != null) {
                // weekday -- low day numbers are considered next week
                weekday = w.d;
                if (weekday < dow) {
                    ++week;
                }
            } else if (w.e != null) {
                // local weekday -- counting starts from begining of week
                weekday = w.e + dow;
            } else {
                // default to begining of week
                weekday = dow;
            }
        }
        temp = dayOfYearFromWeeks(weekYear, week, weekday, doy, dow);

        config._a[YEAR] = temp.year;
        config._dayOfYear = temp.dayOfYear;
    }

    // convert an array to a date.
    // the array should mirror the parameters below
    // note: all values past the year are optional and will default to the lowest possible value.
    // [year, month, day , hour, minute, second, millisecond]
    function dateFromConfig(config) {
        var i, date, input = [], currentDate, yearToUse;

        if (config._d) {
            return;
        }

        currentDate = currentDateArray(config);

        //compute day of the year from weeks and weekdays
        if (config._w && config._a[DATE] == null && config._a[MONTH] == null) {
            dayOfYearFromWeekInfo(config);
        }

        //if the day of the year is set, figure out what it is
        if (config._dayOfYear) {
            yearToUse = dfl(config._a[YEAR], currentDate[YEAR]);

            if (config._dayOfYear > daysInYear(yearToUse)) {
                config._pf._overflowDayOfYear = true;
            }

            date = makeUTCDate(yearToUse, 0, config._dayOfYear);
            config._a[MONTH] = date.getUTCMonth();
            config._a[DATE] = date.getUTCDate();
        }

        // Default to current date.
        // * if no year, month, day of month are given, default to today
        // * if day of month is given, default month and year
        // * if month is given, default only year
        // * if year is given, don't default anything
        for (i = 0; i < 3 && config._a[i] == null; ++i) {
            config._a[i] = input[i] = currentDate[i];
        }

        // Zero out whatever was not defaulted, including time
        for (; i < 7; i++) {
            config._a[i] = input[i] = (config._a[i] == null) ? (i === 2 ? 1 : 0) : config._a[i];
        }

        // Check for 24:00:00.000
        if (config._a[HOUR] === 24 &&
                config._a[MINUTE] === 0 &&
                config._a[SECOND] === 0 &&
                config._a[MILLISECOND] === 0) {
            config._nextDay = true;
            config._a[HOUR] = 0;
        }

        config._d = (config._useUTC ? makeUTCDate : makeDate).apply(null, input);
        // Apply timezone offset from input. The actual utcOffset can be changed
        // with parseZone.
        if (config._tzm != null) {
            config._d.setUTCMinutes(config._d.getUTCMinutes() - config._tzm);
        }

        if (config._nextDay) {
            config._a[HOUR] = 24;
        }
    }

    function dateFromObject(config) {
        var normalizedInput;

        if (config._d) {
            return;
        }

        normalizedInput = normalizeObjectUnits(config._i);
        config._a = [
            normalizedInput.year,
            normalizedInput.month,
            normalizedInput.day || normalizedInput.date,
            normalizedInput.hour,
            normalizedInput.minute,
            normalizedInput.second,
            normalizedInput.millisecond
        ];

        dateFromConfig(config);
    }

    function currentDateArray(config) {
        var now = new Date();
        if (config._useUTC) {
            return [
                now.getUTCFullYear(),
                now.getUTCMonth(),
                now.getUTCDate()
            ];
        } else {
            return [now.getFullYear(), now.getMonth(), now.getDate()];
        }
    }

    // date from string and format string
    function makeDateFromStringAndFormat(config) {
        if (config._f === moment.ISO_8601) {
            parseISO(config);
            return;
        }

        config._a = [];
        config._pf.empty = true;

        // This array is used to make a Date, either with `new Date` or `Date.UTC`
        var string = '' + config._i,
            i, parsedInput, tokens, token, skipped,
            stringLength = string.length,
            totalParsedInputLength = 0;

        tokens = expandFormat(config._f, config._locale).match(formattingTokens) || [];

        for (i = 0; i < tokens.length; i++) {
            token = tokens[i];
            parsedInput = (string.match(getParseRegexForToken(token, config)) || [])[0];
            if (parsedInput) {
                skipped = string.substr(0, string.indexOf(parsedInput));
                if (skipped.length > 0) {
                    config._pf.unusedInput.push(skipped);
                }
                string = string.slice(string.indexOf(parsedInput) + parsedInput.length);
                totalParsedInputLength += parsedInput.length;
            }
            // don't parse if it's not a known token
            if (formatTokenFunctions[token]) {
                if (parsedInput) {
                    config._pf.empty = false;
                }
                else {
                    config._pf.unusedTokens.push(token);
                }
                addTimeToArrayFromToken(token, parsedInput, config);
            }
            else if (config._strict && !parsedInput) {
                config._pf.unusedTokens.push(token);
            }
        }

        // add remaining unparsed input length to the string
        config._pf.charsLeftOver = stringLength - totalParsedInputLength;
        if (string.length > 0) {
            config._pf.unusedInput.push(string);
        }

        // clear _12h flag if hour is <= 12
        if (config._pf.bigHour === true && config._a[HOUR] <= 12) {
            config._pf.bigHour = undefined;
        }
        // handle meridiem
        config._a[HOUR] = meridiemFixWrap(config._locale, config._a[HOUR],
                config._meridiem);
        dateFromConfig(config);
        checkOverflow(config);
    }

    function unescapeFormat(s) {
        return s.replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (matched, p1, p2, p3, p4) {
            return p1 || p2 || p3 || p4;
        });
    }

    // Code from http://stackoverflow.com/questions/3561493/is-there-a-regexp-escape-function-in-javascript
    function regexpEscape(s) {
        return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    // date from string and array of format strings
    function makeDateFromStringAndArray(config) {
        var tempConfig,
            bestMoment,

            scoreToBeat,
            i,
            currentScore;

        if (config._f.length === 0) {
            config._pf.invalidFormat = true;
            config._d = new Date(NaN);
            return;
        }

        for (i = 0; i < config._f.length; i++) {
            currentScore = 0;
            tempConfig = copyConfig({}, config);
            if (config._useUTC != null) {
                tempConfig._useUTC = config._useUTC;
            }
            tempConfig._pf = defaultParsingFlags();
            tempConfig._f = config._f[i];
            makeDateFromStringAndFormat(tempConfig);

            if (!isValid(tempConfig)) {
                continue;
            }

            // if there is any input that was not parsed add a penalty for that format
            currentScore += tempConfig._pf.charsLeftOver;

            //or tokens
            currentScore += tempConfig._pf.unusedTokens.length * 10;

            tempConfig._pf.score = currentScore;

            if (scoreToBeat == null || currentScore < scoreToBeat) {
                scoreToBeat = currentScore;
                bestMoment = tempConfig;
            }
        }

        extend(config, bestMoment || tempConfig);
    }

    // date from iso format
    function parseISO(config) {
        var i, l,
            string = config._i,
            match = isoRegex.exec(string);

        if (match) {
            config._pf.iso = true;
            for (i = 0, l = isoDates.length; i < l; i++) {
                if (isoDates[i][1].exec(string)) {
                    // match[5] should be 'T' or undefined
                    config._f = isoDates[i][0] + (match[6] || ' ');
                    break;
                }
            }
            for (i = 0, l = isoTimes.length; i < l; i++) {
                if (isoTimes[i][1].exec(string)) {
                    config._f += isoTimes[i][0];
                    break;
                }
            }
            if (string.match(parseTokenTimezone)) {
                config._f += 'Z';
            }
            makeDateFromStringAndFormat(config);
        } else {
            config._isValid = false;
        }
    }

    // date from iso format or fallback
    function makeDateFromString(config) {
        parseISO(config);
        if (config._isValid === false) {
            delete config._isValid;
            moment.createFromInputFallback(config);
        }
    }

    function map(arr, fn) {
        var res = [], i;
        for (i = 0; i < arr.length; ++i) {
            res.push(fn(arr[i], i));
        }
        return res;
    }

    function makeDateFromInput(config) {
        var input = config._i, matched;
        if (input === undefined) {
            config._d = new Date();
        } else if (isDate(input)) {
            config._d = new Date(+input);
        } else if ((matched = aspNetJsonRegex.exec(input)) !== null) {
            config._d = new Date(+matched[1]);
        } else if (typeof input === 'string') {
            makeDateFromString(config);
        } else if (isArray(input)) {
            config._a = map(input.slice(0), function (obj) {
                return parseInt(obj, 10);
            });
            dateFromConfig(config);
        } else if (typeof(input) === 'object') {
            dateFromObject(config);
        } else if (typeof(input) === 'number') {
            // from milliseconds
            config._d = new Date(input);
        } else {
            moment.createFromInputFallback(config);
        }
    }

    function makeDate(y, m, d, h, M, s, ms) {
        //can't just apply() to create a date:
        //http://stackoverflow.com/questions/181348/instantiating-a-javascript-object-by-calling-prototype-constructor-apply
        var date = new Date(y, m, d, h, M, s, ms);

        //the date constructor doesn't accept years < 1970
        if (y < 1970) {
            date.setFullYear(y);
        }
        return date;
    }

    function makeUTCDate(y) {
        var date = new Date(Date.UTC.apply(null, arguments));
        if (y < 1970) {
            date.setUTCFullYear(y);
        }
        return date;
    }

    function parseWeekday(input, locale) {
        if (typeof input === 'string') {
            if (!isNaN(input)) {
                input = parseInt(input, 10);
            }
            else {
                input = locale.weekdaysParse(input);
                if (typeof input !== 'number') {
                    return null;
                }
            }
        }
        return input;
    }

    /************************************
        Relative Time
    ************************************/


    // helper function for moment.fn.from, moment.fn.fromNow, and moment.duration.fn.humanize
    function substituteTimeAgo(string, number, withoutSuffix, isFuture, locale) {
        return locale.relativeTime(number || 1, !!withoutSuffix, string, isFuture);
    }

    function relativeTime(posNegDuration, withoutSuffix, locale) {
        var duration = moment.duration(posNegDuration).abs(),
            seconds = round(duration.as('s')),
            minutes = round(duration.as('m')),
            hours = round(duration.as('h')),
            days = round(duration.as('d')),
            months = round(duration.as('M')),
            years = round(duration.as('y')),

            args = seconds < relativeTimeThresholds.s && ['s', seconds] ||
                minutes === 1 && ['m'] ||
                minutes < relativeTimeThresholds.m && ['mm', minutes] ||
                hours === 1 && ['h'] ||
                hours < relativeTimeThresholds.h && ['hh', hours] ||
                days === 1 && ['d'] ||
                days < relativeTimeThresholds.d && ['dd', days] ||
                months === 1 && ['M'] ||
                months < relativeTimeThresholds.M && ['MM', months] ||
                years === 1 && ['y'] || ['yy', years];

        args[2] = withoutSuffix;
        args[3] = +posNegDuration > 0;
        args[4] = locale;
        return substituteTimeAgo.apply({}, args);
    }


    /************************************
        Week of Year
    ************************************/


    // firstDayOfWeek       0 = sun, 6 = sat
    //                      the day of the week that starts the week
    //                      (usually sunday or monday)
    // firstDayOfWeekOfYear 0 = sun, 6 = sat
    //                      the first week is the week that contains the first
    //                      of this day of the week
    //                      (eg. ISO weeks use thursday (4))
    function weekOfYear(mom, firstDayOfWeek, firstDayOfWeekOfYear) {
        var end = firstDayOfWeekOfYear - firstDayOfWeek,
            daysToDayOfWeek = firstDayOfWeekOfYear - mom.day(),
            adjustedMoment;


        if (daysToDayOfWeek > end) {
            daysToDayOfWeek -= 7;
        }

        if (daysToDayOfWeek < end - 7) {
            daysToDayOfWeek += 7;
        }

        adjustedMoment = moment(mom).add(daysToDayOfWeek, 'd');
        return {
            week: Math.ceil(adjustedMoment.dayOfYear() / 7),
            year: adjustedMoment.year()
        };
    }

    //http://en.wikipedia.org/wiki/ISO_week_date#Calculating_a_date_given_the_year.2C_week_number_and_weekday
    function dayOfYearFromWeeks(year, week, weekday, firstDayOfWeekOfYear, firstDayOfWeek) {
        var d = makeUTCDate(year, 0, 1).getUTCDay(), daysToAdd, dayOfYear;

        d = d === 0 ? 7 : d;
        weekday = weekday != null ? weekday : firstDayOfWeek;
        daysToAdd = firstDayOfWeek - d + (d > firstDayOfWeekOfYear ? 7 : 0) - (d < firstDayOfWeek ? 7 : 0);
        dayOfYear = 7 * (week - 1) + (weekday - firstDayOfWeek) + daysToAdd + 1;

        return {
            year: dayOfYear > 0 ? year : year - 1,
            dayOfYear: dayOfYear > 0 ?  dayOfYear : daysInYear(year - 1) + dayOfYear
        };
    }

    /************************************
        Top Level Functions
    ************************************/

    function makeMoment(config) {
        var input = config._i,
            format = config._f,
            res;

        config._locale = config._locale || moment.localeData(config._l);

        if (input === null || (format === undefined && input === '')) {
            return moment.invalid({nullInput: true});
        }

        if (typeof input === 'string') {
            config._i = input = config._locale.preparse(input);
        }

        if (moment.isMoment(input)) {
            return new Moment(input, true);
        } else if (format) {
            if (isArray(format)) {
                makeDateFromStringAndArray(config);
            } else {
                makeDateFromStringAndFormat(config);
            }
        } else {
            makeDateFromInput(config);
        }

        res = new Moment(config);
        if (res._nextDay) {
            // Adding is smart enough around DST
            res.add(1, 'd');
            res._nextDay = undefined;
        }

        return res;
    }

    moment = function (input, format, locale, strict) {
        var c;

        if (typeof(locale) === 'boolean') {
            strict = locale;
            locale = undefined;
        }
        // object construction must be done this way.
        // https://github.com/moment/moment/issues/1423
        c = {};
        c._isAMomentObject = true;
        c._i = input;
        c._f = format;
        c._l = locale;
        c._strict = strict;
        c._isUTC = false;
        c._pf = defaultParsingFlags();

        return makeMoment(c);
    };

    moment.suppressDeprecationWarnings = false;

    moment.createFromInputFallback = deprecate(
        'moment construction falls back to js Date. This is ' +
        'discouraged and will be removed in upcoming major ' +
        'release. Please refer to ' +
        'https://github.com/moment/moment/issues/1407 for more info.',
        function (config) {
            config._d = new Date(config._i + (config._useUTC ? ' UTC' : ''));
        }
    );

    // Pick a moment m from moments so that m[fn](other) is true for all
    // other. This relies on the function fn to be transitive.
    //
    // moments should either be an array of moment objects or an array, whose
    // first element is an array of moment objects.
    function pickBy(fn, moments) {
        var res, i;
        if (moments.length === 1 && isArray(moments[0])) {
            moments = moments[0];
        }
        if (!moments.length) {
            return moment();
        }
        res = moments[0];
        for (i = 1; i < moments.length; ++i) {
            if (moments[i][fn](res)) {
                res = moments[i];
            }
        }
        return res;
    }

    moment.min = function () {
        var args = [].slice.call(arguments, 0);

        return pickBy('isBefore', args);
    };

    moment.max = function () {
        var args = [].slice.call(arguments, 0);

        return pickBy('isAfter', args);
    };

    // creating with utc
    moment.utc = function (input, format, locale, strict) {
        var c;

        if (typeof(locale) === 'boolean') {
            strict = locale;
            locale = undefined;
        }
        // object construction must be done this way.
        // https://github.com/moment/moment/issues/1423
        c = {};
        c._isAMomentObject = true;
        c._useUTC = true;
        c._isUTC = true;
        c._l = locale;
        c._i = input;
        c._f = format;
        c._strict = strict;
        c._pf = defaultParsingFlags();

        return makeMoment(c).utc();
    };

    // creating with unix timestamp (in seconds)
    moment.unix = function (input) {
        return moment(input * 1000);
    };

    // duration
    moment.duration = function (input, key) {
        var duration = input,
            // matching against regexp is expensive, do it on demand
            match = null,
            sign,
            ret,
            parseIso,
            diffRes;

        if (moment.isDuration(input)) {
            duration = {
                ms: input._milliseconds,
                d: input._days,
                M: input._months
            };
        } else if (typeof input === 'number') {
            duration = {};
            if (key) {
                duration[key] = input;
            } else {
                duration.milliseconds = input;
            }
        } else if (!!(match = aspNetTimeSpanJsonRegex.exec(input))) {
            sign = (match[1] === '-') ? -1 : 1;
            duration = {
                y: 0,
                d: toInt(match[DATE]) * sign,
                h: toInt(match[HOUR]) * sign,
                m: toInt(match[MINUTE]) * sign,
                s: toInt(match[SECOND]) * sign,
                ms: toInt(match[MILLISECOND]) * sign
            };
        } else if (!!(match = isoDurationRegex.exec(input))) {
            sign = (match[1] === '-') ? -1 : 1;
            parseIso = function (inp) {
                // We'd normally use ~~inp for this, but unfortunately it also
                // converts floats to ints.
                // inp may be undefined, so careful calling replace on it.
                var res = inp && parseFloat(inp.replace(',', '.'));
                // apply sign while we're at it
                return (isNaN(res) ? 0 : res) * sign;
            };
            duration = {
                y: parseIso(match[2]),
                M: parseIso(match[3]),
                d: parseIso(match[4]),
                h: parseIso(match[5]),
                m: parseIso(match[6]),
                s: parseIso(match[7]),
                w: parseIso(match[8])
            };
        } else if (duration == null) {// checks for null or undefined
            duration = {};
        } else if (typeof duration === 'object' &&
                ('from' in duration || 'to' in duration)) {
            diffRes = momentsDifference(moment(duration.from), moment(duration.to));

            duration = {};
            duration.ms = diffRes.milliseconds;
            duration.M = diffRes.months;
        }

        ret = new Duration(duration);

        if (moment.isDuration(input) && hasOwnProp(input, '_locale')) {
            ret._locale = input._locale;
        }

        return ret;
    };

    // version number
    moment.version = VERSION;

    // default format
    moment.defaultFormat = isoFormat;

    // constant that refers to the ISO standard
    moment.ISO_8601 = function () {};

    // Plugins that add properties should also add the key here (null value),
    // so we can properly clone ourselves.
    moment.momentProperties = momentProperties;

    // This function will be called whenever a moment is mutated.
    // It is intended to keep the offset in sync with the timezone.
    moment.updateOffset = function () {};

    // This function allows you to set a threshold for relative time strings
    moment.relativeTimeThreshold = function (threshold, limit) {
        if (relativeTimeThresholds[threshold] === undefined) {
            return false;
        }
        if (limit === undefined) {
            return relativeTimeThresholds[threshold];
        }
        relativeTimeThresholds[threshold] = limit;
        return true;
    };

    moment.lang = deprecate(
        'moment.lang is deprecated. Use moment.locale instead.',
        function (key, value) {
            return moment.locale(key, value);
        }
    );

    // This function will load locale and then set the global locale.  If
    // no arguments are passed in, it will simply return the current global
    // locale key.
    moment.locale = function (key, values) {
        var data;
        if (key) {
            if (typeof(values) !== 'undefined') {
                data = moment.defineLocale(key, values);
            }
            else {
                data = moment.localeData(key);
            }

            if (data) {
                moment.duration._locale = moment._locale = data;
            }
        }

        return moment._locale._abbr;
    };

    moment.defineLocale = function (name, values) {
        if (values !== null) {
            values.abbr = name;
            if (!locales[name]) {
                locales[name] = new Locale();
            }
            locales[name].set(values);

            // backwards compat for now: also set the locale
            moment.locale(name);

            return locales[name];
        } else {
            // useful for testing
            delete locales[name];
            return null;
        }
    };

    moment.langData = deprecate(
        'moment.langData is deprecated. Use moment.localeData instead.',
        function (key) {
            return moment.localeData(key);
        }
    );

    // returns locale data
    moment.localeData = function (key) {
        var locale;

        if (key && key._locale && key._locale._abbr) {
            key = key._locale._abbr;
        }

        if (!key) {
            return moment._locale;
        }

        if (!isArray(key)) {
            //short-circuit everything else
            locale = loadLocale(key);
            if (locale) {
                return locale;
            }
            key = [key];
        }

        return chooseLocale(key);
    };

    // compare moment object
    moment.isMoment = function (obj) {
        return obj instanceof Moment ||
            (obj != null && hasOwnProp(obj, '_isAMomentObject'));
    };

    // for typechecking Duration objects
    moment.isDuration = function (obj) {
        return obj instanceof Duration;
    };

    for (i = lists.length - 1; i >= 0; --i) {
        makeList(lists[i]);
    }

    moment.normalizeUnits = function (units) {
        return normalizeUnits(units);
    };

    moment.invalid = function (flags) {
        var m = moment.utc(NaN);
        if (flags != null) {
            extend(m._pf, flags);
        }
        else {
            m._pf.userInvalidated = true;
        }

        return m;
    };

    moment.parseZone = function () {
        return moment.apply(null, arguments).parseZone();
    };

    moment.parseTwoDigitYear = function (input) {
        return toInt(input) + (toInt(input) > 68 ? 1900 : 2000);
    };

    moment.isDate = isDate;

    /************************************
        Moment Prototype
    ************************************/


    extend(moment.fn = Moment.prototype, {

        clone : function () {
            return moment(this);
        },

        valueOf : function () {
            return +this._d - ((this._offset || 0) * 60000);
        },

        unix : function () {
            return Math.floor(+this / 1000);
        },

        toString : function () {
            return this.clone().locale('en').format('ddd MMM DD YYYY HH:mm:ss [GMT]ZZ');
        },

        toDate : function () {
            return this._offset ? new Date(+this) : this._d;
        },

        toISOString : function () {
            var m = moment(this).utc();
            if (0 < m.year() && m.year() <= 9999) {
                if ('function' === typeof Date.prototype.toISOString) {
                    // native implementation is ~50x faster, use it when we can
                    return this.toDate().toISOString();
                } else {
                    return formatMoment(m, 'YYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
                }
            } else {
                return formatMoment(m, 'YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
            }
        },

        toArray : function () {
            var m = this;
            return [
                m.year(),
                m.month(),
                m.date(),
                m.hours(),
                m.minutes(),
                m.seconds(),
                m.milliseconds()
            ];
        },

        isValid : function () {
            return isValid(this);
        },

        isDSTShifted : function () {
            if (this._a) {
                return this.isValid() && compareArrays(this._a, (this._isUTC ? moment.utc(this._a) : moment(this._a)).toArray()) > 0;
            }

            return false;
        },

        parsingFlags : function () {
            return extend({}, this._pf);
        },

        invalidAt: function () {
            return this._pf.overflow;
        },

        utc : function (keepLocalTime) {
            return this.utcOffset(0, keepLocalTime);
        },

        local : function (keepLocalTime) {
            if (this._isUTC) {
                this.utcOffset(0, keepLocalTime);
                this._isUTC = false;

                if (keepLocalTime) {
                    this.subtract(this._dateUtcOffset(), 'm');
                }
            }
            return this;
        },

        format : function (inputString) {
            var output = formatMoment(this, inputString || moment.defaultFormat);
            return this.localeData().postformat(output);
        },

        add : createAdder(1, 'add'),

        subtract : createAdder(-1, 'subtract'),

        diff : function (input, units, asFloat) {
            var that = makeAs(input, this),
                zoneDiff = (that.utcOffset() - this.utcOffset()) * 6e4,
                anchor, diff, output, daysAdjust;

            units = normalizeUnits(units);

            if (units === 'year' || units === 'month' || units === 'quarter') {
                output = monthDiff(this, that);
                if (units === 'quarter') {
                    output = output / 3;
                } else if (units === 'year') {
                    output = output / 12;
                }
            } else {
                diff = this - that;
                output = units === 'second' ? diff / 1e3 : // 1000
                    units === 'minute' ? diff / 6e4 : // 1000 * 60
                    units === 'hour' ? diff / 36e5 : // 1000 * 60 * 60
                    units === 'day' ? (diff - zoneDiff) / 864e5 : // 1000 * 60 * 60 * 24, negate dst
                    units === 'week' ? (diff - zoneDiff) / 6048e5 : // 1000 * 60 * 60 * 24 * 7, negate dst
                    diff;
            }
            return asFloat ? output : absRound(output);
        },

        from : function (time, withoutSuffix) {
            return moment.duration({to: this, from: time}).locale(this.locale()).humanize(!withoutSuffix);
        },

        fromNow : function (withoutSuffix) {
            return this.from(moment(), withoutSuffix);
        },

        calendar : function (time) {
            // We want to compare the start of today, vs this.
            // Getting start-of-today depends on whether we're locat/utc/offset
            // or not.
            var now = time || moment(),
                sod = makeAs(now, this).startOf('day'),
                diff = this.diff(sod, 'days', true),
                format = diff < -6 ? 'sameElse' :
                    diff < -1 ? 'lastWeek' :
                    diff < 0 ? 'lastDay' :
                    diff < 1 ? 'sameDay' :
                    diff < 2 ? 'nextDay' :
                    diff < 7 ? 'nextWeek' : 'sameElse';
            return this.format(this.localeData().calendar(format, this, moment(now)));
        },

        isLeapYear : function () {
            return isLeapYear(this.year());
        },

        isDST : function () {
            return (this.utcOffset() > this.clone().month(0).utcOffset() ||
                this.utcOffset() > this.clone().month(5).utcOffset());
        },

        day : function (input) {
            var day = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
            if (input != null) {
                input = parseWeekday(input, this.localeData());
                return this.add(input - day, 'd');
            } else {
                return day;
            }
        },

        month : makeAccessor('Month', true),

        startOf : function (units) {
            units = normalizeUnits(units);
            // the following switch intentionally omits break keywords
            // to utilize falling through the cases.
            switch (units) {
            case 'year':
                this.month(0);
                /* falls through */
            case 'quarter':
            case 'month':
                this.date(1);
                /* falls through */
            case 'week':
            case 'isoWeek':
            case 'day':
                this.hours(0);
                /* falls through */
            case 'hour':
                this.minutes(0);
                /* falls through */
            case 'minute':
                this.seconds(0);
                /* falls through */
            case 'second':
                this.milliseconds(0);
                /* falls through */
            }

            // weeks are a special case
            if (units === 'week') {
                this.weekday(0);
            } else if (units === 'isoWeek') {
                this.isoWeekday(1);
            }

            // quarters are also special
            if (units === 'quarter') {
                this.month(Math.floor(this.month() / 3) * 3);
            }

            return this;
        },

        endOf: function (units) {
            units = normalizeUnits(units);
            if (units === undefined || units === 'millisecond') {
                return this;
            }
            return this.startOf(units).add(1, (units === 'isoWeek' ? 'week' : units)).subtract(1, 'ms');
        },

        isAfter: function (input, units) {
            var inputMs;
            units = normalizeUnits(typeof units !== 'undefined' ? units : 'millisecond');
            if (units === 'millisecond') {
                input = moment.isMoment(input) ? input : moment(input);
                return +this > +input;
            } else {
                inputMs = moment.isMoment(input) ? +input : +moment(input);
                return inputMs < +this.clone().startOf(units);
            }
        },

        isBefore: function (input, units) {
            var inputMs;
            units = normalizeUnits(typeof units !== 'undefined' ? units : 'millisecond');
            if (units === 'millisecond') {
                input = moment.isMoment(input) ? input : moment(input);
                return +this < +input;
            } else {
                inputMs = moment.isMoment(input) ? +input : +moment(input);
                return +this.clone().endOf(units) < inputMs;
            }
        },

        isBetween: function (from, to, units) {
            return this.isAfter(from, units) && this.isBefore(to, units);
        },

        isSame: function (input, units) {
            var inputMs;
            units = normalizeUnits(units || 'millisecond');
            if (units === 'millisecond') {
                input = moment.isMoment(input) ? input : moment(input);
                return +this === +input;
            } else {
                inputMs = +moment(input);
                return +(this.clone().startOf(units)) <= inputMs && inputMs <= +(this.clone().endOf(units));
            }
        },

        min: deprecate(
                 'moment().min is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548',
                 function (other) {
                     other = moment.apply(null, arguments);
                     return other < this ? this : other;
                 }
         ),

        max: deprecate(
                'moment().max is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548',
                function (other) {
                    other = moment.apply(null, arguments);
                    return other > this ? this : other;
                }
        ),

        zone : deprecate(
                'moment().zone is deprecated, use moment().utcOffset instead. ' +
                'https://github.com/moment/moment/issues/1779',
                function (input, keepLocalTime) {
                    if (input != null) {
                        if (typeof input !== 'string') {
                            input = -input;
                        }

                        this.utcOffset(input, keepLocalTime);

                        return this;
                    } else {
                        return -this.utcOffset();
                    }
                }
        ),

        // keepLocalTime = true means only change the timezone, without
        // affecting the local hour. So 5:31:26 +0300 --[utcOffset(2, true)]-->
        // 5:31:26 +0200 It is possible that 5:31:26 doesn't exist with offset
        // +0200, so we adjust the time as needed, to be valid.
        //
        // Keeping the time actually adds/subtracts (one hour)
        // from the actual represented time. That is why we call updateOffset
        // a second time. In case it wants us to change the offset again
        // _changeInProgress == true case, then we have to adjust, because
        // there is no such time in the given timezone.
        utcOffset : function (input, keepLocalTime) {
            var offset = this._offset || 0,
                localAdjust;
            if (input != null) {
                if (typeof input === 'string') {
                    input = utcOffsetFromString(input);
                }
                if (Math.abs(input) < 16) {
                    input = input * 60;
                }
                if (!this._isUTC && keepLocalTime) {
                    localAdjust = this._dateUtcOffset();
                }
                this._offset = input;
                this._isUTC = true;
                if (localAdjust != null) {
                    this.add(localAdjust, 'm');
                }
                if (offset !== input) {
                    if (!keepLocalTime || this._changeInProgress) {
                        addOrSubtractDurationFromMoment(this,
                                moment.duration(input - offset, 'm'), 1, false);
                    } else if (!this._changeInProgress) {
                        this._changeInProgress = true;
                        moment.updateOffset(this, true);
                        this._changeInProgress = null;
                    }
                }

                return this;
            } else {
                return this._isUTC ? offset : this._dateUtcOffset();
            }
        },

        isLocal : function () {
            return !this._isUTC;
        },

        isUtcOffset : function () {
            return this._isUTC;
        },

        isUtc : function () {
            return this._isUTC && this._offset === 0;
        },

        zoneAbbr : function () {
            return this._isUTC ? 'UTC' : '';
        },

        zoneName : function () {
            return this._isUTC ? 'Coordinated Universal Time' : '';
        },

        parseZone : function () {
            if (this._tzm) {
                this.utcOffset(this._tzm);
            } else if (typeof this._i === 'string') {
                this.utcOffset(utcOffsetFromString(this._i));
            }
            return this;
        },

        hasAlignedHourOffset : function (input) {
            if (!input) {
                input = 0;
            }
            else {
                input = moment(input).utcOffset();
            }

            return (this.utcOffset() - input) % 60 === 0;
        },

        daysInMonth : function () {
            return daysInMonth(this.year(), this.month());
        },

        dayOfYear : function (input) {
            var dayOfYear = round((moment(this).startOf('day') - moment(this).startOf('year')) / 864e5) + 1;
            return input == null ? dayOfYear : this.add((input - dayOfYear), 'd');
        },

        quarter : function (input) {
            return input == null ? Math.ceil((this.month() + 1) / 3) : this.month((input - 1) * 3 + this.month() % 3);
        },

        weekYear : function (input) {
            var year = weekOfYear(this, this.localeData()._week.dow, this.localeData()._week.doy).year;
            return input == null ? year : this.add((input - year), 'y');
        },

        isoWeekYear : function (input) {
            var year = weekOfYear(this, 1, 4).year;
            return input == null ? year : this.add((input - year), 'y');
        },

        week : function (input) {
            var week = this.localeData().week(this);
            return input == null ? week : this.add((input - week) * 7, 'd');
        },

        isoWeek : function (input) {
            var week = weekOfYear(this, 1, 4).week;
            return input == null ? week : this.add((input - week) * 7, 'd');
        },

        weekday : function (input) {
            var weekday = (this.day() + 7 - this.localeData()._week.dow) % 7;
            return input == null ? weekday : this.add(input - weekday, 'd');
        },

        isoWeekday : function (input) {
            // behaves the same as moment#day except
            // as a getter, returns 7 instead of 0 (1-7 range instead of 0-6)
            // as a setter, sunday should belong to the previous week.
            return input == null ? this.day() || 7 : this.day(this.day() % 7 ? input : input - 7);
        },

        isoWeeksInYear : function () {
            return weeksInYear(this.year(), 1, 4);
        },

        weeksInYear : function () {
            var weekInfo = this.localeData()._week;
            return weeksInYear(this.year(), weekInfo.dow, weekInfo.doy);
        },

        get : function (units) {
            units = normalizeUnits(units);
            return this[units]();
        },

        set : function (units, value) {
            var unit;
            if (typeof units === 'object') {
                for (unit in units) {
                    this.set(unit, units[unit]);
                }
            }
            else {
                units = normalizeUnits(units);
                if (typeof this[units] === 'function') {
                    this[units](value);
                }
            }
            return this;
        },

        // If passed a locale key, it will set the locale for this
        // instance.  Otherwise, it will return the locale configuration
        // variables for this instance.
        locale : function (key) {
            var newLocaleData;

            if (key === undefined) {
                return this._locale._abbr;
            } else {
                newLocaleData = moment.localeData(key);
                if (newLocaleData != null) {
                    this._locale = newLocaleData;
                }
                return this;
            }
        },

        lang : deprecate(
            'moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.',
            function (key) {
                if (key === undefined) {
                    return this.localeData();
                } else {
                    return this.locale(key);
                }
            }
        ),

        localeData : function () {
            return this._locale;
        },

        _dateUtcOffset : function () {
            // On Firefox.24 Date#getTimezoneOffset returns a floating point.
            // https://github.com/moment/moment/pull/1871
            return -Math.round(this._d.getTimezoneOffset() / 15) * 15;
        }

    });

    function rawMonthSetter(mom, value) {
        var dayOfMonth;

        // TODO: Move this out of here!
        if (typeof value === 'string') {
            value = mom.localeData().monthsParse(value);
            // TODO: Another silent failure?
            if (typeof value !== 'number') {
                return mom;
            }
        }

        dayOfMonth = Math.min(mom.date(),
                daysInMonth(mom.year(), value));
        mom._d['set' + (mom._isUTC ? 'UTC' : '') + 'Month'](value, dayOfMonth);
        return mom;
    }

    function rawGetter(mom, unit) {
        return mom._d['get' + (mom._isUTC ? 'UTC' : '') + unit]();
    }

    function rawSetter(mom, unit, value) {
        if (unit === 'Month') {
            return rawMonthSetter(mom, value);
        } else {
            return mom._d['set' + (mom._isUTC ? 'UTC' : '') + unit](value);
        }
    }

    function makeAccessor(unit, keepTime) {
        return function (value) {
            if (value != null) {
                rawSetter(this, unit, value);
                moment.updateOffset(this, keepTime);
                return this;
            } else {
                return rawGetter(this, unit);
            }
        };
    }

    moment.fn.millisecond = moment.fn.milliseconds = makeAccessor('Milliseconds', false);
    moment.fn.second = moment.fn.seconds = makeAccessor('Seconds', false);
    moment.fn.minute = moment.fn.minutes = makeAccessor('Minutes', false);
    // Setting the hour should keep the time, because the user explicitly
    // specified which hour he wants. So trying to maintain the same hour (in
    // a new timezone) makes sense. Adding/subtracting hours does not follow
    // this rule.
    moment.fn.hour = moment.fn.hours = makeAccessor('Hours', true);
    // moment.fn.month is defined separately
    moment.fn.date = makeAccessor('Date', true);
    moment.fn.dates = deprecate('dates accessor is deprecated. Use date instead.', makeAccessor('Date', true));
    moment.fn.year = makeAccessor('FullYear', true);
    moment.fn.years = deprecate('years accessor is deprecated. Use year instead.', makeAccessor('FullYear', true));

    // add plural methods
    moment.fn.days = moment.fn.day;
    moment.fn.months = moment.fn.month;
    moment.fn.weeks = moment.fn.week;
    moment.fn.isoWeeks = moment.fn.isoWeek;
    moment.fn.quarters = moment.fn.quarter;

    // add aliased format methods
    moment.fn.toJSON = moment.fn.toISOString;

    // alias isUtc for dev-friendliness
    moment.fn.isUTC = moment.fn.isUtc;

    /************************************
        Duration Prototype
    ************************************/


    function daysToYears (days) {
        // 400 years have 146097 days (taking into account leap year rules)
        return days * 400 / 146097;
    }

    function yearsToDays (years) {
        // years * 365 + absRound(years / 4) -
        //     absRound(years / 100) + absRound(years / 400);
        return years * 146097 / 400;
    }

    extend(moment.duration.fn = Duration.prototype, {

        _bubble : function () {
            var milliseconds = this._milliseconds,
                days = this._days,
                months = this._months,
                data = this._data,
                seconds, minutes, hours, years = 0;

            // The following code bubbles up values, see the tests for
            // examples of what that means.
            data.milliseconds = milliseconds % 1000;

            seconds = absRound(milliseconds / 1000);
            data.seconds = seconds % 60;

            minutes = absRound(seconds / 60);
            data.minutes = minutes % 60;

            hours = absRound(minutes / 60);
            data.hours = hours % 24;

            days += absRound(hours / 24);

            // Accurately convert days to years, assume start from year 0.
            years = absRound(daysToYears(days));
            days -= absRound(yearsToDays(years));

            // 30 days to a month
            // TODO (iskren): Use anchor date (like 1st Jan) to compute this.
            months += absRound(days / 30);
            days %= 30;

            // 12 months -> 1 year
            years += absRound(months / 12);
            months %= 12;

            data.days = days;
            data.months = months;
            data.years = years;
        },

        abs : function () {
            this._milliseconds = Math.abs(this._milliseconds);
            this._days = Math.abs(this._days);
            this._months = Math.abs(this._months);

            this._data.milliseconds = Math.abs(this._data.milliseconds);
            this._data.seconds = Math.abs(this._data.seconds);
            this._data.minutes = Math.abs(this._data.minutes);
            this._data.hours = Math.abs(this._data.hours);
            this._data.months = Math.abs(this._data.months);
            this._data.years = Math.abs(this._data.years);

            return this;
        },

        weeks : function () {
            return absRound(this.days() / 7);
        },

        valueOf : function () {
            return this._milliseconds +
              this._days * 864e5 +
              (this._months % 12) * 2592e6 +
              toInt(this._months / 12) * 31536e6;
        },

        humanize : function (withSuffix) {
            var output = relativeTime(this, !withSuffix, this.localeData());

            if (withSuffix) {
                output = this.localeData().pastFuture(+this, output);
            }

            return this.localeData().postformat(output);
        },

        add : function (input, val) {
            // supports only 2.0-style add(1, 's') or add(moment)
            var dur = moment.duration(input, val);

            this._milliseconds += dur._milliseconds;
            this._days += dur._days;
            this._months += dur._months;

            this._bubble();

            return this;
        },

        subtract : function (input, val) {
            var dur = moment.duration(input, val);

            this._milliseconds -= dur._milliseconds;
            this._days -= dur._days;
            this._months -= dur._months;

            this._bubble();

            return this;
        },

        get : function (units) {
            units = normalizeUnits(units);
            return this[units.toLowerCase() + 's']();
        },

        as : function (units) {
            var days, months;
            units = normalizeUnits(units);

            if (units === 'month' || units === 'year') {
                days = this._days + this._milliseconds / 864e5;
                months = this._months + daysToYears(days) * 12;
                return units === 'month' ? months : months / 12;
            } else {
                // handle milliseconds separately because of floating point math errors (issue #1867)
                days = this._days + Math.round(yearsToDays(this._months / 12));
                switch (units) {
                    case 'week': return days / 7 + this._milliseconds / 6048e5;
                    case 'day': return days + this._milliseconds / 864e5;
                    case 'hour': return days * 24 + this._milliseconds / 36e5;
                    case 'minute': return days * 24 * 60 + this._milliseconds / 6e4;
                    case 'second': return days * 24 * 60 * 60 + this._milliseconds / 1000;
                    // Math.floor prevents floating point math errors here
                    case 'millisecond': return Math.floor(days * 24 * 60 * 60 * 1000) + this._milliseconds;
                    default: throw new Error('Unknown unit ' + units);
                }
            }
        },

        lang : moment.fn.lang,
        locale : moment.fn.locale,

        toIsoString : deprecate(
            'toIsoString() is deprecated. Please use toISOString() instead ' +
            '(notice the capitals)',
            function () {
                return this.toISOString();
            }
        ),

        toISOString : function () {
            // inspired by https://github.com/dordille/moment-isoduration/blob/master/moment.isoduration.js
            var years = Math.abs(this.years()),
                months = Math.abs(this.months()),
                days = Math.abs(this.days()),
                hours = Math.abs(this.hours()),
                minutes = Math.abs(this.minutes()),
                seconds = Math.abs(this.seconds() + this.milliseconds() / 1000);

            if (!this.asSeconds()) {
                // this is the same as C#'s (Noda) and python (isodate)...
                // but not other JS (goog.date)
                return 'P0D';
            }

            return (this.asSeconds() < 0 ? '-' : '') +
                'P' +
                (years ? years + 'Y' : '') +
                (months ? months + 'M' : '') +
                (days ? days + 'D' : '') +
                ((hours || minutes || seconds) ? 'T' : '') +
                (hours ? hours + 'H' : '') +
                (minutes ? minutes + 'M' : '') +
                (seconds ? seconds + 'S' : '');
        },

        localeData : function () {
            return this._locale;
        },

        toJSON : function () {
            return this.toISOString();
        }
    });

    moment.duration.fn.toString = moment.duration.fn.toISOString;

    function makeDurationGetter(name) {
        moment.duration.fn[name] = function () {
            return this._data[name];
        };
    }

    for (i in unitMillisecondFactors) {
        if (hasOwnProp(unitMillisecondFactors, i)) {
            makeDurationGetter(i.toLowerCase());
        }
    }

    moment.duration.fn.asMilliseconds = function () {
        return this.as('ms');
    };
    moment.duration.fn.asSeconds = function () {
        return this.as('s');
    };
    moment.duration.fn.asMinutes = function () {
        return this.as('m');
    };
    moment.duration.fn.asHours = function () {
        return this.as('h');
    };
    moment.duration.fn.asDays = function () {
        return this.as('d');
    };
    moment.duration.fn.asWeeks = function () {
        return this.as('weeks');
    };
    moment.duration.fn.asMonths = function () {
        return this.as('M');
    };
    moment.duration.fn.asYears = function () {
        return this.as('y');
    };

    /************************************
        Default Locale
    ************************************/


    // Set default locale, other locale will inherit from English.
    moment.locale('en', {
        ordinalParse: /\d{1,2}(th|st|nd|rd)/,
        ordinal : function (number) {
            var b = number % 10,
                output = (toInt(number % 100 / 10) === 1) ? 'th' :
                (b === 1) ? 'st' :
                (b === 2) ? 'nd' :
                (b === 3) ? 'rd' : 'th';
            return number + output;
        }
    });

    // moment.js locale configuration
// locale : afrikaans (af)
// author : Werner Mollentze : https://github.com/wernerm

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('af', {
        months : 'Januarie_Februarie_Maart_April_Mei_Junie_Julie_Augustus_September_Oktober_November_Desember'.split('_'),
        monthsShort : 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Aug_Sep_Okt_Nov_Des'.split('_'),
        weekdays : 'Sondag_Maandag_Dinsdag_Woensdag_Donderdag_Vrydag_Saterdag'.split('_'),
        weekdaysShort : 'Son_Maa_Din_Woe_Don_Vry_Sat'.split('_'),
        weekdaysMin : 'So_Ma_Di_Wo_Do_Vr_Sa'.split('_'),
        meridiemParse: /vm|nm/i,
        isPM : function (input) {
            return /^nm$/i.test(input);
        },
        meridiem : function (hours, minutes, isLower) {
            if (hours < 12) {
                return isLower ? 'vm' : 'VM';
            } else {
                return isLower ? 'nm' : 'NM';
            }
        },
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[Vandag om] LT',
            nextDay : '[Mรดre om] LT',
            nextWeek : 'dddd [om] LT',
            lastDay : '[Gister om] LT',
            lastWeek : '[Laas] dddd [om] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'oor %s',
            past : '%s gelede',
            s : '\'n paar sekondes',
            m : '\'n minuut',
            mm : '%d minute',
            h : '\'n uur',
            hh : '%d ure',
            d : '\'n dag',
            dd : '%d dae',
            M : '\'n maand',
            MM : '%d maande',
            y : '\'n jaar',
            yy : '%d jaar'
        },
        ordinalParse: /\d{1,2}(ste|de)/,
        ordinal : function (number) {
            return number + ((number === 1 || number === 8 || number >= 20) ? 'ste' : 'de'); // Thanks to Joris Rรถling : https://github.com/jjupiter
        },
        week : {
            dow : 1, // Maandag is die eerste dag van die week.
            doy : 4  // Die week wat die 4de Januarie bevat is die eerste week van die jaar.
        }
    });
}));
// moment.js locale configuration
// locale : Moroccan Arabic (ar-ma)
// author : ElFadili Yassine : https://github.com/ElFadiliY
// author : Abdel Said : https://github.com/abdelsaid

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ar-ma', {
        months : 'ููุงูุฑ_ูุจุฑุงูุฑ_ู…ุงุฑุณ_ุฃุจุฑูู_ู…ุงู_ููููู_ูููููุฒ_ุบุดุช_ุดุชูุจุฑ_ุฃูุชูุจุฑ_ูููุจุฑ_ุฏุฌูุจุฑ'.split('_'),
        monthsShort : 'ููุงูุฑ_ูุจุฑุงูุฑ_ู…ุงุฑุณ_ุฃุจุฑูู_ู…ุงู_ููููู_ูููููุฒ_ุบุดุช_ุดุชูุจุฑ_ุฃูุชูุจุฑ_ูููุจุฑ_ุฏุฌูุจุฑ'.split('_'),
        weekdays : 'ุงูุฃุญุฏ_ุงูุฅุชููู_ุงูุซูุงุซุงุก_ุงูุฃุฑุจุนุงุก_ุงูุฎู…ูุณ_ุงูุฌู…ุนุฉ_ุงูุณุจุช'.split('_'),
        weekdaysShort : 'ุงุญุฏ_ุงุชููู_ุซูุงุซุงุก_ุงุฑุจุนุงุก_ุฎู…ูุณ_ุฌู…ุนุฉ_ุณุจุช'.split('_'),
        weekdaysMin : 'ุญ_ู_ุซ_ุฑ_ุฎ_ุฌ_ุณ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[ุงูููู… ุนูู ุงูุณุงุนุฉ] LT',
            nextDay: '[ุบุฏุง ุนูู ุงูุณุงุนุฉ] LT',
            nextWeek: 'dddd [ุนูู ุงูุณุงุนุฉ] LT',
            lastDay: '[ุฃู…ุณ ุนูู ุงูุณุงุนุฉ] LT',
            lastWeek: 'dddd [ุนูู ุงูุณุงุนุฉ] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'ูู %s',
            past : 'ู…ูุฐ %s',
            s : 'ุซูุงู',
            m : 'ุฏูููุฉ',
            mm : '%d ุฏูุงุฆู',
            h : 'ุณุงุนุฉ',
            hh : '%d ุณุงุนุงุช',
            d : 'ููู…',
            dd : '%d ุฃูุงู…',
            M : 'ุดูุฑ',
            MM : '%d ุฃุดูุฑ',
            y : 'ุณูุฉ',
            yy : '%d ุณููุงุช'
        },
        week : {
            dow : 6, // Saturday is the first day of the week.
            doy : 12  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Arabic Saudi Arabia (ar-sa)
// author : Suhail Alkowaileet : https://github.com/xsoh

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'ูก',
        '2': 'ูข',
        '3': 'ูฃ',
        '4': 'ูค',
        '5': 'ูฅ',
        '6': 'ูฆ',
        '7': 'ูง',
        '8': 'ูจ',
        '9': 'ูฉ',
        '0': 'ู '
    }, numberMap = {
        'ูก': '1',
        'ูข': '2',
        'ูฃ': '3',
        'ูค': '4',
        'ูฅ': '5',
        'ูฆ': '6',
        'ูง': '7',
        'ูจ': '8',
        'ูฉ': '9',
        'ู ': '0'
    };

    return moment.defineLocale('ar-sa', {
        months : 'ููุงูุฑ_ูุจุฑุงูุฑ_ู…ุงุฑุณ_ุฃุจุฑูู_ู…ุงูู_ููููู_ููููู_ุฃุบุณุทุณ_ุณุจุชู…ุจุฑ_ุฃูุชูุจุฑ_ูููู…ุจุฑ_ุฏูุณู…ุจุฑ'.split('_'),
        monthsShort : 'ููุงูุฑ_ูุจุฑุงูุฑ_ู…ุงุฑุณ_ุฃุจุฑูู_ู…ุงูู_ููููู_ููููู_ุฃุบุณุทุณ_ุณุจุชู…ุจุฑ_ุฃูุชูุจุฑ_ูููู…ุจุฑ_ุฏูุณู…ุจุฑ'.split('_'),
        weekdays : 'ุงูุฃุญุฏ_ุงูุฅุซููู_ุงูุซูุงุซุงุก_ุงูุฃุฑุจุนุงุก_ุงูุฎู…ูุณ_ุงูุฌู…ุนุฉ_ุงูุณุจุช'.split('_'),
        weekdaysShort : 'ุฃุญุฏ_ุฅุซููู_ุซูุงุซุงุก_ุฃุฑุจุนุงุก_ุฎู…ูุณ_ุฌู…ุนุฉ_ุณุจุช'.split('_'),
        weekdaysMin : 'ุญ_ู_ุซ_ุฑ_ุฎ_ุฌ_ุณ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        meridiemParse: /ุต|ู…/,
        isPM : function (input) {
            return 'ู…' === input;
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 12) {
                return 'ุต';
            } else {
                return 'ู…';
            }
        },
        calendar : {
            sameDay: '[ุงูููู… ุนูู ุงูุณุงุนุฉ] LT',
            nextDay: '[ุบุฏุง ุนูู ุงูุณุงุนุฉ] LT',
            nextWeek: 'dddd [ุนูู ุงูุณุงุนุฉ] LT',
            lastDay: '[ุฃู…ุณ ุนูู ุงูุณุงุนุฉ] LT',
            lastWeek: 'dddd [ุนูู ุงูุณุงุนุฉ] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'ูู %s',
            past : 'ู…ูุฐ %s',
            s : 'ุซูุงู',
            m : 'ุฏูููุฉ',
            mm : '%d ุฏูุงุฆู',
            h : 'ุณุงุนุฉ',
            hh : '%d ุณุงุนุงุช',
            d : 'ููู…',
            dd : '%d ุฃูุงู…',
            M : 'ุดูุฑ',
            MM : '%d ุฃุดูุฑ',
            y : 'ุณูุฉ',
            yy : '%d ุณููุงุช'
        },
        preparse: function (string) {
            return string.replace(/[ูกูขูฃูคูฅูฆูงูจูฉู ]/g, function (match) {
                return numberMap[match];
            }).replace(/ุ/g, ',');
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            }).replace(/,/g, 'ุ');
        },
        week : {
            dow : 6, // Saturday is the first day of the week.
            doy : 12  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale  : Tunisian Arabic (ar-tn)

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ar-tn', {
        months: 'ุฌุงููู_ูููุฑู_ู…ุงุฑุณ_ุฃูุฑูู_ู…ุงู_ุฌูุงู_ุฌููููุฉ_ุฃูุช_ุณุจุชู…ุจุฑ_ุฃูุชูุจุฑ_ูููู…ุจุฑ_ุฏูุณู…ุจุฑ'.split('_'),
        monthsShort: 'ุฌุงููู_ูููุฑู_ู…ุงุฑุณ_ุฃูุฑูู_ู…ุงู_ุฌูุงู_ุฌููููุฉ_ุฃูุช_ุณุจุชู…ุจุฑ_ุฃูุชูุจุฑ_ูููู…ุจุฑ_ุฏูุณู…ุจุฑ'.split('_'),
        weekdays: 'ุงูุฃุญุฏ_ุงูุฅุซููู_ุงูุซูุงุซุงุก_ุงูุฃุฑุจุนุงุก_ุงูุฎู…ูุณ_ุงูุฌู…ุนุฉ_ุงูุณุจุช'.split('_'),
        weekdaysShort: 'ุฃุญุฏ_ุฅุซููู_ุซูุงุซุงุก_ุฃุฑุจุนุงุก_ุฎู…ูุณ_ุฌู…ุนุฉ_ุณุจุช'.split('_'),
        weekdaysMin: 'ุญ_ู_ุซ_ุฑ_ุฎ_ุฌ_ุณ'.split('_'),
        longDateFormat: {
            LT: 'HH:mm',
            LTS: 'LT:ss',
            L: 'DD/MM/YYYY',
            LL: 'D MMMM YYYY',
            LLL: 'D MMMM YYYY LT',
            LLLL: 'dddd D MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[ุงูููู… ุนูู ุงูุณุงุนุฉ] LT',
            nextDay: '[ุบุฏุง ุนูู ุงูุณุงุนุฉ] LT',
            nextWeek: 'dddd [ุนูู ุงูุณุงุนุฉ] LT',
            lastDay: '[ุฃู…ุณ ุนูู ุงูุณุงุนุฉ] LT',
            lastWeek: 'dddd [ุนูู ุงูุณุงุนุฉ] LT',
            sameElse: 'L'
        },
        relativeTime: {
            future: 'ูู %s',
            past: 'ู…ูุฐ %s',
            s: 'ุซูุงู',
            m: 'ุฏูููุฉ',
            mm: '%d ุฏูุงุฆู',
            h: 'ุณุงุนุฉ',
            hh: '%d ุณุงุนุงุช',
            d: 'ููู…',
            dd: '%d ุฃูุงู…',
            M: 'ุดูุฑ',
            MM: '%d ุฃุดูุฑ',
            y: 'ุณูุฉ',
            yy: '%d ุณููุงุช'
        },
        week: {
            dow: 1, // Monday is the first day of the week.
            doy: 4 // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// Locale: Arabic (ar)
// Author: Abdel Said: https://github.com/abdelsaid
// Changes in months, weekdays: Ahmed Elkhatib
// Native plural forms: forabi https://github.com/forabi

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'ูก',
        '2': 'ูข',
        '3': 'ูฃ',
        '4': 'ูค',
        '5': 'ูฅ',
        '6': 'ูฆ',
        '7': 'ูง',
        '8': 'ูจ',
        '9': 'ูฉ',
        '0': 'ู '
    }, numberMap = {
        'ูก': '1',
        'ูข': '2',
        'ูฃ': '3',
        'ูค': '4',
        'ูฅ': '5',
        'ูฆ': '6',
        'ูง': '7',
        'ูจ': '8',
        'ูฉ': '9',
        'ู ': '0'
    }, pluralForm = function (n) {
        return n === 0 ? 0 : n === 1 ? 1 : n === 2 ? 2 : n % 100 >= 3 && n % 100 <= 10 ? 3 : n % 100 >= 11 ? 4 : 5;
    }, plurals = {
        s : ['ุฃูู ู…ู ุซุงููุฉ', 'ุซุงููุฉ ูุงุญุฏุฉ', ['ุซุงููุชุงู', 'ุซุงููุชูู'], '%d ุซูุงู', '%d ุซุงููุฉ', '%d ุซุงููุฉ'],
        m : ['ุฃูู ู…ู ุฏูููุฉ', 'ุฏูููุฉ ูุงุญุฏุฉ', ['ุฏูููุชุงู', 'ุฏูููุชูู'], '%d ุฏูุงุฆู', '%d ุฏูููุฉ', '%d ุฏูููุฉ'],
        h : ['ุฃูู ู…ู ุณุงุนุฉ', 'ุณุงุนุฉ ูุงุญุฏุฉ', ['ุณุงุนุชุงู', 'ุณุงุนุชูู'], '%d ุณุงุนุงุช', '%d ุณุงุนุฉ', '%d ุณุงุนุฉ'],
        d : ['ุฃูู ู…ู ููู…', 'ููู… ูุงุญุฏ', ['ููู…ุงู', 'ููู…ูู'], '%d ุฃูุงู…', '%d ููู…ูุง', '%d ููู…'],
        M : ['ุฃูู ู…ู ุดูุฑ', 'ุดูุฑ ูุงุญุฏ', ['ุดูุฑุงู', 'ุดูุฑูู'], '%d ุฃุดูุฑ', '%d ุดูุฑุง', '%d ุดูุฑ'],
        y : ['ุฃูู ู…ู ุนุงู…', 'ุนุงู… ูุงุญุฏ', ['ุนุงู…ุงู', 'ุนุงู…ูู'], '%d ุฃุนูุงู…', '%d ุนุงู…ูุง', '%d ุนุงู…']
    }, pluralize = function (u) {
        return function (number, withoutSuffix, string, isFuture) {
            var f = pluralForm(number),
                str = plurals[u][pluralForm(number)];
            if (f === 2) {
                str = str[withoutSuffix ? 0 : 1];
            }
            return str.replace(/%d/i, number);
        };
    }, months = [
        'ูุงููู ุงูุซุงูู ููุงูุฑ',
        'ุดุจุงุท ูุจุฑุงูุฑ',
        'ุขุฐุงุฑ ู…ุงุฑุณ',
        'ููุณุงู ุฃุจุฑูู',
        'ุฃูุงุฑ ู…ุงูู',
        'ุญุฒูุฑุงู ููููู',
        'ุชู…ูุฒ ููููู',
        'ุขุจ ุฃุบุณุทุณ',
        'ุฃูููู ุณุจุชู…ุจุฑ',
        'ุชุดุฑูู ุงูุฃูู ุฃูุชูุจุฑ',
        'ุชุดุฑูู ุงูุซุงูู ูููู…ุจุฑ',
        'ูุงููู ุงูุฃูู ุฏูุณู…ุจุฑ'
    ];

    return moment.defineLocale('ar', {
        months : months,
        monthsShort : months,
        weekdays : 'ุงูุฃุญุฏ_ุงูุฅุซููู_ุงูุซูุงุซุงุก_ุงูุฃุฑุจุนุงุก_ุงูุฎู…ูุณ_ุงูุฌู…ุนุฉ_ุงูุณุจุช'.split('_'),
        weekdaysShort : 'ุฃุญุฏ_ุฅุซููู_ุซูุงุซุงุก_ุฃุฑุจุนุงุก_ุฎู…ูุณ_ุฌู…ุนุฉ_ุณุจุช'.split('_'),
        weekdaysMin : 'ุญ_ู_ุซ_ุฑ_ุฎ_ุฌ_ุณ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        meridiemParse: /ุต|ู…/,
        isPM : function (input) {
            return 'ู…' === input;
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 12) {
                return 'ุต';
            } else {
                return 'ู…';
            }
        },
        calendar : {
            sameDay: '[ุงูููู… ุนูุฏ ุงูุณุงุนุฉ] LT',
            nextDay: '[ุบุฏูุง ุนูุฏ ุงูุณุงุนุฉ] LT',
            nextWeek: 'dddd [ุนูุฏ ุงูุณุงุนุฉ] LT',
            lastDay: '[ุฃู…ุณ ุนูุฏ ุงูุณุงุนุฉ] LT',
            lastWeek: 'dddd [ุนูุฏ ุงูุณุงุนุฉ] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'ุจุนุฏ %s',
            past : 'ู…ูุฐ %s',
            s : pluralize('s'),
            m : pluralize('m'),
            mm : pluralize('m'),
            h : pluralize('h'),
            hh : pluralize('h'),
            d : pluralize('d'),
            dd : pluralize('d'),
            M : pluralize('M'),
            MM : pluralize('M'),
            y : pluralize('y'),
            yy : pluralize('y')
        },
        preparse: function (string) {
            return string.replace(/[ูกูขูฃูคูฅูฆูงูจูฉู ]/g, function (match) {
                return numberMap[match];
            }).replace(/ุ/g, ',');
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            }).replace(/,/g, 'ุ');
        },
        week : {
            dow : 6, // Saturday is the first day of the week.
            doy : 12  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : azerbaijani (az)
// author : topchiyev : https://github.com/topchiyev

(function (factory) {
    factory(moment);
}(function (moment) {
    var suffixes = {
        1: '-inci',
        5: '-inci',
        8: '-inci',
        70: '-inci',
        80: '-inci',

        2: '-nci',
        7: '-nci',
        20: '-nci',
        50: '-nci',

        3: '-รผncรผ',
        4: '-รผncรผ',
        100: '-รผncรผ',

        6: '-ncฤฑ',

        9: '-uncu',
        10: '-uncu',
        30: '-uncu',

        60: '-ฤฑncฤฑ',
        90: '-ฤฑncฤฑ'
    };
    return moment.defineLocale('az', {
        months : 'yanvar_fevral_mart_aprel_may_iyun_iyul_avqust_sentyabr_oktyabr_noyabr_dekabr'.split('_'),
        monthsShort : 'yan_fev_mar_apr_may_iyn_iyl_avq_sen_okt_noy_dek'.split('_'),
        weekdays : 'Bazar_Bazar ertษsi_รษrลษnbษ axลamฤฑ_รษrลษnbษ_Cรผmษ axลamฤฑ_Cรผmษ_ลษnbษ'.split('_'),
        weekdaysShort : 'Baz_BzE_รAx_รษr_CAx_Cรผm_ลษn'.split('_'),
        weekdaysMin : 'Bz_BE_รA_รษ_CA_Cรผ_ลษ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[bugรผn saat] LT',
            nextDay : '[sabah saat] LT',
            nextWeek : '[gษlษn hษftษ] dddd [saat] LT',
            lastDay : '[dรผnษn] LT',
            lastWeek : '[keรงษn hษftษ] dddd [saat] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s sonra',
            past : '%s ษvvษl',
            s : 'birneรงษ saniyyษ',
            m : 'bir dษqiqษ',
            mm : '%d dษqiqษ',
            h : 'bir saat',
            hh : '%d saat',
            d : 'bir gรผn',
            dd : '%d gรผn',
            M : 'bir ay',
            MM : '%d ay',
            y : 'bir il',
            yy : '%d il'
        },
        meridiemParse: /gecษ|sษhษr|gรผndรผz|axลam/,
        isPM : function (input) {
            return /^(gรผndรผz|axลam)$/.test(input);
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'gecษ';
            } else if (hour < 12) {
                return 'sษhษr';
            } else if (hour < 17) {
                return 'gรผndรผz';
            } else {
                return 'axลam';
            }
        },
        ordinalParse: /\d{1,2}-(ฤฑncฤฑ|inci|nci|รผncรผ|ncฤฑ|uncu)/,
        ordinal : function (number) {
            if (number === 0) {  // special case for zero
                return number + '-ฤฑncฤฑ';
            }
            var a = number % 10,
                b = number % 100 - a,
                c = number >= 100 ? 100 : null;

            return number + (suffixes[a] || suffixes[b] || suffixes[c]);
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : belarusian (be)
// author : Dmitry Demidov : https://github.com/demidov91
// author: Praleska: http://praleska.pro/
// Author : Menelion Elensรบle : https://github.com/Oire

(function (factory) {
    factory(moment);
}(function (moment) {
    function plural(word, num) {
        var forms = word.split('_');
        return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
    }

    function relativeTimeWithPlural(number, withoutSuffix, key) {
        var format = {
            'mm': withoutSuffix ? 'ั…ะฒั–ะปั–ะฝะฐ_ั…ะฒั–ะปั–ะฝั_ั…ะฒั–ะปั–ะฝ' : 'ั…ะฒั–ะปั–ะฝั_ั…ะฒั–ะปั–ะฝั_ั…ะฒั–ะปั–ะฝ',
            'hh': withoutSuffix ? 'ะณะฐะดะทั–ะฝะฐ_ะณะฐะดะทั–ะฝั_ะณะฐะดะทั–ะฝ' : 'ะณะฐะดะทั–ะฝั_ะณะฐะดะทั–ะฝั_ะณะฐะดะทั–ะฝ',
            'dd': 'ะดะทะตะฝั_ะดะฝั–_ะดะทั‘ะฝ',
            'MM': 'ะผะตััั_ะผะตัััั_ะผะตัััะฐั',
            'yy': 'ะณะพะด_ะณะฐะดั_ะณะฐะดะพั'
        };
        if (key === 'm') {
            return withoutSuffix ? 'ั…ะฒั–ะปั–ะฝะฐ' : 'ั…ะฒั–ะปั–ะฝั';
        }
        else if (key === 'h') {
            return withoutSuffix ? 'ะณะฐะดะทั–ะฝะฐ' : 'ะณะฐะดะทั–ะฝั';
        }
        else {
            return number + ' ' + plural(format[key], +number);
        }
    }

    function monthsCaseReplace(m, format) {
        var months = {
            'nominative': 'ัััะดะทะตะฝั_ะปััั_ัะฐะบะฐะฒั–ะบ_ะบั€ะฐัะฐะฒั–ะบ_ัั€ะฐะฒะตะฝั_ััั€ะฒะตะฝั_ะปั–ะฟะตะฝั_ะถะฝั–ะฒะตะฝั_ะฒะตั€ะฐัะตะฝั_ะบะฐััั€ััะฝั–ะบ_ะปั–ััะฐะฟะฐะด_ัะฝะตะถะฐะฝั'.split('_'),
            'accusative': 'ัััะดะทะตะฝั_ะปััะฐะณะฐ_ัะฐะบะฐะฒั–ะบะฐ_ะบั€ะฐัะฐะฒั–ะบะฐ_ัั€ะฐัะฝั_ััั€ะฒะตะฝั_ะปั–ะฟะตะฝั_ะถะฝั–ัะฝั_ะฒะตั€ะฐัะฝั_ะบะฐััั€ััะฝั–ะบะฐ_ะปั–ััะฐะฟะฐะดะฐ_ัะฝะตะถะฝั'.split('_')
        },

        nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return months[nounCase][m.month()];
    }

    function weekdaysCaseReplace(m, format) {
        var weekdays = {
            'nominative': 'ะฝัะดะทะตะปั_ะฟะฐะฝัะดะทะตะปะฐะบ_ะฐััะพั€ะฐะบ_ัะตั€ะฐะดะฐ_ัะฐัะฒะตั€_ะฟััะฝั–ัะฐ_ััะฑะพัะฐ'.split('_'),
            'accusative': 'ะฝัะดะทะตะปั_ะฟะฐะฝัะดะทะตะปะฐะบ_ะฐััะพั€ะฐะบ_ัะตั€ะฐะดั_ัะฐัะฒะตั€_ะฟััะฝั–ัั_ััะฑะพัั'.split('_')
        },

        nounCase = (/\[ ?[ะ’ะฒ] ?(?:ะผั–ะฝัะปัั|ะฝะฐัััะฟะฝัั)? ?\] ?dddd/).test(format) ?
            'accusative' :
            'nominative';

        return weekdays[nounCase][m.day()];
    }

    return moment.defineLocale('be', {
        months : monthsCaseReplace,
        monthsShort : 'ัััะด_ะปัั_ัะฐะบ_ะบั€ะฐั_ัั€ะฐะฒ_ััั€ะฒ_ะปั–ะฟ_ะถะฝั–ะฒ_ะฒะตั€_ะบะฐัั_ะปั–ัั_ัะฝะตะถ'.split('_'),
        weekdays : weekdaysCaseReplace,
        weekdaysShort : 'ะฝะด_ะฟะฝ_ะฐั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        weekdaysMin : 'ะฝะด_ะฟะฝ_ะฐั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY ะณ.',
            LLL : 'D MMMM YYYY ะณ., LT',
            LLLL : 'dddd, D MMMM YYYY ะณ., LT'
        },
        calendar : {
            sameDay: '[ะกั‘ะฝะฝั ั] LT',
            nextDay: '[ะ—ะฐััั€ะฐ ั] LT',
            lastDay: '[ะฃัะพั€ะฐ ั] LT',
            nextWeek: function () {
                return '[ะฃ] dddd [ั] LT';
            },
            lastWeek: function () {
                switch (this.day()) {
                case 0:
                case 3:
                case 5:
                case 6:
                    return '[ะฃ ะผั–ะฝัะปัั] dddd [ั] LT';
                case 1:
                case 2:
                case 4:
                    return '[ะฃ ะผั–ะฝัะปั] dddd [ั] LT';
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'ะฟั€ะฐะท %s',
            past : '%s ัะฐะผั',
            s : 'ะฝะตะบะฐะปัะบั– ัะตะบัะฝะด',
            m : relativeTimeWithPlural,
            mm : relativeTimeWithPlural,
            h : relativeTimeWithPlural,
            hh : relativeTimeWithPlural,
            d : 'ะดะทะตะฝั',
            dd : relativeTimeWithPlural,
            M : 'ะผะตััั',
            MM : relativeTimeWithPlural,
            y : 'ะณะพะด',
            yy : relativeTimeWithPlural
        },
        meridiemParse: /ะฝะพัั|ั€ะฐะฝั–ัั|ะดะฝั|ะฒะตัะฐั€ะฐ/,
        isPM : function (input) {
            return /^(ะดะฝั|ะฒะตัะฐั€ะฐ)$/.test(input);
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'ะฝะพัั';
            } else if (hour < 12) {
                return 'ั€ะฐะฝั–ัั';
            } else if (hour < 17) {
                return 'ะดะฝั';
            } else {
                return 'ะฒะตัะฐั€ะฐ';
            }
        },

        ordinalParse: /\d{1,2}-(ั–|ั|ะณะฐ)/,
        ordinal: function (number, period) {
            switch (period) {
            case 'M':
            case 'd':
            case 'DDD':
            case 'w':
            case 'W':
                return (number % 10 === 2 || number % 10 === 3) && (number % 100 !== 12 && number % 100 !== 13) ? number + '-ั–' : number + '-ั';
            case 'D':
                return number + '-ะณะฐ';
            default:
                return number;
            }
        },

        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : bulgarian (bg)
// author : Krasen Borisov : https://github.com/kraz

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('bg', {
        months : 'ัะฝัะฐั€ะธ_ัะตะฒั€ัะฐั€ะธ_ะผะฐั€ั_ะฐะฟั€ะธะป_ะผะฐะน_ัะฝะธ_ัะปะธ_ะฐะฒะณััั_ัะตะฟัะตะผะฒั€ะธ_ะพะบัะพะผะฒั€ะธ_ะฝะพะตะผะฒั€ะธ_ะดะตะบะตะผะฒั€ะธ'.split('_'),
        monthsShort : 'ัะฝั€_ัะตะฒ_ะผะฐั€_ะฐะฟั€_ะผะฐะน_ัะฝะธ_ัะปะธ_ะฐะฒะณ_ัะตะฟ_ะพะบั_ะฝะพะต_ะดะตะบ'.split('_'),
        weekdays : 'ะฝะตะดะตะปั_ะฟะพะฝะตะดะตะปะฝะธะบ_ะฒัะพั€ะฝะธะบ_ัั€ัะดะฐ_ัะตัะฒัั€ััะบ_ะฟะตััะบ_ััะฑะพัะฐ'.split('_'),
        weekdaysShort : 'ะฝะตะด_ะฟะพะฝ_ะฒัะพ_ัั€ั_ัะตั_ะฟะตั_ััะฑ'.split('_'),
        weekdaysMin : 'ะฝะด_ะฟะฝ_ะฒั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'D.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[ะ”ะฝะตั ะฒ] LT',
            nextDay : '[ะฃัั€ะต ะฒ] LT',
            nextWeek : 'dddd [ะฒ] LT',
            lastDay : '[ะ’ัะตั€ะฐ ะฒ] LT',
            lastWeek : function () {
                switch (this.day()) {
                case 0:
                case 3:
                case 6:
                    return '[ะ’ ะธะทะผะธะฝะฐะปะฐัะฐ] dddd [ะฒ] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[ะ’ ะธะทะผะธะฝะฐะปะธั] dddd [ะฒ] LT';
                }
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ัะปะตะด %s',
            past : 'ะฟั€ะตะดะธ %s',
            s : 'ะฝัะบะพะปะบะพ ัะตะบัะฝะดะธ',
            m : 'ะผะธะฝััะฐ',
            mm : '%d ะผะธะฝััะธ',
            h : 'ัะฐั',
            hh : '%d ัะฐัะฐ',
            d : 'ะดะตะฝ',
            dd : '%d ะดะฝะธ',
            M : 'ะผะตัะตั',
            MM : '%d ะผะตัะตัะฐ',
            y : 'ะณะพะดะธะฝะฐ',
            yy : '%d ะณะพะดะธะฝะธ'
        },
        ordinalParse: /\d{1,2}-(ะตะฒ|ะตะฝ|ัะธ|ะฒะธ|ั€ะธ|ะผะธ)/,
        ordinal : function (number) {
            var lastDigit = number % 10,
                last2Digits = number % 100;
            if (number === 0) {
                return number + '-ะตะฒ';
            } else if (last2Digits === 0) {
                return number + '-ะตะฝ';
            } else if (last2Digits > 10 && last2Digits < 20) {
                return number + '-ัะธ';
            } else if (lastDigit === 1) {
                return number + '-ะฒะธ';
            } else if (lastDigit === 2) {
                return number + '-ั€ะธ';
            } else if (lastDigit === 7 || lastDigit === 8) {
                return number + '-ะผะธ';
            } else {
                return number + '-ัะธ';
            }
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Bengali (bn)
// author : Kaushik Gandhi : https://github.com/kaushikgandhi

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'เงง',
        '2': 'เงจ',
        '3': 'เงฉ',
        '4': 'เงช',
        '5': 'เงซ',
        '6': 'เงฌ',
        '7': 'เงญ',
        '8': 'เงฎ',
        '9': 'เงฏ',
        '0': 'เงฆ'
    },
    numberMap = {
        'เงง': '1',
        'เงจ': '2',
        'เงฉ': '3',
        'เงช': '4',
        'เงซ': '5',
        'เงฌ': '6',
        'เงญ': '7',
        'เงฎ': '8',
        'เงฏ': '9',
        'เงฆ': '0'
    };

    return moment.defineLocale('bn', {
        months : 'เฆเฆพเฆจเงเงเฆพเฆฐเง€_เฆซเงเฆฌเงเงเฆพเฆฐเง€_เฆฎเฆพเฆฐเงเฆ_เฆเฆชเงเฆฐเฆฟเฆฒ_เฆฎเง_เฆเงเฆจ_เฆเงเฆฒเฆพเฆ_เฆ…เฆ—เฆพเฆธเงเฆ_เฆธเงเฆชเงเฆเงเฆฎเงเฆฌเฆฐ_เฆ…เฆ•เงเฆเงเฆฌเฆฐ_เฆจเฆญเงเฆฎเงเฆฌเฆฐ_เฆกเฆฟเฆธเงเฆฎเงเฆฌเฆฐ'.split('_'),
        monthsShort : 'เฆเฆพเฆจเง_เฆซเงเฆฌ_เฆฎเฆพเฆฐเงเฆ_เฆเฆชเฆฐ_เฆฎเง_เฆเงเฆจ_เฆเงเฆฒ_เฆ…เฆ—_เฆธเงเฆชเงเฆ_เฆ…เฆ•เงเฆเง_เฆจเฆญ_เฆกเฆฟเฆธเงเฆฎเง'.split('_'),
        weekdays : 'เฆฐเฆฌเฆฟเฆฌเฆพเฆฐ_เฆธเงเฆฎเฆฌเฆพเฆฐ_เฆฎเฆเงเฆ—เฆฒเฆฌเฆพเฆฐ_เฆฌเงเฆงเฆฌเฆพเฆฐ_เฆฌเงเฆนเฆธเงเฆชเฆคเงเฆคเฆฟเฆฌเฆพเฆฐ_เฆถเงเฆ•เงเฆฐเงเฆฌเฆพเฆฐ_เฆถเฆจเฆฟเฆฌเฆพเฆฐ'.split('_'),
        weekdaysShort : 'เฆฐเฆฌเฆฟ_เฆธเงเฆฎ_เฆฎเฆเงเฆ—เฆฒ_เฆฌเงเฆง_เฆฌเงเฆนเฆธเงเฆชเฆคเงเฆคเฆฟ_เฆถเงเฆ•เงเฆฐเง_เฆถเฆจเฆฟ'.split('_'),
        weekdaysMin : 'เฆฐเฆฌ_เฆธเฆฎ_เฆฎเฆเงเฆ—_เฆฌเง_เฆฌเงเฆฐเฆฟเฆน_เฆถเง_เฆถเฆจเฆฟ'.split('_'),
        longDateFormat : {
            LT : 'A h:mm เฆธเฆฎเง',
            LTS : 'A h:mm:ss เฆธเฆฎเง',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        calendar : {
            sameDay : '[เฆเฆ] LT',
            nextDay : '[เฆเฆ—เฆพเฆฎเง€เฆ•เฆพเฆฒ] LT',
            nextWeek : 'dddd, LT',
            lastDay : '[เฆ—เฆคเฆ•เฆพเฆฒ] LT',
            lastWeek : '[เฆ—เฆค] dddd, LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s เฆชเฆฐเง',
            past : '%s เฆเฆ—เง',
            s : 'เฆ•เฆเฆ• เฆธเงเฆ•เงเฆจเงเฆก',
            m : 'เฆเฆ• เฆฎเฆฟเฆจเฆฟเฆ',
            mm : '%d เฆฎเฆฟเฆจเฆฟเฆ',
            h : 'เฆเฆ• เฆเฆจเงเฆเฆพ',
            hh : '%d เฆเฆจเงเฆเฆพ',
            d : 'เฆเฆ• เฆฆเฆฟเฆจ',
            dd : '%d เฆฆเฆฟเฆจ',
            M : 'เฆเฆ• เฆฎเฆพเฆธ',
            MM : '%d เฆฎเฆพเฆธ',
            y : 'เฆเฆ• เฆฌเฆเฆฐ',
            yy : '%d เฆฌเฆเฆฐ'
        },
        preparse: function (string) {
            return string.replace(/[เงงเงจเงฉเงชเงซเงฌเงญเงฎเงฏเงฆ]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },
        meridiemParse: /เฆฐเฆพเฆค|เฆถเฆ•เฆพเฆฒ|เฆฆเงเฆชเงเฆฐ|เฆฌเฆฟเฆ•เงเฆฒ|เฆฐเฆพเฆค/,
        isPM: function (input) {
            return /^(เฆฆเงเฆชเงเฆฐ|เฆฌเฆฟเฆ•เงเฆฒ|เฆฐเฆพเฆค)$/.test(input);
        },
        //Bengali is a vast language its spoken
        //in different forms in various parts of the world.
        //I have just generalized with most common one used
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'เฆฐเฆพเฆค';
            } else if (hour < 10) {
                return 'เฆถเฆ•เฆพเฆฒ';
            } else if (hour < 17) {
                return 'เฆฆเงเฆชเงเฆฐ';
            } else if (hour < 20) {
                return 'เฆฌเฆฟเฆ•เงเฆฒ';
            } else {
                return 'เฆฐเฆพเฆค';
            }
        },
        week : {
            dow : 0, // Sunday is the first day of the week.
            doy : 6  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : tibetan (bo)
// author : Thupten N. Chakrishar : https://github.com/vajradog

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'เผก',
        '2': 'เผข',
        '3': 'เผฃ',
        '4': 'เผค',
        '5': 'เผฅ',
        '6': 'เผฆ',
        '7': 'เผง',
        '8': 'เผจ',
        '9': 'เผฉ',
        '0': 'เผ '
    },
    numberMap = {
        'เผก': '1',
        'เผข': '2',
        'เผฃ': '3',
        'เผค': '4',
        'เผฅ': '5',
        'เผฆ': '6',
        'เผง': '7',
        'เผจ': '8',
        'เผฉ': '9',
        'เผ ': '0'
    };

    return moment.defineLocale('bo', {
        months : 'เฝเพณเผเฝ–เผเฝ‘เฝเผเฝ”เฝผ_เฝเพณเผเฝ–เผเฝเฝเฝฒเฝฆเผเฝ”_เฝเพณเผเฝ–เผเฝเฝฆเฝดเฝเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝเฝฒเผเฝ”_เฝเพณเผเฝ–เผเฝฃเพ”เผเฝ”_เฝเพณเผเฝ–เผเฝ‘เพฒเฝดเฝเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ‘เฝดเฝ“เผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝขเพ’เพฑเฝ‘เผเฝ”_เฝเพณเผเฝ–เผเฝ‘เฝเฝดเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ…เฝดเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ…เฝดเผเฝเฝ…เฝฒเฝเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ…เฝดเผเฝเฝเฝฒเฝฆเผเฝ”'.split('_'),
        monthsShort : 'เฝเพณเผเฝ–เผเฝ‘เฝเผเฝ”เฝผ_เฝเพณเผเฝ–เผเฝเฝเฝฒเฝฆเผเฝ”_เฝเพณเผเฝ–เผเฝเฝฆเฝดเฝเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝเฝฒเผเฝ”_เฝเพณเผเฝ–เผเฝฃเพ”เผเฝ”_เฝเพณเผเฝ–เผเฝ‘เพฒเฝดเฝเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ‘เฝดเฝ“เผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝขเพ’เพฑเฝ‘เผเฝ”_เฝเพณเผเฝ–เผเฝ‘เฝเฝดเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ…เฝดเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ…เฝดเผเฝเฝ…เฝฒเฝเผเฝ”_เฝเพณเผเฝ–เผเฝ–เฝ…เฝดเผเฝเฝเฝฒเฝฆเผเฝ”'.split('_'),
        weekdays : 'เฝเฝเฝ เผเฝเฝฒเผเฝเผ_เฝเฝเฝ เผเฝเพณเผเฝ–เผ_เฝเฝเฝ เผเฝเฝฒเฝเผเฝ‘เฝเฝขเผ_เฝเฝเฝ เผเฝฃเพทเฝเผเฝ”เผ_เฝเฝเฝ เผเฝ•เฝดเฝขเผเฝ–เฝด_เฝเฝเฝ เผเฝ”เผเฝฆเฝเฝฆเผ_เฝเฝเฝ เผเฝฆเพคเฝบเฝ“เผเฝ”เผ'.split('_'),
        weekdaysShort : 'เฝเฝฒเผเฝเผ_เฝเพณเผเฝ–เผ_เฝเฝฒเฝเผเฝ‘เฝเฝขเผ_เฝฃเพทเฝเผเฝ”เผ_เฝ•เฝดเฝขเผเฝ–เฝด_เฝ”เผเฝฆเฝเฝฆเผ_เฝฆเพคเฝบเฝ“เผเฝ”เผ'.split('_'),
        weekdaysMin : 'เฝเฝฒเผเฝเผ_เฝเพณเผเฝ–เผ_เฝเฝฒเฝเผเฝ‘เฝเฝขเผ_เฝฃเพทเฝเผเฝ”เผ_เฝ•เฝดเฝขเผเฝ–เฝด_เฝ”เผเฝฆเฝเฝฆเผ_เฝฆเพคเฝบเฝ“เผเฝ”เผ'.split('_'),
        longDateFormat : {
            LT : 'A h:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        calendar : {
            sameDay : '[เฝ‘เฝฒเผเฝขเฝฒเฝ] LT',
            nextDay : '[เฝฆเฝเผเฝเฝฒเฝ“] LT',
            nextWeek : '[เฝ–เฝ‘เฝดเฝ“เผเฝ•เพฒเฝเผเฝขเพ—เฝบเฝฆเผเฝ], LT',
            lastDay : '[เฝเผเฝฆเฝ] LT',
            lastWeek : '[เฝ–เฝ‘เฝดเฝ“เผเฝ•เพฒเฝเผเฝเฝเฝ เผเฝ] dddd, LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s เฝฃเผ',
            past : '%s เฝฆเพ”เฝ“เผเฝฃ',
            s : 'เฝฃเฝเผเฝฆเฝ',
            m : 'เฝฆเพเฝขเผเฝเผเฝเฝ…เฝฒเฝ',
            mm : '%d เฝฆเพเฝขเผเฝ',
            h : 'เฝเฝดเผเฝเฝผเฝ‘เผเฝเฝ…เฝฒเฝ',
            hh : '%d เฝเฝดเผเฝเฝผเฝ‘',
            d : 'เฝเฝฒเฝ“เผเฝเฝ…เฝฒเฝ',
            dd : '%d เฝเฝฒเฝ“เผ',
            M : 'เฝเพณเผเฝ–เผเฝเฝ…เฝฒเฝ',
            MM : '%d เฝเพณเผเฝ–',
            y : 'เฝฃเฝผเผเฝเฝ…เฝฒเฝ',
            yy : '%d เฝฃเฝผ'
        },
        preparse: function (string) {
            return string.replace(/[เผกเผขเผฃเผคเผฅเผฆเผงเผจเผฉเผ ]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },
        meridiemParse: /เฝเฝเฝ“เผเฝเฝผ|เฝเฝผเฝเฝฆเผเฝ€เฝฆ|เฝเฝฒเฝ“เผเฝเฝดเฝ|เฝ‘เฝเฝผเฝเผเฝ‘เฝ|เฝเฝเฝ“เผเฝเฝผ/,
        isPM: function (input) {
            return /^(เฝเฝฒเฝ“เผเฝเฝดเฝ|เฝ‘เฝเฝผเฝเผเฝ‘เฝ|เฝเฝเฝ“เผเฝเฝผ)$/.test(input);
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'เฝเฝเฝ“เผเฝเฝผ';
            } else if (hour < 10) {
                return 'เฝเฝผเฝเฝฆเผเฝ€เฝฆ';
            } else if (hour < 17) {
                return 'เฝเฝฒเฝ“เผเฝเฝดเฝ';
            } else if (hour < 20) {
                return 'เฝ‘เฝเฝผเฝเผเฝ‘เฝ';
            } else {
                return 'เฝเฝเฝ“เผเฝเฝผ';
            }
        },
        week : {
            dow : 0, // Sunday is the first day of the week.
            doy : 6  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : breton (br)
// author : Jean-Baptiste Le Duigou : https://github.com/jbleduigou

(function (factory) {
    factory(moment);
}(function (moment) {
    function relativeTimeWithMutation(number, withoutSuffix, key) {
        var format = {
            'mm': 'munutenn',
            'MM': 'miz',
            'dd': 'devezh'
        };
        return number + ' ' + mutation(format[key], number);
    }

    function specialMutationForYears(number) {
        switch (lastNumber(number)) {
        case 1:
        case 3:
        case 4:
        case 5:
        case 9:
            return number + ' bloaz';
        default:
            return number + ' vloaz';
        }
    }

    function lastNumber(number) {
        if (number > 9) {
            return lastNumber(number % 10);
        }
        return number;
    }

    function mutation(text, number) {
        if (number === 2) {
            return softMutation(text);
        }
        return text;
    }

    function softMutation(text) {
        var mutationTable = {
            'm': 'v',
            'b': 'v',
            'd': 'z'
        };
        if (mutationTable[text.charAt(0)] === undefined) {
            return text;
        }
        return mutationTable[text.charAt(0)] + text.substring(1);
    }

    return moment.defineLocale('br', {
        months : 'Genver_C\'hwevrer_Meurzh_Ebrel_Mae_Mezheven_Gouere_Eost_Gwengolo_Here_Du_Kerzu'.split('_'),
        monthsShort : 'Gen_C\'hwe_Meu_Ebr_Mae_Eve_Gou_Eos_Gwe_Her_Du_Ker'.split('_'),
        weekdays : 'Sul_Lun_Meurzh_Merc\'her_Yaou_Gwener_Sadorn'.split('_'),
        weekdaysShort : 'Sul_Lun_Meu_Mer_Yao_Gwe_Sad'.split('_'),
        weekdaysMin : 'Su_Lu_Me_Mer_Ya_Gw_Sa'.split('_'),
        longDateFormat : {
            LT : 'h[e]mm A',
            LTS : 'h[e]mm:ss A',
            L : 'DD/MM/YYYY',
            LL : 'D [a viz] MMMM YYYY',
            LLL : 'D [a viz] MMMM YYYY LT',
            LLLL : 'dddd, D [a viz] MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[Hiziv da] LT',
            nextDay : '[Warc\'hoazh da] LT',
            nextWeek : 'dddd [da] LT',
            lastDay : '[Dec\'h da] LT',
            lastWeek : 'dddd [paset da] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'a-benn %s',
            past : '%s \'zo',
            s : 'un nebeud segondennoรน',
            m : 'ur vunutenn',
            mm : relativeTimeWithMutation,
            h : 'un eur',
            hh : '%d eur',
            d : 'un devezh',
            dd : relativeTimeWithMutation,
            M : 'ur miz',
            MM : relativeTimeWithMutation,
            y : 'ur bloaz',
            yy : specialMutationForYears
        },
        ordinalParse: /\d{1,2}(aรฑ|vet)/,
        ordinal : function (number) {
            var output = (number === 1) ? 'aรฑ' : 'vet';
            return number + output;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : bosnian (bs)
// author : Nedim Cholich : https://github.com/frontyard
// based on (hr) translation by Bojan Markoviฤ

(function (factory) {
    factory(moment);
}(function (moment) {
    function translate(number, withoutSuffix, key) {
        var result = number + ' ';
        switch (key) {
        case 'm':
            return withoutSuffix ? 'jedna minuta' : 'jedne minute';
        case 'mm':
            if (number === 1) {
                result += 'minuta';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'minute';
            } else {
                result += 'minuta';
            }
            return result;
        case 'h':
            return withoutSuffix ? 'jedan sat' : 'jednog sata';
        case 'hh':
            if (number === 1) {
                result += 'sat';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'sata';
            } else {
                result += 'sati';
            }
            return result;
        case 'dd':
            if (number === 1) {
                result += 'dan';
            } else {
                result += 'dana';
            }
            return result;
        case 'MM':
            if (number === 1) {
                result += 'mjesec';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'mjeseca';
            } else {
                result += 'mjeseci';
            }
            return result;
        case 'yy':
            if (number === 1) {
                result += 'godina';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'godine';
            } else {
                result += 'godina';
            }
            return result;
        }
    }

    return moment.defineLocale('bs', {
        months : 'januar_februar_mart_april_maj_juni_juli_august_septembar_oktobar_novembar_decembar'.split('_'),
        monthsShort : 'jan._feb._mar._apr._maj._jun._jul._aug._sep._okt._nov._dec.'.split('_'),
        weekdays : 'nedjelja_ponedjeljak_utorak_srijeda_ฤetvrtak_petak_subota'.split('_'),
        weekdaysShort : 'ned._pon._uto._sri._ฤet._pet._sub.'.split('_'),
        weekdaysMin : 'ne_po_ut_sr_ฤe_pe_su'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD. MM. YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd, D. MMMM YYYY LT'
        },
        calendar : {
            sameDay  : '[danas u] LT',
            nextDay  : '[sutra u] LT',

            nextWeek : function () {
                switch (this.day()) {
                case 0:
                    return '[u] [nedjelju] [u] LT';
                case 3:
                    return '[u] [srijedu] [u] LT';
                case 6:
                    return '[u] [subotu] [u] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[u] dddd [u] LT';
                }
            },
            lastDay  : '[juฤer u] LT',
            lastWeek : function () {
                switch (this.day()) {
                case 0:
                case 3:
                    return '[proลกlu] dddd [u] LT';
                case 6:
                    return '[proลกle] [subote] [u] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[proลกli] dddd [u] LT';
                }
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'za %s',
            past   : 'prije %s',
            s      : 'par sekundi',
            m      : translate,
            mm     : translate,
            h      : translate,
            hh     : translate,
            d      : 'dan',
            dd     : translate,
            M      : 'mjesec',
            MM     : translate,
            y      : 'godinu',
            yy     : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : catalan (ca)
// author : Juan G. Hurtado : https://github.com/juanghurtado

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ca', {
        months : 'gener_febrer_marรง_abril_maig_juny_juliol_agost_setembre_octubre_novembre_desembre'.split('_'),
        monthsShort : 'gen._febr._mar._abr._mai._jun._jul._ag._set._oct._nov._des.'.split('_'),
        weekdays : 'diumenge_dilluns_dimarts_dimecres_dijous_divendres_dissabte'.split('_'),
        weekdaysShort : 'dg._dl._dt._dc._dj._dv._ds.'.split('_'),
        weekdaysMin : 'Dg_Dl_Dt_Dc_Dj_Dv_Ds'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay : function () {
                return '[avui a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
            },
            nextDay : function () {
                return '[demร  a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
            },
            nextWeek : function () {
                return 'dddd [a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
            },
            lastDay : function () {
                return '[ahir a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
            },
            lastWeek : function () {
                return '[el] dddd [passat a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'en %s',
            past : 'fa %s',
            s : 'uns segons',
            m : 'un minut',
            mm : '%d minuts',
            h : 'una hora',
            hh : '%d hores',
            d : 'un dia',
            dd : '%d dies',
            M : 'un mes',
            MM : '%d mesos',
            y : 'un any',
            yy : '%d anys'
        },
        ordinalParse: /\d{1,2}(r|n|t|รจ|a)/,
        ordinal : function (number, period) {
            var output = (number === 1) ? 'r' :
                (number === 2) ? 'n' :
                (number === 3) ? 'r' :
                (number === 4) ? 't' : 'รจ';
            if (period === 'w' || period === 'W') {
                output = 'a';
            }
            return number + output;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : czech (cs)
// author : petrbela : https://github.com/petrbela

(function (factory) {
    factory(moment);
}(function (moment) {
    var months = 'leden_รบnor_bลezen_duben_kvฤten_ฤerven_ฤervenec_srpen_zรกลรญ_ลรญjen_listopad_prosinec'.split('_'),
        monthsShort = 'led_รบno_bลe_dub_kvฤ_ฤvn_ฤvc_srp_zรกล_ลรญj_lis_pro'.split('_');

    function plural(n) {
        return (n > 1) && (n < 5) && (~~(n / 10) !== 1);
    }

    function translate(number, withoutSuffix, key, isFuture) {
        var result = number + ' ';
        switch (key) {
        case 's':  // a few seconds / in a few seconds / a few seconds ago
            return (withoutSuffix || isFuture) ? 'pรกr sekund' : 'pรกr sekundami';
        case 'm':  // a minute / in a minute / a minute ago
            return withoutSuffix ? 'minuta' : (isFuture ? 'minutu' : 'minutou');
        case 'mm': // 9 minutes / in 9 minutes / 9 minutes ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'minuty' : 'minut');
            } else {
                return result + 'minutami';
            }
            break;
        case 'h':  // an hour / in an hour / an hour ago
            return withoutSuffix ? 'hodina' : (isFuture ? 'hodinu' : 'hodinou');
        case 'hh': // 9 hours / in 9 hours / 9 hours ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'hodiny' : 'hodin');
            } else {
                return result + 'hodinami';
            }
            break;
        case 'd':  // a day / in a day / a day ago
            return (withoutSuffix || isFuture) ? 'den' : 'dnem';
        case 'dd': // 9 days / in 9 days / 9 days ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'dny' : 'dnรญ');
            } else {
                return result + 'dny';
            }
            break;
        case 'M':  // a month / in a month / a month ago
            return (withoutSuffix || isFuture) ? 'mฤsรญc' : 'mฤsรญcem';
        case 'MM': // 9 months / in 9 months / 9 months ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'mฤsรญce' : 'mฤsรญcลฏ');
            } else {
                return result + 'mฤsรญci';
            }
            break;
        case 'y':  // a year / in a year / a year ago
            return (withoutSuffix || isFuture) ? 'rok' : 'rokem';
        case 'yy': // 9 years / in 9 years / 9 years ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'roky' : 'let');
            } else {
                return result + 'lety';
            }
            break;
        }
    }

    return moment.defineLocale('cs', {
        months : months,
        monthsShort : monthsShort,
        monthsParse : (function (months, monthsShort) {
            var i, _monthsParse = [];
            for (i = 0; i < 12; i++) {
                // use custom parser to solve problem with July (ฤervenec)
                _monthsParse[i] = new RegExp('^' + months[i] + '$|^' + monthsShort[i] + '$', 'i');
            }
            return _monthsParse;
        }(months, monthsShort)),
        weekdays : 'nedฤle_pondฤlรญ_รบterรฝ_stลeda_ฤtvrtek_pรกtek_sobota'.split('_'),
        weekdaysShort : 'ne_po_รบt_st_ฤt_pรก_so'.split('_'),
        weekdaysMin : 'ne_po_รบt_st_ฤt_pรก_so'.split('_'),
        longDateFormat : {
            LT: 'H:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd D. MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[dnes v] LT',
            nextDay: '[zรญtra v] LT',
            nextWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[v nedฤli v] LT';
                case 1:
                case 2:
                    return '[v] dddd [v] LT';
                case 3:
                    return '[ve stลedu v] LT';
                case 4:
                    return '[ve ฤtvrtek v] LT';
                case 5:
                    return '[v pรกtek v] LT';
                case 6:
                    return '[v sobotu v] LT';
                }
            },
            lastDay: '[vฤera v] LT',
            lastWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[minulou nedฤli v] LT';
                case 1:
                case 2:
                    return '[minulรฉ] dddd [v] LT';
                case 3:
                    return '[minulou stลedu v] LT';
                case 4:
                case 5:
                    return '[minulรฝ] dddd [v] LT';
                case 6:
                    return '[minulou sobotu v] LT';
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'za %s',
            past : 'pลed %s',
            s : translate,
            m : translate,
            mm : translate,
            h : translate,
            hh : translate,
            d : translate,
            dd : translate,
            M : translate,
            MM : translate,
            y : translate,
            yy : translate
        },
        ordinalParse : /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : chuvash (cv)
// author : Anatoly Mironov : https://github.com/mirontoli

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('cv', {
        months : 'ะบฤั€ะปะฐั_ะฝะฐั€ฤั_ะฟัั_ะฐะบะฐ_ะผะฐะน_รงฤ•ั€ัะผะต_ััฤ_รงัั€ะปะฐ_ะฐะฒฤะฝ_ัะฟะฐ_ัำณะบ_ั€ะฐััะฐะฒ'.split('_'),
        monthsShort : 'ะบฤั€_ะฝะฐั€_ะฟัั_ะฐะบะฐ_ะผะฐะน_รงฤ•ั€_ััฤ_รงัั€_ะฐะฒ_ัะฟะฐ_ัำณะบ_ั€ะฐั'.split('_'),
        weekdays : 'ะฒัั€ัะฐั€ะฝะธะบัะฝ_ััะฝัะธะบัะฝ_ััะปะฐั€ะธะบัะฝ_ัะฝะบัะฝ_ะบฤ•รงะฝะตั€ะฝะธะบัะฝ_ัั€ะฝะตะบัะฝ_ัฤะผะฐัะบัะฝ'.split('_'),
        weekdaysShort : 'ะฒัั€_ััะฝ_ััะป_ัะฝ_ะบฤ•รง_ัั€ะฝ_ัฤะผ'.split('_'),
        weekdaysMin : 'ะฒั€_ัะฝ_ัั_ัะฝ_ะบรง_ัั€_ัะผ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD-MM-YYYY',
            LL : 'YYYY [รงัะปั…ะธ] MMMM [ัะนฤั…ฤ•ะฝ] D[-ะผฤ•ัฤ•]',
            LLL : 'YYYY [รงัะปั…ะธ] MMMM [ัะนฤั…ฤ•ะฝ] D[-ะผฤ•ัฤ•], LT',
            LLLL : 'dddd, YYYY [รงัะปั…ะธ] MMMM [ัะนฤั…ฤ•ะฝ] D[-ะผฤ•ัฤ•], LT'
        },
        calendar : {
            sameDay: '[ะะฐัะฝ] LT [ัะตั…ะตัั€ะต]',
            nextDay: '[ะซั€ะฐะฝ] LT [ัะตั…ะตัั€ะต]',
            lastDay: '[ฤ”ะฝะตั€] LT [ัะตั…ะตัั€ะต]',
            nextWeek: '[ระธัะตั] dddd LT [ัะตั…ะตัั€ะต]',
            lastWeek: '[ะั€ัะฝฤ•] dddd LT [ัะตั…ะตัั€ะต]',
            sameElse: 'L'
        },
        relativeTime : {
            future : function (output) {
                var affix = /ัะตั…ะตั$/i.exec(output) ? 'ั€ะตะฝ' : /รงัะป$/i.exec(output) ? 'ัะฐะฝ' : 'ั€ะฐะฝ';
                return output + affix;
            },
            past : '%s ะบะฐัะปะปะฐ',
            s : 'ะฟฤ•ั€-ะธะบ รงะตะบะบัะฝั',
            m : 'ะฟฤ•ั€ ะผะธะฝัั',
            mm : '%d ะผะธะฝัั',
            h : 'ะฟฤ•ั€ ัะตั…ะตั',
            hh : '%d ัะตั…ะตั',
            d : 'ะฟฤ•ั€ ะบัะฝ',
            dd : '%d ะบัะฝ',
            M : 'ะฟฤ•ั€ ัะนฤั…',
            MM : '%d ัะนฤั…',
            y : 'ะฟฤ•ั€ รงัะป',
            yy : '%d รงัะป'
        },
        ordinalParse: /\d{1,2}-ะผฤ•ั/,
        ordinal : '%d-ะผฤ•ั',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Welsh (cy)
// author : Robert Allen

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('cy', {
        months: 'Ionawr_Chwefror_Mawrth_Ebrill_Mai_Mehefin_Gorffennaf_Awst_Medi_Hydref_Tachwedd_Rhagfyr'.split('_'),
        monthsShort: 'Ion_Chwe_Maw_Ebr_Mai_Meh_Gor_Aws_Med_Hyd_Tach_Rhag'.split('_'),
        weekdays: 'Dydd Sul_Dydd Llun_Dydd Mawrth_Dydd Mercher_Dydd Iau_Dydd Gwener_Dydd Sadwrn'.split('_'),
        weekdaysShort: 'Sul_Llun_Maw_Mer_Iau_Gwe_Sad'.split('_'),
        weekdaysMin: 'Su_Ll_Ma_Me_Ia_Gw_Sa'.split('_'),
        // time formats are the same as en-gb
        longDateFormat: {
            LT: 'HH:mm',
            LTS : 'LT:ss',
            L: 'DD/MM/YYYY',
            LL: 'D MMMM YYYY',
            LLL: 'D MMMM YYYY LT',
            LLLL: 'dddd, D MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[Heddiw am] LT',
            nextDay: '[Yfory am] LT',
            nextWeek: 'dddd [am] LT',
            lastDay: '[Ddoe am] LT',
            lastWeek: 'dddd [diwethaf am] LT',
            sameElse: 'L'
        },
        relativeTime: {
            future: 'mewn %s',
            past: '%s yn รดl',
            s: 'ychydig eiliadau',
            m: 'munud',
            mm: '%d munud',
            h: 'awr',
            hh: '%d awr',
            d: 'diwrnod',
            dd: '%d diwrnod',
            M: 'mis',
            MM: '%d mis',
            y: 'blwyddyn',
            yy: '%d flynedd'
        },
        ordinalParse: /\d{1,2}(fed|ain|af|il|ydd|ed|eg)/,
        // traditional ordinal numbers above 31 are not commonly used in colloquial Welsh
        ordinal: function (number) {
            var b = number,
                output = '',
                lookup = [
                    '', 'af', 'il', 'ydd', 'ydd', 'ed', 'ed', 'ed', 'fed', 'fed', 'fed', // 1af to 10fed
                    'eg', 'fed', 'eg', 'eg', 'fed', 'eg', 'eg', 'fed', 'eg', 'fed' // 11eg to 20fed
                ];

            if (b > 20) {
                if (b === 40 || b === 50 || b === 60 || b === 80 || b === 100) {
                    output = 'fed'; // not 30ain, 70ain or 90ain
                } else {
                    output = 'ain';
                }
            } else if (b > 0) {
                output = lookup[b];
            }

            return number + output;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : danish (da)
// author : Ulrik Nielsen : https://github.com/mrbase

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('da', {
        months : 'januar_februar_marts_april_maj_juni_juli_august_september_oktober_november_december'.split('_'),
        monthsShort : 'jan_feb_mar_apr_maj_jun_jul_aug_sep_okt_nov_dec'.split('_'),
        weekdays : 'sรธndag_mandag_tirsdag_onsdag_torsdag_fredag_lรธrdag'.split('_'),
        weekdaysShort : 'sรธn_man_tir_ons_tor_fre_lรธr'.split('_'),
        weekdaysMin : 'sรธ_ma_ti_on_to_fr_lรธ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd [d.] D. MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[I dag kl.] LT',
            nextDay : '[I morgen kl.] LT',
            nextWeek : 'dddd [kl.] LT',
            lastDay : '[I gรฅr kl.] LT',
            lastWeek : '[sidste] dddd [kl] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'om %s',
            past : '%s siden',
            s : 'fรฅ sekunder',
            m : 'et minut',
            mm : '%d minutter',
            h : 'en time',
            hh : '%d timer',
            d : 'en dag',
            dd : '%d dage',
            M : 'en mรฅned',
            MM : '%d mรฅneder',
            y : 'et รฅr',
            yy : '%d รฅr'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : austrian german (de-at)
// author : lluchs : https://github.com/lluchs
// author: Menelion Elensรบle: https://github.com/Oire
// author : Martin Groller : https://github.com/MadMG

(function (factory) {
    factory(moment);
}(function (moment) {
    function processRelativeTime(number, withoutSuffix, key, isFuture) {
        var format = {
            'm': ['eine Minute', 'einer Minute'],
            'h': ['eine Stunde', 'einer Stunde'],
            'd': ['ein Tag', 'einem Tag'],
            'dd': [number + ' Tage', number + ' Tagen'],
            'M': ['ein Monat', 'einem Monat'],
            'MM': [number + ' Monate', number + ' Monaten'],
            'y': ['ein Jahr', 'einem Jahr'],
            'yy': [number + ' Jahre', number + ' Jahren']
        };
        return withoutSuffix ? format[key][0] : format[key][1];
    }

    return moment.defineLocale('de-at', {
        months : 'Jรคnner_Februar_Mรคrz_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
        monthsShort : 'Jรคn._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
        weekdays : 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
        weekdaysShort : 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
        weekdaysMin : 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
        longDateFormat : {
            LT: 'HH:mm',
            LTS: 'HH:mm:ss',
            L : 'DD.MM.YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd, D. MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Heute um] LT [Uhr]',
            sameElse: 'L',
            nextDay: '[Morgen um] LT [Uhr]',
            nextWeek: 'dddd [um] LT [Uhr]',
            lastDay: '[Gestern um] LT [Uhr]',
            lastWeek: '[letzten] dddd [um] LT [Uhr]'
        },
        relativeTime : {
            future : 'in %s',
            past : 'vor %s',
            s : 'ein paar Sekunden',
            m : processRelativeTime,
            mm : '%d Minuten',
            h : processRelativeTime,
            hh : '%d Stunden',
            d : processRelativeTime,
            dd : processRelativeTime,
            M : processRelativeTime,
            MM : processRelativeTime,
            y : processRelativeTime,
            yy : processRelativeTime
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : german (de)
// author : lluchs : https://github.com/lluchs
// author: Menelion Elensรบle: https://github.com/Oire

(function (factory) {
    factory(moment);
}(function (moment) {
    function processRelativeTime(number, withoutSuffix, key, isFuture) {
        var format = {
            'm': ['eine Minute', 'einer Minute'],
            'h': ['eine Stunde', 'einer Stunde'],
            'd': ['ein Tag', 'einem Tag'],
            'dd': [number + ' Tage', number + ' Tagen'],
            'M': ['ein Monat', 'einem Monat'],
            'MM': [number + ' Monate', number + ' Monaten'],
            'y': ['ein Jahr', 'einem Jahr'],
            'yy': [number + ' Jahre', number + ' Jahren']
        };
        return withoutSuffix ? format[key][0] : format[key][1];
    }

    return moment.defineLocale('de', {
        months : 'Januar_Februar_Mรคrz_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
        monthsShort : 'Jan._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
        weekdays : 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
        weekdaysShort : 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
        weekdaysMin : 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
        longDateFormat : {
            LT: 'HH:mm',
            LTS: 'HH:mm:ss',
            L : 'DD.MM.YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd, D. MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Heute um] LT [Uhr]',
            sameElse: 'L',
            nextDay: '[Morgen um] LT [Uhr]',
            nextWeek: 'dddd [um] LT [Uhr]',
            lastDay: '[Gestern um] LT [Uhr]',
            lastWeek: '[letzten] dddd [um] LT [Uhr]'
        },
        relativeTime : {
            future : 'in %s',
            past : 'vor %s',
            s : 'ein paar Sekunden',
            m : processRelativeTime,
            mm : '%d Minuten',
            h : processRelativeTime,
            hh : '%d Stunden',
            d : processRelativeTime,
            dd : processRelativeTime,
            M : processRelativeTime,
            MM : processRelativeTime,
            y : processRelativeTime,
            yy : processRelativeTime
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : modern greek (el)
// author : Aggelos Karalias : https://github.com/mehiel

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('el', {
        monthsNominativeEl : 'ฮฮฑฮฝฮฟฯ…ฮฌฯฮนฮฟฯ_ฮฆฮตฮฒฯฮฟฯ…ฮฌฯฮนฮฟฯ_ฮฮฌฯฯฮนฮฟฯ_ฮ‘ฯ€ฯฮฏฮปฮนฮฟฯ_ฮฮฌฮนฮฟฯ_ฮฮฟฯฮฝฮนฮฟฯ_ฮฮฟฯฮปฮนฮฟฯ_ฮ‘ฯฮณฮฟฯ…ฯฯฮฟฯ_ฮฃฮตฯ€ฯฮญฮผฮฒฯฮนฮฟฯ_ฮฮบฯฯฮฒฯฮนฮฟฯ_ฮฮฟฮญฮผฮฒฯฮนฮฟฯ_ฮ”ฮตฮบฮญฮผฮฒฯฮนฮฟฯ'.split('_'),
        monthsGenitiveEl : 'ฮฮฑฮฝฮฟฯ…ฮฑฯฮฏฮฟฯ…_ฮฆฮตฮฒฯฮฟฯ…ฮฑฯฮฏฮฟฯ…_ฮฮฑฯฯฮฏฮฟฯ…_ฮ‘ฯ€ฯฮนฮปฮฏฮฟฯ…_ฮฮฑฮฮฟฯ…_ฮฮฟฯ…ฮฝฮฏฮฟฯ…_ฮฮฟฯ…ฮปฮฏฮฟฯ…_ฮ‘ฯ…ฮณฮฟฯฯฯฮฟฯ…_ฮฃฮตฯ€ฯฮตฮผฮฒฯฮฏฮฟฯ…_ฮฮบฯฯฮฒฯฮฏฮฟฯ…_ฮฮฟฮตฮผฮฒฯฮฏฮฟฯ…_ฮ”ฮตฮบฮตฮผฮฒฯฮฏฮฟฯ…'.split('_'),
        months : function (momentToFormat, format) {
            if (/D/.test(format.substring(0, format.indexOf('MMMM')))) { // if there is a day number before 'MMMM'
                return this._monthsGenitiveEl[momentToFormat.month()];
            } else {
                return this._monthsNominativeEl[momentToFormat.month()];
            }
        },
        monthsShort : 'ฮฮฑฮฝ_ฮฆฮตฮฒ_ฮฮฑฯ_ฮ‘ฯ€ฯ_ฮฮฑฯ_ฮฮฟฯ…ฮฝ_ฮฮฟฯ…ฮป_ฮ‘ฯ…ฮณ_ฮฃฮตฯ€_ฮฮบฯ_ฮฮฟฮต_ฮ”ฮตฮบ'.split('_'),
        weekdays : 'ฮฯ…ฯฮนฮฑฮบฮฎ_ฮ”ฮตฯ…ฯฮญฯฮฑ_ฮคฯฮฏฯฮท_ฮคฮตฯฮฌฯฯฮท_ฮ ฮญฮผฯ€ฯฮท_ฮ ฮฑฯฮฑฯฮบฮตฯ…ฮฎ_ฮฃฮฌฮฒฮฒฮฑฯฮฟ'.split('_'),
        weekdaysShort : 'ฮฯ…ฯ_ฮ”ฮตฯ…_ฮคฯฮน_ฮคฮตฯ_ฮ ฮตฮผ_ฮ ฮฑฯ_ฮฃฮฑฮฒ'.split('_'),
        weekdaysMin : 'ฮฯ…_ฮ”ฮต_ฮคฯ_ฮคฮต_ฮ ฮต_ฮ ฮฑ_ฮฃฮฑ'.split('_'),
        meridiem : function (hours, minutes, isLower) {
            if (hours > 11) {
                return isLower ? 'ฮผฮผ' : 'ฮฮ';
            } else {
                return isLower ? 'ฯ€ฮผ' : 'ฮ ฮ';
            }
        },
        isPM : function (input) {
            return ((input + '').toLowerCase()[0] === 'ฮผ');
        },
        meridiemParse : /[ฮ ฮ]\.?ฮ?\.?/i,
        longDateFormat : {
            LT : 'h:mm A',
            LTS : 'h:mm:ss A',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendarEl : {
            sameDay : '[ฮฃฮฎฮผฮตฯฮฑ {}] LT',
            nextDay : '[ฮ‘ฯฯฮนฮฟ {}] LT',
            nextWeek : 'dddd [{}] LT',
            lastDay : '[ฮงฮธฮตฯ {}] LT',
            lastWeek : function () {
                switch (this.day()) {
                    case 6:
                        return '[ฯฮฟ ฯ€ฯฮฟฮทฮณฮฟฯฮผฮตฮฝฮฟ] dddd [{}] LT';
                    default:
                        return '[ฯฮทฮฝ ฯ€ฯฮฟฮทฮณฮฟฯฮผฮตฮฝฮท] dddd [{}] LT';
                }
            },
            sameElse : 'L'
        },
        calendar : function (key, mom) {
            var output = this._calendarEl[key],
                hours = mom && mom.hours();

            if (typeof output === 'function') {
                output = output.apply(mom);
            }

            return output.replace('{}', (hours % 12 === 1 ? 'ฯฯฮท' : 'ฯฯฮนฯ'));
        },
        relativeTime : {
            future : 'ฯฮต %s',
            past : '%s ฯ€ฯฮนฮฝ',
            s : 'ฮปฮฏฮณฮฑ ฮดฮตฯ…ฯฮตฯฯฮปฮตฯ€ฯฮฑ',
            m : 'ฮญฮฝฮฑ ฮปฮตฯ€ฯฯ',
            mm : '%d ฮปฮตฯ€ฯฮฌ',
            h : 'ฮผฮฏฮฑ ฯฯฮฑ',
            hh : '%d ฯฯฮตฯ',
            d : 'ฮผฮฏฮฑ ฮผฮญฯฮฑ',
            dd : '%d ฮผฮญฯฮตฯ',
            M : 'ฮญฮฝฮฑฯ ฮผฮฎฮฝฮฑฯ',
            MM : '%d ฮผฮฎฮฝฮตฯ',
            y : 'ฮญฮฝฮฑฯ ฯฯฯฮฝฮฟฯ',
            yy : '%d ฯฯฯฮฝฮนฮฑ'
        },
        ordinalParse: /\d{1,2}ฮท/,
        ordinal: '%dฮท',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : australian english (en-au)

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('en-au', {
        months : 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
        monthsShort : 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
        weekdays : 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
        weekdaysShort : 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
        weekdaysMin : 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
        longDateFormat : {
            LT : 'h:mm A',
            LTS : 'h:mm:ss A',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[Today at] LT',
            nextDay : '[Tomorrow at] LT',
            nextWeek : 'dddd [at] LT',
            lastDay : '[Yesterday at] LT',
            lastWeek : '[Last] dddd [at] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'in %s',
            past : '%s ago',
            s : 'a few seconds',
            m : 'a minute',
            mm : '%d minutes',
            h : 'an hour',
            hh : '%d hours',
            d : 'a day',
            dd : '%d days',
            M : 'a month',
            MM : '%d months',
            y : 'a year',
            yy : '%d years'
        },
        ordinalParse: /\d{1,2}(st|nd|rd|th)/,
        ordinal : function (number) {
            var b = number % 10,
                output = (~~(number % 100 / 10) === 1) ? 'th' :
                (b === 1) ? 'st' :
                (b === 2) ? 'nd' :
                (b === 3) ? 'rd' : 'th';
            return number + output;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : canadian english (en-ca)
// author : Jonathan Abourbih : https://github.com/jonbca

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('en-ca', {
        months : 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
        monthsShort : 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
        weekdays : 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
        weekdaysShort : 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
        weekdaysMin : 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
        longDateFormat : {
            LT : 'h:mm A',
            LTS : 'h:mm:ss A',
            L : 'YYYY-MM-DD',
            LL : 'D MMMM, YYYY',
            LLL : 'D MMMM, YYYY LT',
            LLLL : 'dddd, D MMMM, YYYY LT'
        },
        calendar : {
            sameDay : '[Today at] LT',
            nextDay : '[Tomorrow at] LT',
            nextWeek : 'dddd [at] LT',
            lastDay : '[Yesterday at] LT',
            lastWeek : '[Last] dddd [at] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'in %s',
            past : '%s ago',
            s : 'a few seconds',
            m : 'a minute',
            mm : '%d minutes',
            h : 'an hour',
            hh : '%d hours',
            d : 'a day',
            dd : '%d days',
            M : 'a month',
            MM : '%d months',
            y : 'a year',
            yy : '%d years'
        },
        ordinalParse: /\d{1,2}(st|nd|rd|th)/,
        ordinal : function (number) {
            var b = number % 10,
                output = (~~(number % 100 / 10) === 1) ? 'th' :
                (b === 1) ? 'st' :
                (b === 2) ? 'nd' :
                (b === 3) ? 'rd' : 'th';
            return number + output;
        }
    });
}));
// moment.js locale configuration
// locale : great britain english (en-gb)
// author : Chris Gedrim : https://github.com/chrisgedrim

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('en-gb', {
        months : 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
        monthsShort : 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
        weekdays : 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
        weekdaysShort : 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
        weekdaysMin : 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[Today at] LT',
            nextDay : '[Tomorrow at] LT',
            nextWeek : 'dddd [at] LT',
            lastDay : '[Yesterday at] LT',
            lastWeek : '[Last] dddd [at] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'in %s',
            past : '%s ago',
            s : 'a few seconds',
            m : 'a minute',
            mm : '%d minutes',
            h : 'an hour',
            hh : '%d hours',
            d : 'a day',
            dd : '%d days',
            M : 'a month',
            MM : '%d months',
            y : 'a year',
            yy : '%d years'
        },
        ordinalParse: /\d{1,2}(st|nd|rd|th)/,
        ordinal : function (number) {
            var b = number % 10,
                output = (~~(number % 100 / 10) === 1) ? 'th' :
                (b === 1) ? 'st' :
                (b === 2) ? 'nd' :
                (b === 3) ? 'rd' : 'th';
            return number + output;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : esperanto (eo)
// author : Colin Dean : https://github.com/colindean
// komento: Mi estas malcerta se mi korekte traktis akuzativojn en tiu traduko.
//          Se ne, bonvolu korekti kaj avizi min por ke mi povas lerni!

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('eo', {
        months : 'januaro_februaro_marto_aprilo_majo_junio_julio_aลญgusto_septembro_oktobro_novembro_decembro'.split('_'),
        monthsShort : 'jan_feb_mar_apr_maj_jun_jul_aลญg_sep_okt_nov_dec'.split('_'),
        weekdays : 'Dimanฤo_Lundo_Mardo_Merkredo_ฤดaลญdo_Vendredo_Sabato'.split('_'),
        weekdaysShort : 'Dim_Lun_Mard_Merk_ฤดaลญ_Ven_Sab'.split('_'),
        weekdaysMin : 'Di_Lu_Ma_Me_ฤดa_Ve_Sa'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'YYYY-MM-DD',
            LL : 'D[-an de] MMMM, YYYY',
            LLL : 'D[-an de] MMMM, YYYY LT',
            LLLL : 'dddd, [la] D[-an de] MMMM, YYYY LT'
        },
        meridiemParse: /[ap]\.t\.m/i,
        isPM: function (input) {
            return input.charAt(0).toLowerCase() === 'p';
        },
        meridiem : function (hours, minutes, isLower) {
            if (hours > 11) {
                return isLower ? 'p.t.m.' : 'P.T.M.';
            } else {
                return isLower ? 'a.t.m.' : 'A.T.M.';
            }
        },
        calendar : {
            sameDay : '[Hodiaลญ je] LT',
            nextDay : '[Morgaลญ je] LT',
            nextWeek : 'dddd [je] LT',
            lastDay : '[Hieraลญ je] LT',
            lastWeek : '[pasinta] dddd [je] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'je %s',
            past : 'antaลญ %s',
            s : 'sekundoj',
            m : 'minuto',
            mm : '%d minutoj',
            h : 'horo',
            hh : '%d horoj',
            d : 'tago',//ne 'diurno', ฤar estas uzita por proksimumo
            dd : '%d tagoj',
            M : 'monato',
            MM : '%d monatoj',
            y : 'jaro',
            yy : '%d jaroj'
        },
        ordinalParse: /\d{1,2}a/,
        ordinal : '%da',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : spanish (es)
// author : Julio Napurรญ : https://github.com/julionc

(function (factory) {
    factory(moment);
}(function (moment) {
    var monthsShortDot = 'ene._feb._mar._abr._may._jun._jul._ago._sep._oct._nov._dic.'.split('_'),
        monthsShort = 'ene_feb_mar_abr_may_jun_jul_ago_sep_oct_nov_dic'.split('_');

    return moment.defineLocale('es', {
        months : 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'.split('_'),
        monthsShort : function (m, format) {
            if (/-MMM-/.test(format)) {
                return monthsShort[m.month()];
            } else {
                return monthsShortDot[m.month()];
            }
        },
        weekdays : 'domingo_lunes_martes_miรฉrcoles_jueves_viernes_sรกbado'.split('_'),
        weekdaysShort : 'dom._lun._mar._miรฉ._jue._vie._sรกb.'.split('_'),
        weekdaysMin : 'Do_Lu_Ma_Mi_Ju_Vi_Sรก'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D [de] MMMM [de] YYYY',
            LLL : 'D [de] MMMM [de] YYYY LT',
            LLLL : 'dddd, D [de] MMMM [de] YYYY LT'
        },
        calendar : {
            sameDay : function () {
                return '[hoy a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
            },
            nextDay : function () {
                return '[maรฑana a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
            },
            nextWeek : function () {
                return 'dddd [a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
            },
            lastDay : function () {
                return '[ayer a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
            },
            lastWeek : function () {
                return '[el] dddd [pasado a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'en %s',
            past : 'hace %s',
            s : 'unos segundos',
            m : 'un minuto',
            mm : '%d minutos',
            h : 'una hora',
            hh : '%d horas',
            d : 'un dรญa',
            dd : '%d dรญas',
            M : 'un mes',
            MM : '%d meses',
            y : 'un aรฑo',
            yy : '%d aรฑos'
        },
        ordinalParse : /\d{1,2}ยบ/,
        ordinal : '%dยบ',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : estonian (et)
// author : Henry Kehlmann : https://github.com/madhenry
// improvements : Illimar Tambek : https://github.com/ragulka

(function (factory) {
    factory(moment);
}(function (moment) {
    function processRelativeTime(number, withoutSuffix, key, isFuture) {
        var format = {
            's' : ['mรตne sekundi', 'mรตni sekund', 'paar sekundit'],
            'm' : ['รผhe minuti', 'รผks minut'],
            'mm': [number + ' minuti', number + ' minutit'],
            'h' : ['รผhe tunni', 'tund aega', 'รผks tund'],
            'hh': [number + ' tunni', number + ' tundi'],
            'd' : ['รผhe pรคeva', 'รผks pรคev'],
            'M' : ['kuu aja', 'kuu aega', 'รผks kuu'],
            'MM': [number + ' kuu', number + ' kuud'],
            'y' : ['รผhe aasta', 'aasta', 'รผks aasta'],
            'yy': [number + ' aasta', number + ' aastat']
        };
        if (withoutSuffix) {
            return format[key][2] ? format[key][2] : format[key][1];
        }
        return isFuture ? format[key][0] : format[key][1];
    }

    return moment.defineLocale('et', {
        months        : 'jaanuar_veebruar_mรคrts_aprill_mai_juuni_juuli_august_september_oktoober_november_detsember'.split('_'),
        monthsShort   : 'jaan_veebr_mรคrts_apr_mai_juuni_juuli_aug_sept_okt_nov_dets'.split('_'),
        weekdays      : 'pรผhapรคev_esmaspรคev_teisipรคev_kolmapรคev_neljapรคev_reede_laupรคev'.split('_'),
        weekdaysShort : 'P_E_T_K_N_R_L'.split('_'),
        weekdaysMin   : 'P_E_T_K_N_R_L'.split('_'),
        longDateFormat : {
            LT   : 'H:mm',
            LTS : 'LT:ss',
            L    : 'DD.MM.YYYY',
            LL   : 'D. MMMM YYYY',
            LLL  : 'D. MMMM YYYY LT',
            LLLL : 'dddd, D. MMMM YYYY LT'
        },
        calendar : {
            sameDay  : '[Tรคna,] LT',
            nextDay  : '[Homme,] LT',
            nextWeek : '[Jรคrgmine] dddd LT',
            lastDay  : '[Eile,] LT',
            lastWeek : '[Eelmine] dddd LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s pรคrast',
            past   : '%s tagasi',
            s      : processRelativeTime,
            m      : processRelativeTime,
            mm     : processRelativeTime,
            h      : processRelativeTime,
            hh     : processRelativeTime,
            d      : processRelativeTime,
            dd     : '%d pรคeva',
            M      : processRelativeTime,
            MM     : processRelativeTime,
            y      : processRelativeTime,
            yy     : processRelativeTime
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : euskara (eu)
// author : Eneko Illarramendi : https://github.com/eillarra

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('eu', {
        months : 'urtarrila_otsaila_martxoa_apirila_maiatza_ekaina_uztaila_abuztua_iraila_urria_azaroa_abendua'.split('_'),
        monthsShort : 'urt._ots._mar._api._mai._eka._uzt._abu._ira._urr._aza._abe.'.split('_'),
        weekdays : 'igandea_astelehena_asteartea_asteazkena_osteguna_ostirala_larunbata'.split('_'),
        weekdaysShort : 'ig._al._ar._az._og._ol._lr.'.split('_'),
        weekdaysMin : 'ig_al_ar_az_og_ol_lr'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'YYYY-MM-DD',
            LL : 'YYYY[ko] MMMM[ren] D[a]',
            LLL : 'YYYY[ko] MMMM[ren] D[a] LT',
            LLLL : 'dddd, YYYY[ko] MMMM[ren] D[a] LT',
            l : 'YYYY-M-D',
            ll : 'YYYY[ko] MMM D[a]',
            lll : 'YYYY[ko] MMM D[a] LT',
            llll : 'ddd, YYYY[ko] MMM D[a] LT'
        },
        calendar : {
            sameDay : '[gaur] LT[etan]',
            nextDay : '[bihar] LT[etan]',
            nextWeek : 'dddd LT[etan]',
            lastDay : '[atzo] LT[etan]',
            lastWeek : '[aurreko] dddd LT[etan]',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s barru',
            past : 'duela %s',
            s : 'segundo batzuk',
            m : 'minutu bat',
            mm : '%d minutu',
            h : 'ordu bat',
            hh : '%d ordu',
            d : 'egun bat',
            dd : '%d egun',
            M : 'hilabete bat',
            MM : '%d hilabete',
            y : 'urte bat',
            yy : '%d urte'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Persian (fa)
// author : Ebrahim Byagowi : https://github.com/ebraminio

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': '�ฑ',
        '2': '�ฒ',
        '3': '�ณ',
        '4': '�ด',
        '5': '�ต',
        '6': '�ถ',
        '7': '�ท',
        '8': '�ธ',
        '9': '�น',
        '0': '�ฐ'
    }, numberMap = {
        '�ฑ': '1',
        '�ฒ': '2',
        '�ณ': '3',
        '�ด': '4',
        '�ต': '5',
        '�ถ': '6',
        '�ท': '7',
        '�ธ': '8',
        '�น': '9',
        '�ฐ': '0'
    };

    return moment.defineLocale('fa', {
        months : 'ฺุงูู�ู_ููุฑ�ู_ู…ุงุฑุณ_ุขูุฑ�ู_ู…ู_ฺูุฆู_ฺูุฆ�ู_ุงูุช_ุณูพุชุงู…ุจุฑ_ุงฺฉุชุจุฑ_ููุงู…ุจุฑ_ุฏุณุงู…ุจุฑ'.split('_'),
        monthsShort : 'ฺุงูู�ู_ููุฑ�ู_ู…ุงุฑุณ_ุขูุฑ�ู_ู…ู_ฺูุฆู_ฺูุฆ�ู_ุงูุช_ุณูพุชุงู…ุจุฑ_ุงฺฉุชุจุฑ_ููุงู…ุจุฑ_ุฏุณุงู…ุจุฑ'.split('_'),
        weekdays : '�ฺฉ\u200cุดูุจู_ุฏูุดูุจู_ุณู\u200cุดูุจู_ฺูุงุฑุดูุจู_ูพูุฌ\u200cุดูุจู_ุฌู…ุนู_ุดูุจู'.split('_'),
        weekdaysShort : '�ฺฉ\u200cุดูุจู_ุฏูุดูุจู_ุณู\u200cุดูุจู_ฺูุงุฑุดูุจู_ูพูุฌ\u200cุดูุจู_ุฌู…ุนู_ุดูุจู'.split('_'),
        weekdaysMin : '�_ุฏ_ุณ_ฺ_ูพ_ุฌ_ุด'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        meridiemParse: /ูุจู ุงุฒ ุธูุฑ|ุจุนุฏ ุงุฒ ุธูุฑ/,
        isPM: function (input) {
            return /ุจุนุฏ ุงุฒ ุธูุฑ/.test(input);
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 12) {
                return 'ูุจู ุงุฒ ุธูุฑ';
            } else {
                return 'ุจุนุฏ ุงุฒ ุธูุฑ';
            }
        },
        calendar : {
            sameDay : '[ุงู…ุฑูุฒ ุณุงุนุช] LT',
            nextDay : '[ูุฑุฏุง ุณุงุนุช] LT',
            nextWeek : 'dddd [ุณุงุนุช] LT',
            lastDay : '[ุฏ�ุฑูุฒ ุณุงุนุช] LT',
            lastWeek : 'dddd [ูพ�ุด] [ุณุงุนุช] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ุฏุฑ %s',
            past : '%s ูพ�ุด',
            s : 'ฺูุฏ�ู ุซุงู�ู',
            m : '�ฺฉ ุฏู�ูู',
            mm : '%d ุฏู�ูู',
            h : '�ฺฉ ุณุงุนุช',
            hh : '%d ุณุงุนุช',
            d : '�ฺฉ ุฑูุฒ',
            dd : '%d ุฑูุฒ',
            M : '�ฺฉ ู…ุงู',
            MM : '%d ู…ุงู',
            y : '�ฺฉ ุณุงู',
            yy : '%d ุณุงู'
        },
        preparse: function (string) {
            return string.replace(/[�ฐ-�น]/g, function (match) {
                return numberMap[match];
            }).replace(/ุ/g, ',');
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            }).replace(/,/g, 'ุ');
        },
        ordinalParse: /\d{1,2}ู…/,
        ordinal : '%dู…',
        week : {
            dow : 6, // Saturday is the first day of the week.
            doy : 12 // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : finnish (fi)
// author : Tarmo Aidantausta : https://github.com/bleadof

(function (factory) {
    factory(moment);
}(function (moment) {
    var numbersPast = 'nolla yksi kaksi kolme neljรค viisi kuusi seitsemรคn kahdeksan yhdeksรคn'.split(' '),
        numbersFuture = [
            'nolla', 'yhden', 'kahden', 'kolmen', 'neljรคn', 'viiden', 'kuuden',
            numbersPast[7], numbersPast[8], numbersPast[9]
        ];

    function translate(number, withoutSuffix, key, isFuture) {
        var result = '';
        switch (key) {
        case 's':
            return isFuture ? 'muutaman sekunnin' : 'muutama sekunti';
        case 'm':
            return isFuture ? 'minuutin' : 'minuutti';
        case 'mm':
            result = isFuture ? 'minuutin' : 'minuuttia';
            break;
        case 'h':
            return isFuture ? 'tunnin' : 'tunti';
        case 'hh':
            result = isFuture ? 'tunnin' : 'tuntia';
            break;
        case 'd':
            return isFuture ? 'pรคivรคn' : 'pรคivรค';
        case 'dd':
            result = isFuture ? 'pรคivรคn' : 'pรคivรครค';
            break;
        case 'M':
            return isFuture ? 'kuukauden' : 'kuukausi';
        case 'MM':
            result = isFuture ? 'kuukauden' : 'kuukautta';
            break;
        case 'y':
            return isFuture ? 'vuoden' : 'vuosi';
        case 'yy':
            result = isFuture ? 'vuoden' : 'vuotta';
            break;
        }
        result = verbalNumber(number, isFuture) + ' ' + result;
        return result;
    }

    function verbalNumber(number, isFuture) {
        return number < 10 ? (isFuture ? numbersFuture[number] : numbersPast[number]) : number;
    }

    return moment.defineLocale('fi', {
        months : 'tammikuu_helmikuu_maaliskuu_huhtikuu_toukokuu_kesรคkuu_heinรคkuu_elokuu_syyskuu_lokakuu_marraskuu_joulukuu'.split('_'),
        monthsShort : 'tammi_helmi_maalis_huhti_touko_kesรค_heinรค_elo_syys_loka_marras_joulu'.split('_'),
        weekdays : 'sunnuntai_maanantai_tiistai_keskiviikko_torstai_perjantai_lauantai'.split('_'),
        weekdaysShort : 'su_ma_ti_ke_to_pe_la'.split('_'),
        weekdaysMin : 'su_ma_ti_ke_to_pe_la'.split('_'),
        longDateFormat : {
            LT : 'HH.mm',
            LTS : 'HH.mm.ss',
            L : 'DD.MM.YYYY',
            LL : 'Do MMMM[ta] YYYY',
            LLL : 'Do MMMM[ta] YYYY, [klo] LT',
            LLLL : 'dddd, Do MMMM[ta] YYYY, [klo] LT',
            l : 'D.M.YYYY',
            ll : 'Do MMM YYYY',
            lll : 'Do MMM YYYY, [klo] LT',
            llll : 'ddd, Do MMM YYYY, [klo] LT'
        },
        calendar : {
            sameDay : '[tรคnรครคn] [klo] LT',
            nextDay : '[huomenna] [klo] LT',
            nextWeek : 'dddd [klo] LT',
            lastDay : '[eilen] [klo] LT',
            lastWeek : '[viime] dddd[na] [klo] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s pรครคstรค',
            past : '%s sitten',
            s : translate,
            m : translate,
            mm : translate,
            h : translate,
            hh : translate,
            d : translate,
            dd : translate,
            M : translate,
            MM : translate,
            y : translate,
            yy : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : faroese (fo)
// author : Ragnar Johannesen : https://github.com/ragnar123

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('fo', {
        months : 'januar_februar_mars_aprรญl_mai_juni_juli_august_september_oktober_november_desember'.split('_'),
        monthsShort : 'jan_feb_mar_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_'),
        weekdays : 'sunnudagur_mรกnadagur_tรฝsdagur_mikudagur_hรณsdagur_frรญggjadagur_leygardagur'.split('_'),
        weekdaysShort : 'sun_mรกn_tรฝs_mik_hรณs_frรญ_ley'.split('_'),
        weekdaysMin : 'su_mรก_tรฝ_mi_hรณ_fr_le'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D. MMMM, YYYY LT'
        },
        calendar : {
            sameDay : '[ร dag kl.] LT',
            nextDay : '[ร morgin kl.] LT',
            nextWeek : 'dddd [kl.] LT',
            lastDay : '[ร gjรกr kl.] LT',
            lastWeek : '[sรญรฐstu] dddd [kl] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'um %s',
            past : '%s sรญรฐani',
            s : 'fรก sekund',
            m : 'ein minutt',
            mm : '%d minuttir',
            h : 'ein tรญmi',
            hh : '%d tรญmar',
            d : 'ein dagur',
            dd : '%d dagar',
            M : 'ein mรกnaรฐi',
            MM : '%d mรกnaรฐir',
            y : 'eitt รกr',
            yy : '%d รกr'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : canadian french (fr-ca)
// author : Jonathan Abourbih : https://github.com/jonbca

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('fr-ca', {
        months : 'janvier_fรฉvrier_mars_avril_mai_juin_juillet_aoรปt_septembre_octobre_novembre_dรฉcembre'.split('_'),
        monthsShort : 'janv._fรฉvr._mars_avr._mai_juin_juil._aoรปt_sept._oct._nov._dรฉc.'.split('_'),
        weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
        weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
        weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'YYYY-MM-DD',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Aujourd\'hui ร ] LT',
            nextDay: '[Demain ร ] LT',
            nextWeek: 'dddd [ร ] LT',
            lastDay: '[Hier ร ] LT',
            lastWeek: 'dddd [dernier ร ] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'dans %s',
            past : 'il y a %s',
            s : 'quelques secondes',
            m : 'une minute',
            mm : '%d minutes',
            h : 'une heure',
            hh : '%d heures',
            d : 'un jour',
            dd : '%d jours',
            M : 'un mois',
            MM : '%d mois',
            y : 'un an',
            yy : '%d ans'
        },
        ordinalParse: /\d{1,2}(er|)/,
        ordinal : function (number) {
            return number + (number === 1 ? 'er' : '');
        }
    });
}));
// moment.js locale configuration
// locale : french (fr)
// author : John Fischer : https://github.com/jfroffice

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('fr', {
        months : 'janvier_fรฉvrier_mars_avril_mai_juin_juillet_aoรปt_septembre_octobre_novembre_dรฉcembre'.split('_'),
        monthsShort : 'janv._fรฉvr._mars_avr._mai_juin_juil._aoรปt_sept._oct._nov._dรฉc.'.split('_'),
        weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
        weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
        weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Aujourd\'hui ร ] LT',
            nextDay: '[Demain ร ] LT',
            nextWeek: 'dddd [ร ] LT',
            lastDay: '[Hier ร ] LT',
            lastWeek: 'dddd [dernier ร ] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'dans %s',
            past : 'il y a %s',
            s : 'quelques secondes',
            m : 'une minute',
            mm : '%d minutes',
            h : 'une heure',
            hh : '%d heures',
            d : 'un jour',
            dd : '%d jours',
            M : 'un mois',
            MM : '%d mois',
            y : 'un an',
            yy : '%d ans'
        },
        ordinalParse: /\d{1,2}(er|)/,
        ordinal : function (number) {
            return number + (number === 1 ? 'er' : '');
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : frisian (fy)
// author : Robin van der Vliet : https://github.com/robin0van0der0v

(function (factory) {
    factory(moment);
}(function (moment) {
    var monthsShortWithDots = 'jan._feb._mrt._apr._mai_jun._jul._aug._sep._okt._nov._des.'.split('_'),
        monthsShortWithoutDots = 'jan_feb_mrt_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_');

    return moment.defineLocale('fy', {
        months : 'jannewaris_febrewaris_maart_april_maaie_juny_july_augustus_septimber_oktober_novimber_desimber'.split('_'),
        monthsShort : function (m, format) {
            if (/-MMM-/.test(format)) {
                return monthsShortWithoutDots[m.month()];
            } else {
                return monthsShortWithDots[m.month()];
            }
        },
        weekdays : 'snein_moandei_tiisdei_woansdei_tongersdei_freed_sneon'.split('_'),
        weekdaysShort : 'si._mo._ti._wo._to._fr._so.'.split('_'),
        weekdaysMin : 'Si_Mo_Ti_Wo_To_Fr_So'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD-MM-YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[hjoed om] LT',
            nextDay: '[moarn om] LT',
            nextWeek: 'dddd [om] LT',
            lastDay: '[juster om] LT',
            lastWeek: '[รดfrรปne] dddd [om] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'oer %s',
            past : '%s lyn',
            s : 'in pear sekonden',
            m : 'ien minรบt',
            mm : '%d minuten',
            h : 'ien oere',
            hh : '%d oeren',
            d : 'ien dei',
            dd : '%d dagen',
            M : 'ien moanne',
            MM : '%d moannen',
            y : 'ien jier',
            yy : '%d jierren'
        },
        ordinalParse: /\d{1,2}(ste|de)/,
        ordinal : function (number) {
            return number + ((number === 1 || number === 8 || number >= 20) ? 'ste' : 'de');
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : galician (gl)
// author : Juan G. Hurtado : https://github.com/juanghurtado

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('gl', {
        months : 'Xaneiro_Febreiro_Marzo_Abril_Maio_Xuรฑo_Xullo_Agosto_Setembro_Outubro_Novembro_Decembro'.split('_'),
        monthsShort : 'Xan._Feb._Mar._Abr._Mai._Xuรฑ._Xul._Ago._Set._Out._Nov._Dec.'.split('_'),
        weekdays : 'Domingo_Luns_Martes_Mรฉrcores_Xoves_Venres_Sรกbado'.split('_'),
        weekdaysShort : 'Dom._Lun._Mar._Mรฉr._Xov._Ven._Sรกb.'.split('_'),
        weekdaysMin : 'Do_Lu_Ma_Mรฉ_Xo_Ve_Sรก'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay : function () {
                return '[hoxe ' + ((this.hours() !== 1) ? 'รกs' : 'รก') + '] LT';
            },
            nextDay : function () {
                return '[maรฑรก ' + ((this.hours() !== 1) ? 'รกs' : 'รก') + '] LT';
            },
            nextWeek : function () {
                return 'dddd [' + ((this.hours() !== 1) ? 'รกs' : 'a') + '] LT';
            },
            lastDay : function () {
                return '[onte ' + ((this.hours() !== 1) ? 'รก' : 'a') + '] LT';
            },
            lastWeek : function () {
                return '[o] dddd [pasado ' + ((this.hours() !== 1) ? 'รกs' : 'a') + '] LT';
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : function (str) {
                if (str === 'uns segundos') {
                    return 'nuns segundos';
                }
                return 'en ' + str;
            },
            past : 'hai %s',
            s : 'uns segundos',
            m : 'un minuto',
            mm : '%d minutos',
            h : 'unha hora',
            hh : '%d horas',
            d : 'un dรญa',
            dd : '%d dรญas',
            M : 'un mes',
            MM : '%d meses',
            y : 'un ano',
            yy : '%d anos'
        },
        ordinalParse : /\d{1,2}ยบ/,
        ordinal : '%dยบ',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Hebrew (he)
// author : Tomer Cohen : https://github.com/tomer
// author : Moshe Simantov : https://github.com/DevelopmentIL
// author : Tal Ater : https://github.com/TalAter

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('he', {
        months : 'ืื ื•ืืจ_ืคื‘ืจื•ืืจ_ืืจืฅ_ืืคืจืื_ืืื_ืื•ื ื_ืื•ืื_ืื•ื’ื•ืกื_ืกืคืืื‘ืจ_ืื•ืงืื•ื‘ืจ_ื ื•ื‘ืื‘ืจ_ื“ืฆืื‘ืจ'.split('_'),
        monthsShort : 'ืื ื•ืณ_ืคื‘ืจืณ_ืืจืฅ_ืืคืจืณ_ืืื_ืื•ื ื_ืื•ืื_ืื•ื’ืณ_ืกืคืืณ_ืื•ืงืณ_ื ื•ื‘ืณ_ื“ืฆืืณ'.split('_'),
        weekdays : 'ืจืืฉื•ื_ืฉื ื_ืฉืืืฉื_ืจื‘ืืขื_ื—ืืืฉื_ืฉืืฉื_ืฉื‘ืช'.split('_'),
        weekdaysShort : 'ืืณ_ื‘ืณ_ื’ืณ_ื“ืณ_ื”ืณ_ื•ืณ_ืฉืณ'.split('_'),
        weekdaysMin : 'ื_ื‘_ื’_ื“_ื”_ื•_ืฉ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D [ื‘]MMMM YYYY',
            LLL : 'D [ื‘]MMMM YYYY LT',
            LLLL : 'dddd, D [ื‘]MMMM YYYY LT',
            l : 'D/M/YYYY',
            ll : 'D MMM YYYY',
            lll : 'D MMM YYYY LT',
            llll : 'ddd, D MMM YYYY LT'
        },
        calendar : {
            sameDay : '[ื”ืื•ื ื‘ึพ]LT',
            nextDay : '[ืื—ืจ ื‘ึพ]LT',
            nextWeek : 'dddd [ื‘ืฉืขื”] LT',
            lastDay : '[ืืชืื•ื ื‘ึพ]LT',
            lastWeek : '[ื‘ืื•ื] dddd [ื”ืื—ืจื•ื ื‘ืฉืขื”] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ื‘ืขื•ื“ %s',
            past : 'ืืคื ื %s',
            s : 'ืืกืคืจ ืฉื ืื•ืช',
            m : 'ื“ืงื”',
            mm : '%d ื“ืงื•ืช',
            h : 'ืฉืขื”',
            hh : function (number) {
                if (number === 2) {
                    return 'ืฉืขืชืืื';
                }
                return number + ' ืฉืขื•ืช';
            },
            d : 'ืื•ื',
            dd : function (number) {
                if (number === 2) {
                    return 'ืื•ืืืื';
                }
                return number + ' ืืืื';
            },
            M : 'ื—ื•ื“ืฉ',
            MM : function (number) {
                if (number === 2) {
                    return 'ื—ื•ื“ืฉืืื';
                }
                return number + ' ื—ื•ื“ืฉืื';
            },
            y : 'ืฉื ื”',
            yy : function (number) {
                if (number === 2) {
                    return 'ืฉื ืชืืื';
                } else if (number % 10 === 0 && number !== 10) {
                    return number + ' ืฉื ื”';
                }
                return number + ' ืฉื ืื';
            }
        }
    });
}));
// moment.js locale configuration
// locale : hindi (hi)
// author : Mayank Singhal : https://github.com/mayanksinghal

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'เฅง',
        '2': 'เฅจ',
        '3': 'เฅฉ',
        '4': 'เฅช',
        '5': 'เฅซ',
        '6': 'เฅฌ',
        '7': 'เฅญ',
        '8': 'เฅฎ',
        '9': 'เฅฏ',
        '0': 'เฅฆ'
    },
    numberMap = {
        'เฅง': '1',
        'เฅจ': '2',
        'เฅฉ': '3',
        'เฅช': '4',
        'เฅซ': '5',
        'เฅฌ': '6',
        'เฅญ': '7',
        'เฅฎ': '8',
        'เฅฏ': '9',
        'เฅฆ': '0'
    };

    return moment.defineLocale('hi', {
        months : 'เคเคจเคตเคฐเฅ€_เคซเคผเคฐเคตเคฐเฅ€_เคฎเคพเคฐเฅเค_เค…เคชเฅเคฐเฅเคฒ_เคฎเค_เคเฅเคจ_เคเฅเคฒเคพเค_เค…เค—เคธเฅเคค_เคธเคฟเคคเคฎเฅเคฌเคฐ_เค…เค•เฅเคเฅเคฌเคฐ_เคจเคตเคฎเฅเคฌเคฐ_เคฆเคฟเคธเคฎเฅเคฌเคฐ'.split('_'),
        monthsShort : 'เคเคจ._เคซเคผเคฐ._เคฎเคพเคฐเฅเค_เค…เคชเฅเคฐเฅ._เคฎเค_เคเฅเคจ_เคเฅเคฒ._เค…เค—._เคธเคฟเคค._เค…เค•เฅเคเฅ._เคจเคต._เคฆเคฟเคธ.'.split('_'),
        weekdays : 'เคฐเคตเคฟเคตเคพเคฐ_เคธเฅเคฎเคตเคพเคฐ_เคฎเคเค—เคฒเคตเคพเคฐ_เคฌเฅเคงเคตเคพเคฐ_เค—เฅเคฐเฅเคตเคพเคฐ_เคถเฅเค•เฅเคฐเคตเคพเคฐ_เคถเคจเคฟเคตเคพเคฐ'.split('_'),
        weekdaysShort : 'เคฐเคตเคฟ_เคธเฅเคฎ_เคฎเคเค—เคฒ_เคฌเฅเคง_เค—เฅเคฐเฅ_เคถเฅเค•เฅเคฐ_เคถเคจเคฟ'.split('_'),
        weekdaysMin : 'เคฐ_เคธเฅ_เคฎเค_เคฌเฅ_เค—เฅ_เคถเฅ_เคถ'.split('_'),
        longDateFormat : {
            LT : 'A h:mm เคฌเคเฅ',
            LTS : 'A h:mm:ss เคฌเคเฅ',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        calendar : {
            sameDay : '[เคเค] LT',
            nextDay : '[เค•เคฒ] LT',
            nextWeek : 'dddd, LT',
            lastDay : '[เค•เคฒ] LT',
            lastWeek : '[เคชเคฟเคเคฒเฅ] dddd, LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s เคฎเฅเค',
            past : '%s เคชเคนเคฒเฅ',
            s : 'เค•เฅเค เคนเฅ€ เค•เฅเคทเคฃ',
            m : 'เคเค• เคฎเคฟเคจเค',
            mm : '%d เคฎเคฟเคจเค',
            h : 'เคเค• เคเคเคเคพ',
            hh : '%d เคเคเคเฅ',
            d : 'เคเค• เคฆเคฟเคจ',
            dd : '%d เคฆเคฟเคจ',
            M : 'เคเค• เคฎเคนเฅ€เคจเฅ',
            MM : '%d เคฎเคนเฅ€เคจเฅ',
            y : 'เคเค• เคตเคฐเฅเคท',
            yy : '%d เคตเคฐเฅเคท'
        },
        preparse: function (string) {
            return string.replace(/[เฅงเฅจเฅฉเฅชเฅซเฅฌเฅญเฅฎเฅฏเฅฆ]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },
        // Hindi notation for meridiems are quite fuzzy in practice. While there exists
        // a rigid notion of a 'Pahar' it is not used as rigidly in modern Hindi.
        meridiemParse: /เคฐเคพเคค|เคธเฅเคฌเคน|เคฆเฅเคชเคนเคฐ|เคถเคพเคฎ/,
        meridiemHour : function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'เคฐเคพเคค') {
                return hour < 4 ? hour : hour + 12;
            } else if (meridiem === 'เคธเฅเคฌเคน') {
                return hour;
            } else if (meridiem === 'เคฆเฅเคชเคนเคฐ') {
                return hour >= 10 ? hour : hour + 12;
            } else if (meridiem === 'เคถเคพเคฎ') {
                return hour + 12;
            }
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'เคฐเคพเคค';
            } else if (hour < 10) {
                return 'เคธเฅเคฌเคน';
            } else if (hour < 17) {
                return 'เคฆเฅเคชเคนเคฐ';
            } else if (hour < 20) {
                return 'เคถเคพเคฎ';
            } else {
                return 'เคฐเคพเคค';
            }
        },
        week : {
            dow : 0, // Sunday is the first day of the week.
            doy : 6  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : hrvatski (hr)
// author : Bojan Markoviฤ : https://github.com/bmarkovic

// based on (sl) translation by Robert Sedovลกek

(function (factory) {
    factory(moment);
}(function (moment) {
    function translate(number, withoutSuffix, key) {
        var result = number + ' ';
        switch (key) {
        case 'm':
            return withoutSuffix ? 'jedna minuta' : 'jedne minute';
        case 'mm':
            if (number === 1) {
                result += 'minuta';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'minute';
            } else {
                result += 'minuta';
            }
            return result;
        case 'h':
            return withoutSuffix ? 'jedan sat' : 'jednog sata';
        case 'hh':
            if (number === 1) {
                result += 'sat';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'sata';
            } else {
                result += 'sati';
            }
            return result;
        case 'dd':
            if (number === 1) {
                result += 'dan';
            } else {
                result += 'dana';
            }
            return result;
        case 'MM':
            if (number === 1) {
                result += 'mjesec';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'mjeseca';
            } else {
                result += 'mjeseci';
            }
            return result;
        case 'yy':
            if (number === 1) {
                result += 'godina';
            } else if (number === 2 || number === 3 || number === 4) {
                result += 'godine';
            } else {
                result += 'godina';
            }
            return result;
        }
    }

    return moment.defineLocale('hr', {
        months : 'sjeฤanj_veljaฤa_oลพujak_travanj_svibanj_lipanj_srpanj_kolovoz_rujan_listopad_studeni_prosinac'.split('_'),
        monthsShort : 'sje._vel._oลพu._tra._svi._lip._srp._kol._ruj._lis._stu._pro.'.split('_'),
        weekdays : 'nedjelja_ponedjeljak_utorak_srijeda_ฤetvrtak_petak_subota'.split('_'),
        weekdaysShort : 'ned._pon._uto._sri._ฤet._pet._sub.'.split('_'),
        weekdaysMin : 'ne_po_ut_sr_ฤe_pe_su'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD. MM. YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd, D. MMMM YYYY LT'
        },
        calendar : {
            sameDay  : '[danas u] LT',
            nextDay  : '[sutra u] LT',

            nextWeek : function () {
                switch (this.day()) {
                case 0:
                    return '[u] [nedjelju] [u] LT';
                case 3:
                    return '[u] [srijedu] [u] LT';
                case 6:
                    return '[u] [subotu] [u] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[u] dddd [u] LT';
                }
            },
            lastDay  : '[juฤer u] LT',
            lastWeek : function () {
                switch (this.day()) {
                case 0:
                case 3:
                    return '[proลกlu] dddd [u] LT';
                case 6:
                    return '[proลกle] [subote] [u] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[proลกli] dddd [u] LT';
                }
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'za %s',
            past   : 'prije %s',
            s      : 'par sekundi',
            m      : translate,
            mm     : translate,
            h      : translate,
            hh     : translate,
            d      : 'dan',
            dd     : translate,
            M      : 'mjesec',
            MM     : translate,
            y      : 'godinu',
            yy     : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : hungarian (hu)
// author : Adam Brunner : https://github.com/adambrunner

(function (factory) {
    factory(moment);
}(function (moment) {
    var weekEndings = 'vasรกrnap hรฉtfล‘n kedden szerdรกn csรผtรถrtรถkรถn pรฉnteken szombaton'.split(' ');

    function translate(number, withoutSuffix, key, isFuture) {
        var num = number,
            suffix;

        switch (key) {
        case 's':
            return (isFuture || withoutSuffix) ? 'nรฉhรกny mรกsodperc' : 'nรฉhรกny mรกsodperce';
        case 'm':
            return 'egy' + (isFuture || withoutSuffix ? ' perc' : ' perce');
        case 'mm':
            return num + (isFuture || withoutSuffix ? ' perc' : ' perce');
        case 'h':
            return 'egy' + (isFuture || withoutSuffix ? ' รณra' : ' รณrรกja');
        case 'hh':
            return num + (isFuture || withoutSuffix ? ' รณra' : ' รณrรกja');
        case 'd':
            return 'egy' + (isFuture || withoutSuffix ? ' nap' : ' napja');
        case 'dd':
            return num + (isFuture || withoutSuffix ? ' nap' : ' napja');
        case 'M':
            return 'egy' + (isFuture || withoutSuffix ? ' hรณnap' : ' hรณnapja');
        case 'MM':
            return num + (isFuture || withoutSuffix ? ' hรณnap' : ' hรณnapja');
        case 'y':
            return 'egy' + (isFuture || withoutSuffix ? ' รฉv' : ' รฉve');
        case 'yy':
            return num + (isFuture || withoutSuffix ? ' รฉv' : ' รฉve');
        }

        return '';
    }

    function week(isFuture) {
        return (isFuture ? '' : '[mรบlt] ') + '[' + weekEndings[this.day()] + '] LT[-kor]';
    }

    return moment.defineLocale('hu', {
        months : 'januรกr_februรกr_mรกrcius_รกprilis_mรกjus_jรบnius_jรบlius_augusztus_szeptember_oktรณber_november_december'.split('_'),
        monthsShort : 'jan_feb_mรกrc_รกpr_mรกj_jรบn_jรบl_aug_szept_okt_nov_dec'.split('_'),
        weekdays : 'vasรกrnap_hรฉtfล‘_kedd_szerda_csรผtรถrtรถk_pรฉntek_szombat'.split('_'),
        weekdaysShort : 'vas_hรฉt_kedd_sze_csรผt_pรฉn_szo'.split('_'),
        weekdaysMin : 'v_h_k_sze_cs_p_szo'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'YYYY.MM.DD.',
            LL : 'YYYY. MMMM D.',
            LLL : 'YYYY. MMMM D., LT',
            LLLL : 'YYYY. MMMM D., dddd LT'
        },
        meridiemParse: /de|du/i,
        isPM: function (input) {
            return input.charAt(1).toLowerCase() === 'u';
        },
        meridiem : function (hours, minutes, isLower) {
            if (hours < 12) {
                return isLower === true ? 'de' : 'DE';
            } else {
                return isLower === true ? 'du' : 'DU';
            }
        },
        calendar : {
            sameDay : '[ma] LT[-kor]',
            nextDay : '[holnap] LT[-kor]',
            nextWeek : function () {
                return week.call(this, true);
            },
            lastDay : '[tegnap] LT[-kor]',
            lastWeek : function () {
                return week.call(this, false);
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s mรบlva',
            past : '%s',
            s : translate,
            m : translate,
            mm : translate,
            h : translate,
            hh : translate,
            d : translate,
            dd : translate,
            M : translate,
            MM : translate,
            y : translate,
            yy : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Armenian (hy-am)
// author : Armendarabyan : https://github.com/armendarabyan

(function (factory) {
    factory(moment);
}(function (moment) {
    function monthsCaseReplace(m, format) {
        var months = {
            'nominative': 'ีฐีธึีถีพีกึ€_ึีฅีฟึ€ีพีกึ€_ีดีกึ€ีฟ_ีกีบึ€ีซีฌ_ีดีกีตีซีฝ_ีฐีธึีถีซีฝ_ีฐีธึีฌีซีฝ_ึ…ีฃีธีฝีฟีธีฝ_ีฝีฅีบีฟีฅีดีขีฅึ€_ีฐีธีฏีฟีฅีดีขีฅึ€_ีถีธีตีฅีดีขีฅึ€_ีคีฅีฏีฟีฅีดีขีฅึ€'.split('_'),
            'accusative': 'ีฐีธึีถีพีกึ€ีซ_ึีฅีฟึ€ีพีกึ€ีซ_ีดีกึ€ีฟีซ_ีกีบึ€ีซีฌีซ_ีดีกีตีซีฝีซ_ีฐีธึีถีซีฝีซ_ีฐีธึีฌีซีฝีซ_ึ…ีฃีธีฝีฟีธีฝีซ_ีฝีฅีบีฟีฅีดีขีฅึ€ีซ_ีฐีธีฏีฟีฅีดีขีฅึ€ีซ_ีถีธีตีฅีดีขีฅึ€ีซ_ีคีฅีฏีฟีฅีดีขีฅึ€ีซ'.split('_')
        },

        nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return months[nounCase][m.month()];
    }

    function monthsShortCaseReplace(m, format) {
        var monthsShort = 'ีฐีถีพ_ึีฟึ€_ีดึ€ีฟ_ีกีบึ€_ีดีตีฝ_ีฐีถีฝ_ีฐีฌีฝ_ึ…ีฃีฝ_ีฝีบีฟ_ีฐีฏีฟ_ีถีดีข_ีคีฏีฟ'.split('_');

        return monthsShort[m.month()];
    }

    function weekdaysCaseReplace(m, format) {
        var weekdays = 'ีฏีซึ€ีกีฏีซ_ีฅึ€ีฏีธึีทีกีขีฉีซ_ีฅึ€ีฅึีทีกีขีฉีซ_ีนีธึ€ีฅึีทีกีขีฉีซ_ีฐีซีถีฃีทีกีขีฉีซ_ีธึึ€ีขีกีฉ_ีทีกีขีกีฉ'.split('_');

        return weekdays[m.day()];
    }

    return moment.defineLocale('hy-am', {
        months : monthsCaseReplace,
        monthsShort : monthsShortCaseReplace,
        weekdays : weekdaysCaseReplace,
        weekdaysShort : 'ีฏึ€ีฏ_ีฅึ€ีฏ_ีฅึ€ึ_ีนึ€ึ_ีฐีถีฃ_ีธึึ€ีข_ีทีขีฉ'.split('_'),
        weekdaysMin : 'ีฏึ€ีฏ_ีฅึ€ีฏ_ีฅึ€ึ_ีนึ€ึ_ีฐีถีฃ_ีธึึ€ีข_ีทีขีฉ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY ีฉ.',
            LLL : 'D MMMM YYYY ีฉ., LT',
            LLLL : 'dddd, D MMMM YYYY ีฉ., LT'
        },
        calendar : {
            sameDay: '[ีกีตีฝึ…ึ€] LT',
            nextDay: '[ีพีกีฒีจ] LT',
            lastDay: '[ีฅึ€ีฅีฏ] LT',
            nextWeek: function () {
                return 'dddd [ึ…ึ€ีจ ีชีกีดีจ] LT';
            },
            lastWeek: function () {
                return '[ีกีถึีกีฎ] dddd [ึ…ึ€ีจ ีชีกีดีจ] LT';
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : '%s ีฐีฅีฟีธ',
            past : '%s ีกีผีกีป',
            s : 'ีดีซ ึีกีถีซ ีพีกีตึ€ีฏีตีกีถ',
            m : 'ึ€ีธีบีฅ',
            mm : '%d ึ€ีธีบีฅ',
            h : 'ีชีกีด',
            hh : '%d ีชีกีด',
            d : 'ึ…ึ€',
            dd : '%d ึ…ึ€',
            M : 'ีกีดีซีฝ',
            MM : '%d ีกีดีซีฝ',
            y : 'ีฟีกึ€ีซ',
            yy : '%d ีฟีกึ€ีซ'
        },

        meridiemParse: /ีฃีซีทีฅึ€ีพีก|ีกีผีกีพีธีฟีพีก|ึีฅึ€ีฅีฏีพีก|ีฅึ€ีฅีฏีธีตีกีถ/,
        isPM: function (input) {
            return /^(ึีฅึ€ีฅีฏีพีก|ีฅึ€ีฅีฏีธีตีกีถ)$/.test(input);
        },
        meridiem : function (hour) {
            if (hour < 4) {
                return 'ีฃีซีทีฅึ€ีพีก';
            } else if (hour < 12) {
                return 'ีกีผีกีพีธีฟีพีก';
            } else if (hour < 17) {
                return 'ึีฅึ€ีฅีฏีพีก';
            } else {
                return 'ีฅึ€ีฅีฏีธีตีกีถ';
            }
        },

        ordinalParse: /\d{1,2}|\d{1,2}-(ีซีถ|ึ€ีค)/,
        ordinal: function (number, period) {
            switch (period) {
            case 'DDD':
            case 'w':
            case 'W':
            case 'DDDo':
                if (number === 1) {
                    return number + '-ีซีถ';
                }
                return number + '-ึ€ีค';
            default:
                return number;
            }
        },

        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Bahasa Indonesia (id)
// author : Mohammad Satrio Utomo : https://github.com/tyok
// reference: http://id.wikisource.org/wiki/Pedoman_Umum_Ejaan_Bahasa_Indonesia_yang_Disempurnakan

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('id', {
        months : 'Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember'.split('_'),
        monthsShort : 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Ags_Sep_Okt_Nov_Des'.split('_'),
        weekdays : 'Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu'.split('_'),
        weekdaysShort : 'Min_Sen_Sel_Rab_Kam_Jum_Sab'.split('_'),
        weekdaysMin : 'Mg_Sn_Sl_Rb_Km_Jm_Sb'.split('_'),
        longDateFormat : {
            LT : 'HH.mm',
            LTS : 'LT.ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY [pukul] LT',
            LLLL : 'dddd, D MMMM YYYY [pukul] LT'
        },
        meridiemParse: /pagi|siang|sore|malam/,
        meridiemHour : function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'pagi') {
                return hour;
            } else if (meridiem === 'siang') {
                return hour >= 11 ? hour : hour + 12;
            } else if (meridiem === 'sore' || meridiem === 'malam') {
                return hour + 12;
            }
        },
        meridiem : function (hours, minutes, isLower) {
            if (hours < 11) {
                return 'pagi';
            } else if (hours < 15) {
                return 'siang';
            } else if (hours < 19) {
                return 'sore';
            } else {
                return 'malam';
            }
        },
        calendar : {
            sameDay : '[Hari ini pukul] LT',
            nextDay : '[Besok pukul] LT',
            nextWeek : 'dddd [pukul] LT',
            lastDay : '[Kemarin pukul] LT',
            lastWeek : 'dddd [lalu pukul] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'dalam %s',
            past : '%s yang lalu',
            s : 'beberapa detik',
            m : 'semenit',
            mm : '%d menit',
            h : 'sejam',
            hh : '%d jam',
            d : 'sehari',
            dd : '%d hari',
            M : 'sebulan',
            MM : '%d bulan',
            y : 'setahun',
            yy : '%d tahun'
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : icelandic (is)
// author : Hinrik ร–rn Sigurรฐsson : https://github.com/hinrik

(function (factory) {
    factory(moment);
}(function (moment) {
    function plural(n) {
        if (n % 100 === 11) {
            return true;
        } else if (n % 10 === 1) {
            return false;
        }
        return true;
    }

    function translate(number, withoutSuffix, key, isFuture) {
        var result = number + ' ';
        switch (key) {
        case 's':
            return withoutSuffix || isFuture ? 'nokkrar sekรบndur' : 'nokkrum sekรบndum';
        case 'm':
            return withoutSuffix ? 'mรญnรบta' : 'mรญnรบtu';
        case 'mm':
            if (plural(number)) {
                return result + (withoutSuffix || isFuture ? 'mรญnรบtur' : 'mรญnรบtum');
            } else if (withoutSuffix) {
                return result + 'mรญnรบta';
            }
            return result + 'mรญnรบtu';
        case 'hh':
            if (plural(number)) {
                return result + (withoutSuffix || isFuture ? 'klukkustundir' : 'klukkustundum');
            }
            return result + 'klukkustund';
        case 'd':
            if (withoutSuffix) {
                return 'dagur';
            }
            return isFuture ? 'dag' : 'degi';
        case 'dd':
            if (plural(number)) {
                if (withoutSuffix) {
                    return result + 'dagar';
                }
                return result + (isFuture ? 'daga' : 'dรถgum');
            } else if (withoutSuffix) {
                return result + 'dagur';
            }
            return result + (isFuture ? 'dag' : 'degi');
        case 'M':
            if (withoutSuffix) {
                return 'mรกnuรฐur';
            }
            return isFuture ? 'mรกnuรฐ' : 'mรกnuรฐi';
        case 'MM':
            if (plural(number)) {
                if (withoutSuffix) {
                    return result + 'mรกnuรฐir';
                }
                return result + (isFuture ? 'mรกnuรฐi' : 'mรกnuรฐum');
            } else if (withoutSuffix) {
                return result + 'mรกnuรฐur';
            }
            return result + (isFuture ? 'mรกnuรฐ' : 'mรกnuรฐi');
        case 'y':
            return withoutSuffix || isFuture ? 'รกr' : 'รกri';
        case 'yy':
            if (plural(number)) {
                return result + (withoutSuffix || isFuture ? 'รกr' : 'รกrum');
            }
            return result + (withoutSuffix || isFuture ? 'รกr' : 'รกri');
        }
    }

    return moment.defineLocale('is', {
        months : 'janรบar_febrรบar_mars_aprรญl_maรญ_jรบnรญ_jรบlรญ_รกgรบst_september_oktรณber_nรณvember_desember'.split('_'),
        monthsShort : 'jan_feb_mar_apr_maรญ_jรบn_jรบl_รกgรบ_sep_okt_nรณv_des'.split('_'),
        weekdays : 'sunnudagur_mรกnudagur_รพriรฐjudagur_miรฐvikudagur_fimmtudagur_fรถstudagur_laugardagur'.split('_'),
        weekdaysShort : 'sun_mรกn_รพri_miรฐ_fim_fรถs_lau'.split('_'),
        weekdaysMin : 'Su_Mรก_รr_Mi_Fi_Fรถ_La'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY [kl.] LT',
            LLLL : 'dddd, D. MMMM YYYY [kl.] LT'
        },
        calendar : {
            sameDay : '[รญ dag kl.] LT',
            nextDay : '[รก morgun kl.] LT',
            nextWeek : 'dddd [kl.] LT',
            lastDay : '[รญ gรฆr kl.] LT',
            lastWeek : '[sรญรฐasta] dddd [kl.] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'eftir %s',
            past : 'fyrir %s sรญรฐan',
            s : translate,
            m : translate,
            mm : translate,
            h : 'klukkustund',
            hh : translate,
            d : translate,
            dd : translate,
            M : translate,
            MM : translate,
            y : translate,
            yy : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : italian (it)
// author : Lorenzo : https://github.com/aliem
// author: Mattia Larentis: https://github.com/nostalgiaz

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('it', {
        months : 'gennaio_febbraio_marzo_aprile_maggio_giugno_luglio_agosto_settembre_ottobre_novembre_dicembre'.split('_'),
        monthsShort : 'gen_feb_mar_apr_mag_giu_lug_ago_set_ott_nov_dic'.split('_'),
        weekdays : 'Domenica_Lunedรฌ_Martedรฌ_Mercoledรฌ_Giovedรฌ_Venerdรฌ_Sabato'.split('_'),
        weekdaysShort : 'Dom_Lun_Mar_Mer_Gio_Ven_Sab'.split('_'),
        weekdaysMin : 'D_L_Ma_Me_G_V_S'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Oggi alle] LT',
            nextDay: '[Domani alle] LT',
            nextWeek: 'dddd [alle] LT',
            lastDay: '[Ieri alle] LT',
            lastWeek: function () {
                switch (this.day()) {
                    case 0:
                        return '[la scorsa] dddd [alle] LT';
                    default:
                        return '[lo scorso] dddd [alle] LT';
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : function (s) {
                return ((/^[0-9].+$/).test(s) ? 'tra' : 'in') + ' ' + s;
            },
            past : '%s fa',
            s : 'alcuni secondi',
            m : 'un minuto',
            mm : '%d minuti',
            h : 'un\'ora',
            hh : '%d ore',
            d : 'un giorno',
            dd : '%d giorni',
            M : 'un mese',
            MM : '%d mesi',
            y : 'un anno',
            yy : '%d anni'
        },
        ordinalParse : /\d{1,2}ยบ/,
        ordinal: '%dยบ',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : japanese (ja)
// author : LI Long : https://github.com/baryon

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ja', {
        months : '1ๆ_2ๆ_3ๆ_4ๆ_5ๆ_6ๆ_7ๆ_8ๆ_9ๆ_10ๆ_11ๆ_12ๆ'.split('_'),
        monthsShort : '1ๆ_2ๆ_3ๆ_4ๆ_5ๆ_6ๆ_7ๆ_8ๆ_9ๆ_10ๆ_11ๆ_12ๆ'.split('_'),
        weekdays : 'ๆ—ฅๆๆ—ฅ_ๆๆๆ—ฅ_็ซๆๆ—ฅ_ๆฐดๆๆ—ฅ_ๆจๆๆ—ฅ_้‘ๆๆ—ฅ_ๅๆๆ—ฅ'.split('_'),
        weekdaysShort : 'ๆ—ฅ_ๆ_็ซ_ๆฐด_ๆจ_้‘_ๅ'.split('_'),
        weekdaysMin : 'ๆ—ฅ_ๆ_็ซ_ๆฐด_ๆจ_้‘_ๅ'.split('_'),
        longDateFormat : {
            LT : 'Ahๆmๅ',
            LTS : 'LTs็ง’',
            L : 'YYYY/MM/DD',
            LL : 'YYYYๅนดMๆDๆ—ฅ',
            LLL : 'YYYYๅนดMๆDๆ—ฅLT',
            LLLL : 'YYYYๅนดMๆDๆ—ฅLT dddd'
        },
        meridiemParse: /ๅๅ|ๅๅพ/i,
        isPM : function (input) {
            return input === 'ๅๅพ';
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 12) {
                return 'ๅๅ';
            } else {
                return 'ๅๅพ';
            }
        },
        calendar : {
            sameDay : '[ไปๆ—ฅ] LT',
            nextDay : '[ๆๆ—ฅ] LT',
            nextWeek : '[ๆฅ้€ฑ]dddd LT',
            lastDay : '[ๆจๆ—ฅ] LT',
            lastWeek : '[ๅ้€ฑ]dddd LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%sๅพ',
            past : '%sๅ',
            s : 'ๆ•ฐ็ง’',
            m : '1ๅ',
            mm : '%dๅ',
            h : '1ๆ้–“',
            hh : '%dๆ้–“',
            d : '1ๆ—ฅ',
            dd : '%dๆ—ฅ',
            M : '1ใถๆ',
            MM : '%dใถๆ',
            y : '1ๅนด',
            yy : '%dๅนด'
        }
    });
}));
// moment.js locale configuration
// locale : Georgian (ka)
// author : Irakli Janiashvili : https://github.com/irakli-janiashvili

(function (factory) {
    factory(moment);
}(function (moment) {
    function monthsCaseReplace(m, format) {
        var months = {
            'nominative': 'แแแแ•แแ แ_แ—แ”แ‘แ”แ แ•แแแ_แแแ แขแ_แแแ แแแ_แแแแกแ_แแ•แแแกแ_แแ•แแแกแ_แแ’แ•แแกแขแ_แกแ”แฅแขแ”แแ‘แ”แ แ_แแฅแขแแแ‘แ”แ แ_แแแ”แแ‘แ”แ แ_แ“แ”แแ”แแ‘แ”แ แ'.split('_'),
            'accusative': 'แแแแ•แแ แก_แ—แ”แ‘แ”แ แ•แแแก_แแแ แขแก_แแแ แแแแก_แแแแกแก_แแ•แแแกแก_แแ•แแแกแก_แแ’แ•แแกแขแก_แกแ”แฅแขแ”แแ‘แ”แ แก_แแฅแขแแแ‘แ”แ แก_แแแ”แแ‘แ”แ แก_แ“แ”แแ”แแ‘แ”แ แก'.split('_')
        },

        nounCase = (/D[oD] *MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return months[nounCase][m.month()];
    }

    function weekdaysCaseReplace(m, format) {
        var weekdays = {
            'nominative': 'แแ•แแ แ_แแ แจแแ‘แแ—แ_แกแแแจแแ‘แแ—แ_แแ—แฎแจแแ‘แแ—แ_แฎแฃแ—แจแแ‘แแ—แ_แแแ แแกแแ”แ•แ_แจแแ‘แแ—แ'.split('_'),
            'accusative': 'แแ•แแ แแก_แแ แจแแ‘แแ—แก_แกแแแจแแ‘แแ—แก_แแ—แฎแจแแ‘แแ—แก_แฎแฃแ—แจแแ‘แแ—แก_แแแ แแกแแ”แ•แก_แจแแ‘แแ—แก'.split('_')
        },

        nounCase = (/(แฌแแแ|แจแ”แแ“แ”แ’)/).test(format) ?
            'accusative' :
            'nominative';

        return weekdays[nounCase][m.day()];
    }

    return moment.defineLocale('ka', {
        months : monthsCaseReplace,
        monthsShort : 'แแแ_แ—แ”แ‘_แแแ _แแแ _แแแ_แแ•แ_แแ•แ_แแ’แ•_แกแ”แฅ_แแฅแข_แแแ”_แ“แ”แ'.split('_'),
        weekdays : weekdaysCaseReplace,
        weekdaysShort : 'แแ•แ_แแ แจ_แกแแ_แแ—แฎ_แฎแฃแ—_แแแ _แจแแ‘'.split('_'),
        weekdaysMin : 'แแ•_แแ _แกแ_แแ—_แฎแฃ_แแ_แจแ'.split('_'),
        longDateFormat : {
            LT : 'h:mm A',
            LTS : 'h:mm:ss A',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[แ“แฆแ”แก] LT[-แ–แ”]',
            nextDay : '[แฎแ•แแ] LT[-แ–แ”]',
            lastDay : '[แ’แฃแจแแ] LT[-แ–แ”]',
            nextWeek : '[แจแ”แแ“แ”แ’] dddd LT[-แ–แ”]',
            lastWeek : '[แฌแแแ] dddd LT-แ–แ”',
            sameElse : 'L'
        },
        relativeTime : {
            future : function (s) {
                return (/(แฌแแแ|แฌแฃแ—แ|แกแแแ—แ|แฌแ”แแ)/).test(s) ?
                    s.replace(/แ$/, 'แจแ') :
                    s + 'แจแ';
            },
            past : function (s) {
                if ((/(แฌแแแ|แฌแฃแ—แ|แกแแแ—แ|แ“แฆแ”|แ—แ•แ”)/).test(s)) {
                    return s.replace(/(แ|แ”)$/, 'แแก แฌแแ');
                }
                if ((/แฌแ”แแ/).test(s)) {
                    return s.replace(/แฌแ”แแ$/, 'แฌแแแก แฌแแ');
                }
            },
            s : 'แ แแแ“แ”แแแแ” แฌแแแ',
            m : 'แฌแฃแ—แ',
            mm : '%d แฌแฃแ—แ',
            h : 'แกแแแ—แ',
            hh : '%d แกแแแ—แ',
            d : 'แ“แฆแ”',
            dd : '%d แ“แฆแ”',
            M : 'แ—แ•แ”',
            MM : '%d แ—แ•แ”',
            y : 'แฌแ”แแ',
            yy : '%d แฌแ”แแ'
        },
        ordinalParse: /0|1-แแ|แแ”-\d{1,2}|\d{1,2}-แ”/,
        ordinal : function (number) {
            if (number === 0) {
                return number;
            }

            if (number === 1) {
                return number + '-แแ';
            }

            if ((number < 20) || (number <= 100 && (number % 20 === 0)) || (number % 100 === 0)) {
                return 'แแ”-' + number;
            }

            return number + '-แ”';
        },
        week : {
            dow : 1,
            doy : 7
        }
    });
}));
// moment.js locale configuration
// locale : khmer (km)
// author : Kruy Vanna : https://github.com/kruyvanna

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('km', {
        months: 'แแ€แแถ_แ€แปแแ’แ—แ_แแทแ“แถ_แแแแถ_แงแแ—แถ_แแทแแปแ“แถ_แ€แ€แ’แ€แแถ_แแธแ แถ_แ€แแ’แแถ_แแปแแถ_แแทแ…แ’แแทแ€แถ_แ’แ’แ“แผ'.split('_'),
        monthsShort: 'แแ€แแถ_แ€แปแแ’แ—แ_แแทแ“แถ_แแแแถ_แงแแ—แถ_แแทแแปแ“แถ_แ€แ€แ’แ€แแถ_แแธแ แถ_แ€แแ’แแถ_แแปแแถ_แแทแ…แ’แแทแ€แถ_แ’แ’แ“แผ'.split('_'),
        weekdays: 'แขแถแ‘แทแแ’แ_แ…แแ“แ’แ‘_แขแแ’แแถแ_แ–แปแ’_แ–แ’แแ แแ’แ”แแทแ_แแปแ€แ’แ_แแ…แแ'.split('_'),
        weekdaysShort: 'แขแถแ‘แทแแ’แ_แ…แแ“แ’แ‘_แขแแ’แแถแ_แ–แปแ’_แ–แ’แแ แแ’แ”แแทแ_แแปแ€แ’แ_แแ…แแ'.split('_'),
        weekdaysMin: 'แขแถแ‘แทแแ’แ_แ…แแ“แ’แ‘_แขแแ’แแถแ_แ–แปแ’_แ–แ’แแ แแ’แ”แแทแ_แแปแ€แ’แ_แแ…แแ'.split('_'),
        longDateFormat: {
            LT: 'HH:mm',
            LTS : 'LT:ss',
            L: 'DD/MM/YYYY',
            LL: 'D MMMM YYYY',
            LLL: 'D MMMM YYYY LT',
            LLLL: 'dddd, D MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[แแ’แแแ“แ แแแแ] LT',
            nextDay: '[แแ’แขแแ€ แแแแ] LT',
            nextWeek: 'dddd [แแแแ] LT',
            lastDay: '[แแ’แแทแแแทแ แแแแ] LT',
            lastWeek: 'dddd [แแ”แ’แแถแ แแแปแ“] [แแแแ] LT',
            sameElse: 'L'
        },
        relativeTime: {
            future: '%sแ‘แ€แ',
            past: '%sแแปแ“',
            s: 'แ”แแปแ“แ’แแถแ“แแทแ“แถแ‘แธ',
            m: 'แแฝแแ“แถแ‘แธ',
            mm: '%d แ“แถแ‘แธ',
            h: 'แแฝแแแแแ',
            hh: '%d แแแแ',
            d: 'แแฝแแแ’แแ',
            dd: '%d แแ’แแ',
            M: 'แแฝแแแ',
            MM: '%d แแ',
            y: 'แแฝแแแ’แ“แถแ',
            yy: '%d แแ’แ“แถแ'
        },
        week: {
            dow: 1, // Monday is the first day of the week.
            doy: 4 // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : korean (ko)
//
// authors
//
// - Kyungwook, Park : https://github.com/kyungw00k
// - Jeeeyul Lee <jeeeyul@gmail.com>
(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ko', {
        months : '1์”_2์”_3์”_4์”_5์”_6์”_7์”_8์”_9์”_10์”_11์”_12์”'.split('_'),
        monthsShort : '1์”_2์”_3์”_4์”_5์”_6์”_7์”_8์”_9์”_10์”_11์”_12์”'.split('_'),
        weekdays : '์ผ์”์ผ_์”์”์ผ_ํ”์”์ผ_์์”์ผ_๋ชฉ์”์ผ_๊ธ์”์ผ_ํ ์”์ผ'.split('_'),
        weekdaysShort : '์ผ_์”_ํ”_์_๋ชฉ_๊ธ_ํ '.split('_'),
        weekdaysMin : '์ผ_์”_ํ”_์_๋ชฉ_๊ธ_ํ '.split('_'),
        longDateFormat : {
            LT : 'A h์ m๋ถ',
            LTS : 'A h์ m๋ถ s์ด',
            L : 'YYYY.MM.DD',
            LL : 'YYYY๋… MMMM D์ผ',
            LLL : 'YYYY๋… MMMM D์ผ LT',
            LLLL : 'YYYY๋… MMMM D์ผ dddd LT'
        },
        calendar : {
            sameDay : '์ค๋ LT',
            nextDay : '๋ด์ผ LT',
            nextWeek : 'dddd LT',
            lastDay : '์–ด์  LT',
            lastWeek : '์ง€๋์ฃผ dddd LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s ํ',
            past : '%s ์ ',
            s : '๋ช์ด',
            ss : '%d์ด',
            m : '์ผ๋ถ',
            mm : '%d๋ถ',
            h : 'ํ•์๊ฐ',
            hh : '%d์๊ฐ',
            d : 'ํ•๋ฃจ',
            dd : '%d์ผ',
            M : 'ํ•๋ฌ',
            MM : '%d๋ฌ',
            y : '์ผ๋…',
            yy : '%d๋…'
        },
        ordinalParse : /\d{1,2}์ผ/,
        ordinal : '%d์ผ',
        meridiemParse : /์ค์ |์คํ/,
        isPM : function (token) {
            return token === '์คํ';
        },
        meridiem : function (hour, minute, isUpper) {
            return hour < 12 ? '์ค์ ' : '์คํ';
        }
    });
}));
// moment.js locale configuration
// locale : Luxembourgish (lb)
// author : mweimerskirch : https://github.com/mweimerskirch, David Raison : https://github.com/kwisatz

// Note: Luxembourgish has a very particular phonological rule ('Eifeler Regel') that causes the
// deletion of the final 'n' in certain contexts. That's what the 'eifelerRegelAppliesToWeekday'
// and 'eifelerRegelAppliesToNumber' methods are meant for

(function (factory) {
    factory(moment);
}(function (moment) {
    function processRelativeTime(number, withoutSuffix, key, isFuture) {
        var format = {
            'm': ['eng Minutt', 'enger Minutt'],
            'h': ['eng Stonn', 'enger Stonn'],
            'd': ['een Dag', 'engem Dag'],
            'M': ['ee Mount', 'engem Mount'],
            'y': ['ee Joer', 'engem Joer']
        };
        return withoutSuffix ? format[key][0] : format[key][1];
    }

    function processFutureTime(string) {
        var number = string.substr(0, string.indexOf(' '));
        if (eifelerRegelAppliesToNumber(number)) {
            return 'a ' + string;
        }
        return 'an ' + string;
    }

    function processPastTime(string) {
        var number = string.substr(0, string.indexOf(' '));
        if (eifelerRegelAppliesToNumber(number)) {
            return 'viru ' + string;
        }
        return 'virun ' + string;
    }

    /**
     * Returns true if the word before the given number loses the '-n' ending.
     * e.g. 'an 10 Deeg' but 'a 5 Deeg'
     *
     * @param number {integer}
     * @returns {boolean}
     */
    function eifelerRegelAppliesToNumber(number) {
        number = parseInt(number, 10);
        if (isNaN(number)) {
            return false;
        }
        if (number < 0) {
            // Negative Number --> always true
            return true;
        } else if (number < 10) {
            // Only 1 digit
            if (4 <= number && number <= 7) {
                return true;
            }
            return false;
        } else if (number < 100) {
            // 2 digits
            var lastDigit = number % 10, firstDigit = number / 10;
            if (lastDigit === 0) {
                return eifelerRegelAppliesToNumber(firstDigit);
            }
            return eifelerRegelAppliesToNumber(lastDigit);
        } else if (number < 10000) {
            // 3 or 4 digits --> recursively check first digit
            while (number >= 10) {
                number = number / 10;
            }
            return eifelerRegelAppliesToNumber(number);
        } else {
            // Anything larger than 4 digits: recursively check first n-3 digits
            number = number / 1000;
            return eifelerRegelAppliesToNumber(number);
        }
    }

    return moment.defineLocale('lb', {
        months: 'Januar_Februar_Mรคerz_Abrรซll_Mee_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
        monthsShort: 'Jan._Febr._Mrz._Abr._Mee_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
        weekdays: 'Sonndeg_Mรฉindeg_Dรซnschdeg_Mรซttwoch_Donneschdeg_Freideg_Samschdeg'.split('_'),
        weekdaysShort: 'So._Mรฉ._Dรซ._Mรซ._Do._Fr._Sa.'.split('_'),
        weekdaysMin: 'So_Mรฉ_Dรซ_Mรซ_Do_Fr_Sa'.split('_'),
        longDateFormat: {
            LT: 'H:mm [Auer]',
            LTS: 'H:mm:ss [Auer]',
            L: 'DD.MM.YYYY',
            LL: 'D. MMMM YYYY',
            LLL: 'D. MMMM YYYY LT',
            LLLL: 'dddd, D. MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[Haut um] LT',
            sameElse: 'L',
            nextDay: '[Muer um] LT',
            nextWeek: 'dddd [um] LT',
            lastDay: '[Gรซschter um] LT',
            lastWeek: function () {
                // Different date string for 'Dรซnschdeg' (Tuesday) and 'Donneschdeg' (Thursday) due to phonological rule
                switch (this.day()) {
                    case 2:
                    case 4:
                        return '[Leschten] dddd [um] LT';
                    default:
                        return '[Leschte] dddd [um] LT';
                }
            }
        },
        relativeTime : {
            future : processFutureTime,
            past : processPastTime,
            s : 'e puer Sekonnen',
            m : processRelativeTime,
            mm : '%d Minutten',
            h : processRelativeTime,
            hh : '%d Stonnen',
            d : processRelativeTime,
            dd : '%d Deeg',
            M : processRelativeTime,
            MM : '%d Mรฉint',
            y : processRelativeTime,
            yy : '%d Joer'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal: '%d.',
        week: {
            dow: 1, // Monday is the first day of the week.
            doy: 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Lithuanian (lt)
// author : Mindaugas Mozลซras : https://github.com/mmozuras

(function (factory) {
    factory(moment);
}(function (moment) {
    var units = {
        'm' : 'minutฤ—_minutฤ—s_minutฤ',
        'mm': 'minutฤ—s_minuฤiลณ_minutes',
        'h' : 'valanda_valandos_valandฤ…',
        'hh': 'valandos_valandลณ_valandas',
        'd' : 'diena_dienos_dienฤ…',
        'dd': 'dienos_dienลณ_dienas',
        'M' : 'mฤ—nuo_mฤ—nesio_mฤ—nesฤฏ',
        'MM': 'mฤ—nesiai_mฤ—nesiลณ_mฤ—nesius',
        'y' : 'metai_metลณ_metus',
        'yy': 'metai_metลณ_metus'
    },
    weekDays = 'sekmadienis_pirmadienis_antradienis_treฤiadienis_ketvirtadienis_penktadienis_ลกeลกtadienis'.split('_');

    function translateSeconds(number, withoutSuffix, key, isFuture) {
        if (withoutSuffix) {
            return 'kelios sekundฤ—s';
        } else {
            return isFuture ? 'keliลณ sekundลพiลณ' : 'kelias sekundes';
        }
    }

    function translateSingular(number, withoutSuffix, key, isFuture) {
        return withoutSuffix ? forms(key)[0] : (isFuture ? forms(key)[1] : forms(key)[2]);
    }

    function special(number) {
        return number % 10 === 0 || (number > 10 && number < 20);
    }

    function forms(key) {
        return units[key].split('_');
    }

    function translate(number, withoutSuffix, key, isFuture) {
        var result = number + ' ';
        if (number === 1) {
            return result + translateSingular(number, withoutSuffix, key[0], isFuture);
        } else if (withoutSuffix) {
            return result + (special(number) ? forms(key)[1] : forms(key)[0]);
        } else {
            if (isFuture) {
                return result + forms(key)[1];
            } else {
                return result + (special(number) ? forms(key)[1] : forms(key)[2]);
            }
        }
    }

    function relativeWeekDay(moment, format) {
        var nominative = format.indexOf('dddd HH:mm') === -1,
            weekDay = weekDays[moment.day()];

        return nominative ? weekDay : weekDay.substring(0, weekDay.length - 2) + 'ฤฏ';
    }

    return moment.defineLocale('lt', {
        months : 'sausio_vasario_kovo_balandลพio_geguลพฤ—s_birลพelio_liepos_rugpjลซฤio_rugsฤ—jo_spalio_lapkriฤio_gruodลพio'.split('_'),
        monthsShort : 'sau_vas_kov_bal_geg_bir_lie_rgp_rgs_spa_lap_grd'.split('_'),
        weekdays : relativeWeekDay,
        weekdaysShort : 'Sek_Pir_Ant_Tre_Ket_Pen_ล eลก'.split('_'),
        weekdaysMin : 'S_P_A_T_K_Pn_ล '.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'YYYY-MM-DD',
            LL : 'YYYY [m.] MMMM D [d.]',
            LLL : 'YYYY [m.] MMMM D [d.], LT [val.]',
            LLLL : 'YYYY [m.] MMMM D [d.], dddd, LT [val.]',
            l : 'YYYY-MM-DD',
            ll : 'YYYY [m.] MMMM D [d.]',
            lll : 'YYYY [m.] MMMM D [d.], LT [val.]',
            llll : 'YYYY [m.] MMMM D [d.], ddd, LT [val.]'
        },
        calendar : {
            sameDay : '[ล iandien] LT',
            nextDay : '[Rytoj] LT',
            nextWeek : 'dddd LT',
            lastDay : '[Vakar] LT',
            lastWeek : '[Praฤ—jusฤฏ] dddd LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'po %s',
            past : 'prieลก %s',
            s : translateSeconds,
            m : translateSingular,
            mm : translate,
            h : translateSingular,
            hh : translate,
            d : translateSingular,
            dd : translate,
            M : translateSingular,
            MM : translate,
            y : translateSingular,
            yy : translate
        },
        ordinalParse: /\d{1,2}-oji/,
        ordinal : function (number) {
            return number + '-oji';
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : latvian (lv)
// author : Kristaps Karlsons : https://github.com/skakri

(function (factory) {
    factory(moment);
}(function (moment) {
    var units = {
        'mm': 'minลซti_minลซtes_minลซte_minลซtes',
        'hh': 'stundu_stundas_stunda_stundas',
        'dd': 'dienu_dienas_diena_dienas',
        'MM': 'mฤ“nesi_mฤ“neลกus_mฤ“nesis_mฤ“neลกi',
        'yy': 'gadu_gadus_gads_gadi'
    };

    function format(word, number, withoutSuffix) {
        var forms = word.split('_');
        if (withoutSuffix) {
            return number % 10 === 1 && number !== 11 ? forms[2] : forms[3];
        } else {
            return number % 10 === 1 && number !== 11 ? forms[0] : forms[1];
        }
    }

    function relativeTimeWithPlural(number, withoutSuffix, key) {
        return number + ' ' + format(units[key], number, withoutSuffix);
    }

    return moment.defineLocale('lv', {
        months : 'janvฤris_februฤris_marts_aprฤซlis_maijs_jลซnijs_jลซlijs_augusts_septembris_oktobris_novembris_decembris'.split('_'),
        monthsShort : 'jan_feb_mar_apr_mai_jลซn_jลซl_aug_sep_okt_nov_dec'.split('_'),
        weekdays : 'svฤ“tdiena_pirmdiena_otrdiena_treลกdiena_ceturtdiena_piektdiena_sestdiena'.split('_'),
        weekdaysShort : 'Sv_P_O_T_C_Pk_S'.split('_'),
        weekdaysMin : 'Sv_P_O_T_C_Pk_S'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'YYYY. [gada] D. MMMM',
            LLL : 'YYYY. [gada] D. MMMM, LT',
            LLLL : 'YYYY. [gada] D. MMMM, dddd, LT'
        },
        calendar : {
            sameDay : '[ล odien pulksten] LT',
            nextDay : '[Rฤซt pulksten] LT',
            nextWeek : 'dddd [pulksten] LT',
            lastDay : '[Vakar pulksten] LT',
            lastWeek : '[Pagฤjuลกฤ] dddd [pulksten] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s vฤ“lฤk',
            past : '%s agrฤk',
            s : 'daลพas sekundes',
            m : 'minลซti',
            mm : relativeTimeWithPlural,
            h : 'stundu',
            hh : relativeTimeWithPlural,
            d : 'dienu',
            dd : relativeTimeWithPlural,
            M : 'mฤ“nesi',
            MM : relativeTimeWithPlural,
            y : 'gadu',
            yy : relativeTimeWithPlural
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : macedonian (mk)
// author : Borislav Mickov : https://github.com/B0k0

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('mk', {
        months : 'ัะฐะฝัะฐั€ะธ_ัะตะฒั€ัะฐั€ะธ_ะผะฐั€ั_ะฐะฟั€ะธะป_ะผะฐั_ััะฝะธ_ััะปะธ_ะฐะฒะณััั_ัะตะฟัะตะผะฒั€ะธ_ะพะบัะพะผะฒั€ะธ_ะฝะพะตะผะฒั€ะธ_ะดะตะบะตะผะฒั€ะธ'.split('_'),
        monthsShort : 'ัะฐะฝ_ัะตะฒ_ะผะฐั€_ะฐะฟั€_ะผะฐั_ััะฝ_ััะป_ะฐะฒะณ_ัะตะฟ_ะพะบั_ะฝะพะต_ะดะตะบ'.split('_'),
        weekdays : 'ะฝะตะดะตะปะฐ_ะฟะพะฝะตะดะตะปะฝะธะบ_ะฒัะพั€ะฝะธะบ_ัั€ะตะดะฐ_ัะตัะฒั€ัะพะบ_ะฟะตัะพะบ_ัะฐะฑะพัะฐ'.split('_'),
        weekdaysShort : 'ะฝะตะด_ะฟะพะฝ_ะฒัะพ_ัั€ะต_ัะตั_ะฟะตั_ัะฐะฑ'.split('_'),
        weekdaysMin : 'ะฝe_ะฟo_ะฒั_ัั€_ัะต_ะฟะต_ัa'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'D.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[ะ”ะตะฝะตั ะฒะพ] LT',
            nextDay : '[ะฃัั€ะต ะฒะพ] LT',
            nextWeek : 'dddd [ะฒะพ] LT',
            lastDay : '[ะ’ัะตั€ะฐ ะฒะพ] LT',
            lastWeek : function () {
                switch (this.day()) {
                case 0:
                case 3:
                case 6:
                    return '[ะ’ะพ ะธะทะผะธะฝะฐัะฐัะฐ] dddd [ะฒะพ] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[ะ’ะพ ะธะทะผะธะฝะฐัะธะพั] dddd [ะฒะพ] LT';
                }
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ะฟะพัะปะต %s',
            past : 'ะฟั€ะตะด %s',
            s : 'ะฝะตะบะพะปะบั ัะตะบัะฝะดะธ',
            m : 'ะผะธะฝััะฐ',
            mm : '%d ะผะธะฝััะธ',
            h : 'ัะฐั',
            hh : '%d ัะฐัะฐ',
            d : 'ะดะตะฝ',
            dd : '%d ะดะตะฝะฐ',
            M : 'ะผะตัะตั',
            MM : '%d ะผะตัะตัะธ',
            y : 'ะณะพะดะธะฝะฐ',
            yy : '%d ะณะพะดะธะฝะธ'
        },
        ordinalParse: /\d{1,2}-(ะตะฒ|ะตะฝ|ัะธ|ะฒะธ|ั€ะธ|ะผะธ)/,
        ordinal : function (number) {
            var lastDigit = number % 10,
                last2Digits = number % 100;
            if (number === 0) {
                return number + '-ะตะฒ';
            } else if (last2Digits === 0) {
                return number + '-ะตะฝ';
            } else if (last2Digits > 10 && last2Digits < 20) {
                return number + '-ัะธ';
            } else if (lastDigit === 1) {
                return number + '-ะฒะธ';
            } else if (lastDigit === 2) {
                return number + '-ั€ะธ';
            } else if (lastDigit === 7 || lastDigit === 8) {
                return number + '-ะผะธ';
            } else {
                return number + '-ัะธ';
            }
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : malayalam (ml)
// author : Floyd Pink : https://github.com/floydpink

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ml', {
        months : 'เดเดจเตเดตเดฐเดฟ_เดซเตเดฌเตเดฐเตเดตเดฐเดฟ_เดฎเดพเตผเดเตเดเต_เดเดชเตเดฐเดฟเตฝ_เดฎเตเดฏเต_เดเตเตบ_เดเตเดฒเต_เด“เด—เดธเตเดฑเตเดฑเต_เดธเตเดชเตเดฑเตเดฑเดเดฌเตผ_เด’เด•เตเดเตเดฌเตผ_เดจเดตเดเดฌเตผ_เดกเดฟเดธเดเดฌเตผ'.split('_'),
        monthsShort : 'เดเดจเต._เดซเตเดฌเตเดฐเต._เดฎเดพเตผ._เดเดชเตเดฐเดฟ._เดฎเตเดฏเต_เดเตเตบ_เดเตเดฒเต._เด“เด—._เดธเตเดชเตเดฑเตเดฑ._เด’เด•เตเดเต._เดจเดตเด._เดกเดฟเดธเด.'.split('_'),
        weekdays : 'เดเดพเดฏเดฑเดพเดดเตเด_เดคเดฟเดเตเด•เดณเดพเดดเตเด_เดเตเดตเตเดตเดพเดดเตเด_เดฌเตเดงเดจเดพเดดเตเด_เดตเตเดฏเดพเดดเดพเดดเตเด_เดตเตเดณเตเดณเดฟเดฏเดพเดดเตเด_เดถเดจเดฟเดฏเดพเดดเตเด'.split('_'),
        weekdaysShort : 'เดเดพเดฏเตผ_เดคเดฟเดเตเด•เตพ_เดเตเดตเตเดต_เดฌเตเดงเตป_เดตเตเดฏเดพเดดเด_เดตเตเดณเตเดณเดฟ_เดถเดจเดฟ'.split('_'),
        weekdaysMin : 'เดเดพ_เดคเดฟ_เดเต_เดฌเต_เดตเตเดฏเดพ_เดตเต_เดถ'.split('_'),
        longDateFormat : {
            LT : 'A h:mm -เดจเต',
            LTS : 'A h:mm:ss -เดจเต',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        calendar : {
            sameDay : '[เดเดจเตเดจเต] LT',
            nextDay : '[เดจเดพเดณเต] LT',
            nextWeek : 'dddd, LT',
            lastDay : '[เดเดจเตเดจเดฒเต] LT',
            lastWeek : '[เด•เดดเดฟเดเตเด] dddd, LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s เด•เดดเดฟเดเตเดเต',
            past : '%s เดฎเตเตปเดชเต',
            s : 'เด…เตฝเดช เดจเดฟเดฎเดฟเดทเดเตเดเตพ',
            m : 'เด’เดฐเต เดฎเดฟเดจเดฟเดฑเตเดฑเต',
            mm : '%d เดฎเดฟเดจเดฟเดฑเตเดฑเต',
            h : 'เด’เดฐเต เดฎเดฃเดฟเด•เตเด•เตเตผ',
            hh : '%d เดฎเดฃเดฟเด•เตเด•เตเตผ',
            d : 'เด’เดฐเต เดฆเดฟเดตเดธเด',
            dd : '%d เดฆเดฟเดตเดธเด',
            M : 'เด’เดฐเต เดฎเดพเดธเด',
            MM : '%d เดฎเดพเดธเด',
            y : 'เด’เดฐเต เดตเตผเดทเด',
            yy : '%d เดตเตผเดทเด'
        },
        meridiemParse: /เดฐเดพเดคเตเดฐเดฟ|เดฐเดพเดตเดฟเดฒเต|เดเดเตเด เด•เดดเดฟเดเตเดเต|เดตเตเด•เตเดจเตเดจเตเดฐเด|เดฐเดพเดคเตเดฐเดฟ/i,
        isPM : function (input) {
            return /^(เดเดเตเด เด•เดดเดฟเดเตเดเต|เดตเตเด•เตเดจเตเดจเตเดฐเด|เดฐเดพเดคเตเดฐเดฟ)$/.test(input);
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'เดฐเดพเดคเตเดฐเดฟ';
            } else if (hour < 12) {
                return 'เดฐเดพเดตเดฟเดฒเต';
            } else if (hour < 17) {
                return 'เดเดเตเด เด•เดดเดฟเดเตเดเต';
            } else if (hour < 20) {
                return 'เดตเตเด•เตเดจเตเดจเตเดฐเด';
            } else {
                return 'เดฐเดพเดคเตเดฐเดฟ';
            }
        }
    });
}));
// moment.js locale configuration
// locale : Marathi (mr)
// author : Harshad Kale : https://github.com/kalehv

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'เฅง',
        '2': 'เฅจ',
        '3': 'เฅฉ',
        '4': 'เฅช',
        '5': 'เฅซ',
        '6': 'เฅฌ',
        '7': 'เฅญ',
        '8': 'เฅฎ',
        '9': 'เฅฏ',
        '0': 'เฅฆ'
    },
    numberMap = {
        'เฅง': '1',
        'เฅจ': '2',
        'เฅฉ': '3',
        'เฅช': '4',
        'เฅซ': '5',
        'เฅฌ': '6',
        'เฅญ': '7',
        'เฅฎ': '8',
        'เฅฏ': '9',
        'เฅฆ': '0'
    };

    return moment.defineLocale('mr', {
        months : 'เคเคพเคจเฅเคตเคพเคฐเฅ€_เคซเฅเคฌเฅเคฐเฅเคตเคพเคฐเฅ€_เคฎเคพเคฐเฅเค_เคเคชเฅเคฐเคฟเคฒ_เคฎเฅ_เคเฅเคจ_เคเฅเคฒเฅ_เค‘เค—เคธเฅเค_เคธเคชเฅเคเฅเคเคฌเคฐ_เค‘เค•เฅเคเฅเคฌเคฐ_เคจเฅเคตเฅเคนเฅเคเคฌเคฐ_เคกเคฟเคธเฅเคเคฌเคฐ'.split('_'),
        monthsShort: 'เคเคพเคจเฅ._เคซเฅเคฌเฅเคฐเฅ._เคฎเคพเคฐเฅเค._เคเคชเฅเคฐเคฟ._เคฎเฅ._เคเฅเคจ._เคเฅเคฒเฅ._เค‘เค—._เคธเคชเฅเคเฅเค._เค‘เค•เฅเคเฅ._เคจเฅเคตเฅเคนเฅเค._เคกเคฟเคธเฅเค.'.split('_'),
        weekdays : 'เคฐเคตเคฟเคตเคพเคฐ_เคธเฅเคฎเคตเคพเคฐ_เคฎเคเค—เคณเคตเคพเคฐ_เคฌเฅเคงเคตเคพเคฐ_เค—เฅเคฐเฅเคตเคพเคฐ_เคถเฅเค•เฅเคฐเคตเคพเคฐ_เคถเคจเคฟเคตเคพเคฐ'.split('_'),
        weekdaysShort : 'เคฐเคตเคฟ_เคธเฅเคฎ_เคฎเคเค—เคณ_เคฌเฅเคง_เค—เฅเคฐเฅ_เคถเฅเค•เฅเคฐ_เคถเคจเคฟ'.split('_'),
        weekdaysMin : 'เคฐ_เคธเฅ_เคฎเค_เคฌเฅ_เค—เฅ_เคถเฅ_เคถ'.split('_'),
        longDateFormat : {
            LT : 'A h:mm เคตเคพเคเคคเคพ',
            LTS : 'A h:mm:ss เคตเคพเคเคคเคพ',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        calendar : {
            sameDay : '[เคเค] LT',
            nextDay : '[เคเคฆเฅเคฏเคพ] LT',
            nextWeek : 'dddd, LT',
            lastDay : '[เค•เคพเคฒ] LT',
            lastWeek: '[เคฎเคพเค—เฅ€เคฒ] dddd, LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s เคจเคเคคเคฐ',
            past : '%s เคชเฅเคฐเฅเคตเฅ€',
            s : 'เคธเฅเค•เคเคฆ',
            m: 'เคเค• เคฎเคฟเคจเคฟเค',
            mm: '%d เคฎเคฟเคจเคฟเคเฅ',
            h : 'เคเค• เคคเคพเคธ',
            hh : '%d เคคเคพเคธ',
            d : 'เคเค• เคฆเคฟเคตเคธ',
            dd : '%d เคฆเคฟเคตเคธ',
            M : 'เคเค• เคฎเคนเคฟเคจเคพ',
            MM : '%d เคฎเคนเคฟเคจเฅ',
            y : 'เคเค• เคตเคฐเฅเคท',
            yy : '%d เคตเคฐเฅเคทเฅ'
        },
        preparse: function (string) {
            return string.replace(/[เฅงเฅจเฅฉเฅชเฅซเฅฌเฅญเฅฎเฅฏเฅฆ]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },
        meridiemParse: /เคฐเคพเคคเฅเคฐเฅ€|เคธเค•เคพเคณเฅ€|เคฆเฅเคชเคพเคฐเฅ€|เคธเคพเคฏเคเค•เคพเคณเฅ€/,
        meridiemHour : function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'เคฐเคพเคคเฅเคฐเฅ€') {
                return hour < 4 ? hour : hour + 12;
            } else if (meridiem === 'เคธเค•เคพเคณเฅ€') {
                return hour;
            } else if (meridiem === 'เคฆเฅเคชเคพเคฐเฅ€') {
                return hour >= 10 ? hour : hour + 12;
            } else if (meridiem === 'เคธเคพเคฏเคเค•เคพเคณเฅ€') {
                return hour + 12;
            }
        },
        meridiem: function (hour, minute, isLower)
        {
            if (hour < 4) {
                return 'เคฐเคพเคคเฅเคฐเฅ€';
            } else if (hour < 10) {
                return 'เคธเค•เคพเคณเฅ€';
            } else if (hour < 17) {
                return 'เคฆเฅเคชเคพเคฐเฅ€';
            } else if (hour < 20) {
                return 'เคธเคพเคฏเคเค•เคพเคณเฅ€';
            } else {
                return 'เคฐเคพเคคเฅเคฐเฅ€';
            }
        },
        week : {
            dow : 0, // Sunday is the first day of the week.
            doy : 6  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Bahasa Malaysia (ms-MY)
// author : Weldan Jamili : https://github.com/weldan

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('ms-my', {
        months : 'Januari_Februari_Mac_April_Mei_Jun_Julai_Ogos_September_Oktober_November_Disember'.split('_'),
        monthsShort : 'Jan_Feb_Mac_Apr_Mei_Jun_Jul_Ogs_Sep_Okt_Nov_Dis'.split('_'),
        weekdays : 'Ahad_Isnin_Selasa_Rabu_Khamis_Jumaat_Sabtu'.split('_'),
        weekdaysShort : 'Ahd_Isn_Sel_Rab_Kha_Jum_Sab'.split('_'),
        weekdaysMin : 'Ah_Is_Sl_Rb_Km_Jm_Sb'.split('_'),
        longDateFormat : {
            LT : 'HH.mm',
            LTS : 'LT.ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY [pukul] LT',
            LLLL : 'dddd, D MMMM YYYY [pukul] LT'
        },
        meridiemParse: /pagi|tengahari|petang|malam/,
        meridiemHour: function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'pagi') {
                return hour;
            } else if (meridiem === 'tengahari') {
                return hour >= 11 ? hour : hour + 12;
            } else if (meridiem === 'petang' || meridiem === 'malam') {
                return hour + 12;
            }
        },
        meridiem : function (hours, minutes, isLower) {
            if (hours < 11) {
                return 'pagi';
            } else if (hours < 15) {
                return 'tengahari';
            } else if (hours < 19) {
                return 'petang';
            } else {
                return 'malam';
            }
        },
        calendar : {
            sameDay : '[Hari ini pukul] LT',
            nextDay : '[Esok pukul] LT',
            nextWeek : 'dddd [pukul] LT',
            lastDay : '[Kelmarin pukul] LT',
            lastWeek : 'dddd [lepas pukul] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'dalam %s',
            past : '%s yang lepas',
            s : 'beberapa saat',
            m : 'seminit',
            mm : '%d minit',
            h : 'sejam',
            hh : '%d jam',
            d : 'sehari',
            dd : '%d hari',
            M : 'sebulan',
            MM : '%d bulan',
            y : 'setahun',
            yy : '%d tahun'
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Burmese (my)
// author : Squar team, mysquar.com

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'แ',
        '2': 'แ',
        '3': 'แ',
        '4': 'แ',
        '5': 'แ…',
        '6': 'แ',
        '7': 'แ',
        '8': 'แ',
        '9': 'แ',
        '0': 'แ€'
    }, numberMap = {
        'แ': '1',
        'แ': '2',
        'แ': '3',
        'แ': '4',
        'แ…': '5',
        'แ': '6',
        'แ': '7',
        'แ': '8',
        'แ': '9',
        'แ€': '0'
    };
    return moment.defineLocale('my', {
        months: 'แ€แ€”แ€บแ€”แ€แ€ซแ€แ€ฎ_แ€–แ€ฑแ€–แ€ฑแ€ฌแ€บแ€แ€ซแ€แ€ฎ_แ€แ€แ€บ_แ€งแ€•แ€ผแ€ฎ_แ€แ€ฑ_แ€แ€ฝแ€”แ€บ_แ€แ€ฐแ€แ€ญแ€ฏแ€แ€บ_แ€แ€ผแ€แ€ฏแ€แ€บ_แ€…แ€€แ€บแ€แ€แ€บแ€แ€ฌ_แ€กแ€ฑแ€ฌแ€€แ€บแ€แ€ญแ€ฏแ€แ€ฌ_แ€”แ€ญแ€ฏแ€แ€แ€บแ€แ€ฌ_แ€’แ€ฎแ€แ€แ€บแ€แ€ฌ'.split('_'),
        monthsShort: 'แ€แ€”แ€บ_แ€–แ€ฑ_แ€แ€แ€บ_แ€•แ€ผแ€ฎ_แ€แ€ฑ_แ€แ€ฝแ€”แ€บ_แ€แ€ญแ€ฏแ€แ€บ_แ€แ€ผ_แ€…แ€€แ€บ_แ€กแ€ฑแ€ฌแ€€แ€บ_แ€”แ€ญแ€ฏ_แ€’แ€ฎ'.split('_'),
        weekdays: 'แ€แ€”แ€แ€บแ€นแ€แ€”แ€ฝแ€ฑ_แ€แ€”แ€แ€บแ€นแ€แ€ฌ_แ€กแ€แ€บแ€นแ€แ€ซ_แ€—แ€ฏแ€’แ€นแ€“แ€แ€ฐแ€ธ_แ€€แ€ผแ€ฌแ€แ€•แ€แ€ฑแ€ธ_แ€แ€ฑแ€ฌแ€€แ€ผแ€ฌ_แ€…แ€”แ€ฑ'.split('_'),
        weekdaysShort: 'แ€”แ€ฝแ€ฑ_แ€แ€ฌ_แ€แ€บแ€นแ€แ€ซ_แ€แ€ฐแ€ธ_แ€€แ€ผแ€ฌ_แ€แ€ฑแ€ฌ_แ€”แ€ฑ'.split('_'),
        weekdaysMin: 'แ€”แ€ฝแ€ฑ_แ€แ€ฌ_แ€แ€บแ€นแ€แ€ซ_แ€แ€ฐแ€ธ_แ€€แ€ผแ€ฌ_แ€แ€ฑแ€ฌ_แ€”แ€ฑ'.split('_'),
        longDateFormat: {
            LT: 'HH:mm',
            LTS: 'HH:mm:ss',
            L: 'DD/MM/YYYY',
            LL: 'D MMMM YYYY',
            LLL: 'D MMMM YYYY LT',
            LLLL: 'dddd D MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[แ€แ€”แ€ฑ.] LT [แ€แ€พแ€ฌ]',
            nextDay: '[แ€แ€”แ€€แ€บแ€–แ€ผแ€”แ€บ] LT [แ€แ€พแ€ฌ]',
            nextWeek: 'dddd LT [แ€แ€พแ€ฌ]',
            lastDay: '[แ€แ€”แ€ฑ.แ€€] LT [แ€แ€พแ€ฌ]',
            lastWeek: '[แ€•แ€ผแ€ฎแ€ธแ€แ€ฒแ€ทแ€แ€ฑแ€ฌ] dddd LT [แ€แ€พแ€ฌ]',
            sameElse: 'L'
        },
        relativeTime: {
            future: 'แ€แ€ฌแ€แ€แ€บแ€ท %s แ€แ€พแ€ฌ',
            past: 'แ€แ€ฝแ€”แ€บแ€แ€ฒแ€ทแ€แ€ฑแ€ฌ %s แ€€',
            s: 'แ€…แ€€แ€นแ€€แ€”แ€บ.แ€กแ€”แ€แ€บแ€ธแ€แ€แ€บ',
            m: 'แ€แ€…แ€บแ€แ€ญแ€”แ€…แ€บ',
            mm: '%d แ€แ€ญแ€”แ€…แ€บ',
            h: 'แ€แ€…แ€บแ€”แ€ฌแ€แ€ฎ',
            hh: '%d แ€”แ€ฌแ€แ€ฎ',
            d: 'แ€แ€…แ€บแ€แ€€แ€บ',
            dd: '%d แ€แ€€แ€บ',
            M: 'แ€แ€…แ€บแ€',
            MM: '%d แ€',
            y: 'แ€แ€…แ€บแ€”แ€พแ€…แ€บ',
            yy: '%d แ€”แ€พแ€…แ€บ'
        },
        preparse: function (string) {
            return string.replace(/[แแแแแ…แแแแแ€]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },
        week: {
            dow: 1, // Monday is the first day of the week.
            doy: 4 // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : norwegian bokmรฅl (nb)
// authors : Espen Hovlandsdal : https://github.com/rexxars
//           Sigurd Gartmann : https://github.com/sigurdga

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('nb', {
        months : 'januar_februar_mars_april_mai_juni_juli_august_september_oktober_november_desember'.split('_'),
        monthsShort : 'jan_feb_mar_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_'),
        weekdays : 'sรธndag_mandag_tirsdag_onsdag_torsdag_fredag_lรธrdag'.split('_'),
        weekdaysShort : 'sรธn_man_tirs_ons_tors_fre_lรธr'.split('_'),
        weekdaysMin : 'sรธ_ma_ti_on_to_fr_lรธ'.split('_'),
        longDateFormat : {
            LT : 'H.mm',
            LTS : 'LT.ss',
            L : 'DD.MM.YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY [kl.] LT',
            LLLL : 'dddd D. MMMM YYYY [kl.] LT'
        },
        calendar : {
            sameDay: '[i dag kl.] LT',
            nextDay: '[i morgen kl.] LT',
            nextWeek: 'dddd [kl.] LT',
            lastDay: '[i gรฅr kl.] LT',
            lastWeek: '[forrige] dddd [kl.] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'om %s',
            past : 'for %s siden',
            s : 'noen sekunder',
            m : 'ett minutt',
            mm : '%d minutter',
            h : 'en time',
            hh : '%d timer',
            d : 'en dag',
            dd : '%d dager',
            M : 'en mรฅned',
            MM : '%d mรฅneder',
            y : 'ett รฅr',
            yy : '%d รฅr'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : nepali/nepalese
// author : suvash : https://github.com/suvash

(function (factory) {
    factory(moment);
}(function (moment) {
    var symbolMap = {
        '1': 'เฅง',
        '2': 'เฅจ',
        '3': 'เฅฉ',
        '4': 'เฅช',
        '5': 'เฅซ',
        '6': 'เฅฌ',
        '7': 'เฅญ',
        '8': 'เฅฎ',
        '9': 'เฅฏ',
        '0': 'เฅฆ'
    },
    numberMap = {
        'เฅง': '1',
        'เฅจ': '2',
        'เฅฉ': '3',
        'เฅช': '4',
        'เฅซ': '5',
        'เฅฌ': '6',
        'เฅญ': '7',
        'เฅฎ': '8',
        'เฅฏ': '9',
        'เฅฆ': '0'
    };

    return moment.defineLocale('ne', {
        months : 'เคเคจเคตเคฐเฅ€_เคซเฅเคฌเฅเคฐเฅเคตเคฐเฅ€_เคฎเคพเคฐเฅเค_เค…เคชเฅเคฐเคฟเคฒ_เคฎเค_เคเฅเคจ_เคเฅเคฒเคพเค_เค…เค—เคทเฅเค_เคธเฅเคชเฅเคเฅเคฎเฅเคฌเคฐ_เค…เค•เฅเคเฅเคฌเคฐ_เคจเฅเคญเฅเคฎเฅเคฌเคฐ_เคกเคฟเคธเฅเคฎเฅเคฌเคฐ'.split('_'),
        monthsShort : 'เคเคจ._เคซเฅเคฌเฅเคฐเฅ._เคฎเคพเคฐเฅเค_เค…เคชเฅเคฐเคฟ._เคฎเค_เคเฅเคจ_เคเฅเคฒเคพเค._เค…เค—._เคธเฅเคชเฅเค._เค…เค•เฅเคเฅ._เคจเฅเคญเฅ._เคกเคฟเคธเฅ.'.split('_'),
        weekdays : 'เคเคเคคเคฌเคพเคฐ_เคธเฅเคฎเคฌเคพเคฐ_เคฎเคเฅเค—เคฒเคฌเคพเคฐ_เคฌเฅเคงเคฌเคพเคฐ_เคฌเคฟเคนเคฟเคฌเคพเคฐ_เคถเฅเค•เฅเคฐเคฌเคพเคฐ_เคถเคจเคฟเคฌเคพเคฐ'.split('_'),
        weekdaysShort : 'เคเคเคค._เคธเฅเคฎ._เคฎเคเฅเค—เคฒ._เคฌเฅเคง._เคฌเคฟเคนเคฟ._เคถเฅเค•เฅเคฐ._เคถเคจเคฟ.'.split('_'),
        weekdaysMin : 'เคเค._เคธเฅ._เคฎเคเฅ_เคฌเฅ._เคฌเคฟ._เคถเฅ._เคถ.'.split('_'),
        longDateFormat : {
            LT : 'Aเค•เฅ h:mm เคฌเคเฅ',
            LTS : 'Aเค•เฅ h:mm:ss เคฌเคเฅ',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        preparse: function (string) {
            return string.replace(/[เฅงเฅจเฅฉเฅชเฅซเฅฌเฅญเฅฎเฅฏเฅฆ]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },
        meridiemParse: /เคฐเคพเคคเฅ€|เคฌเคฟเคนเคพเคจ|เคฆเคฟเคเคเคธเฅ|เคฌเฅเคฒเฅเค•เคพ|เคธเคพเคเค|เคฐเคพเคคเฅ€/,
        meridiemHour : function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'เคฐเคพเคคเฅ€') {
                return hour < 3 ? hour : hour + 12;
            } else if (meridiem === 'เคฌเคฟเคนเคพเคจ') {
                return hour;
            } else if (meridiem === 'เคฆเคฟเคเคเคธเฅ') {
                return hour >= 10 ? hour : hour + 12;
            } else if (meridiem === 'เคฌเฅเคฒเฅเค•เคพ' || meridiem === 'เคธเคพเคเค') {
                return hour + 12;
            }
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 3) {
                return 'เคฐเคพเคคเฅ€';
            } else if (hour < 10) {
                return 'เคฌเคฟเคนเคพเคจ';
            } else if (hour < 15) {
                return 'เคฆเคฟเคเคเคธเฅ';
            } else if (hour < 18) {
                return 'เคฌเฅเคฒเฅเค•เคพ';
            } else if (hour < 20) {
                return 'เคธเคพเคเค';
            } else {
                return 'เคฐเคพเคคเฅ€';
            }
        },
        calendar : {
            sameDay : '[เคเค] LT',
            nextDay : '[เคญเฅเคฒเฅ€] LT',
            nextWeek : '[เคเคเคเคฆเฅ] dddd[,] LT',
            lastDay : '[เคนเคฟเคเฅ] LT',
            lastWeek : '[เค—เคเค•เฅ] dddd[,] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%sเคฎเคพ',
            past : '%s เค…เค—เคพเคกเฅ€',
            s : 'เค•เฅเคนเฅ€ เคธเคฎเคฏ',
            m : 'เคเค• เคฎเคฟเคจเฅเค',
            mm : '%d เคฎเคฟเคจเฅเค',
            h : 'เคเค• เคเคฃเฅเคเคพ',
            hh : '%d เคเคฃเฅเคเคพ',
            d : 'เคเค• เคฆเคฟเคจ',
            dd : '%d เคฆเคฟเคจ',
            M : 'เคเค• เคฎเคนเคฟเคจเคพ',
            MM : '%d เคฎเคนเคฟเคจเคพ',
            y : 'เคเค• เคฌเคฐเฅเคท',
            yy : '%d เคฌเคฐเฅเคท'
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : dutch (nl)
// author : Joris Rรถling : https://github.com/jjupiter

(function (factory) {
    factory(moment);
}(function (moment) {
    var monthsShortWithDots = 'jan._feb._mrt._apr._mei_jun._jul._aug._sep._okt._nov._dec.'.split('_'),
        monthsShortWithoutDots = 'jan_feb_mrt_apr_mei_jun_jul_aug_sep_okt_nov_dec'.split('_');

    return moment.defineLocale('nl', {
        months : 'januari_februari_maart_april_mei_juni_juli_augustus_september_oktober_november_december'.split('_'),
        monthsShort : function (m, format) {
            if (/-MMM-/.test(format)) {
                return monthsShortWithoutDots[m.month()];
            } else {
                return monthsShortWithDots[m.month()];
            }
        },
        weekdays : 'zondag_maandag_dinsdag_woensdag_donderdag_vrijdag_zaterdag'.split('_'),
        weekdaysShort : 'zo._ma._di._wo._do._vr._za.'.split('_'),
        weekdaysMin : 'Zo_Ma_Di_Wo_Do_Vr_Za'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD-MM-YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[vandaag om] LT',
            nextDay: '[morgen om] LT',
            nextWeek: 'dddd [om] LT',
            lastDay: '[gisteren om] LT',
            lastWeek: '[afgelopen] dddd [om] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'over %s',
            past : '%s geleden',
            s : 'een paar seconden',
            m : 'รฉรฉn minuut',
            mm : '%d minuten',
            h : 'รฉรฉn uur',
            hh : '%d uur',
            d : 'รฉรฉn dag',
            dd : '%d dagen',
            M : 'รฉรฉn maand',
            MM : '%d maanden',
            y : 'รฉรฉn jaar',
            yy : '%d jaar'
        },
        ordinalParse: /\d{1,2}(ste|de)/,
        ordinal : function (number) {
            return number + ((number === 1 || number === 8 || number >= 20) ? 'ste' : 'de');
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : norwegian nynorsk (nn)
// author : https://github.com/mechuwind

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('nn', {
        months : 'januar_februar_mars_april_mai_juni_juli_august_september_oktober_november_desember'.split('_'),
        monthsShort : 'jan_feb_mar_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_'),
        weekdays : 'sundag_mรฅndag_tysdag_onsdag_torsdag_fredag_laurdag'.split('_'),
        weekdaysShort : 'sun_mรฅn_tys_ons_tor_fre_lau'.split('_'),
        weekdaysMin : 'su_mรฅ_ty_on_to_fr_lรธ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[I dag klokka] LT',
            nextDay: '[I morgon klokka] LT',
            nextWeek: 'dddd [klokka] LT',
            lastDay: '[I gรฅr klokka] LT',
            lastWeek: '[Fรธregรฅande] dddd [klokka] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'om %s',
            past : 'for %s sidan',
            s : 'nokre sekund',
            m : 'eit minutt',
            mm : '%d minutt',
            h : 'ein time',
            hh : '%d timar',
            d : 'ein dag',
            dd : '%d dagar',
            M : 'ein mรฅnad',
            MM : '%d mรฅnader',
            y : 'eit รฅr',
            yy : '%d รฅr'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : polish (pl)
// author : Rafal Hirsz : https://github.com/evoL

(function (factory) {
    factory(moment);
}(function (moment) {
    var monthsNominative = 'styczeล_luty_marzec_kwiecieล_maj_czerwiec_lipiec_sierpieล_wrzesieล_paลบdziernik_listopad_grudzieล'.split('_'),
        monthsSubjective = 'stycznia_lutego_marca_kwietnia_maja_czerwca_lipca_sierpnia_wrzeลnia_paลบdziernika_listopada_grudnia'.split('_');

    function plural(n) {
        return (n % 10 < 5) && (n % 10 > 1) && ((~~(n / 10) % 10) !== 1);
    }

    function translate(number, withoutSuffix, key) {
        var result = number + ' ';
        switch (key) {
        case 'm':
            return withoutSuffix ? 'minuta' : 'minutฤ';
        case 'mm':
            return result + (plural(number) ? 'minuty' : 'minut');
        case 'h':
            return withoutSuffix  ? 'godzina'  : 'godzinฤ';
        case 'hh':
            return result + (plural(number) ? 'godziny' : 'godzin');
        case 'MM':
            return result + (plural(number) ? 'miesiฤ…ce' : 'miesiฤcy');
        case 'yy':
            return result + (plural(number) ? 'lata' : 'lat');
        }
    }

    return moment.defineLocale('pl', {
        months : function (momentToFormat, format) {
            if (/D MMMM/.test(format)) {
                return monthsSubjective[momentToFormat.month()];
            } else {
                return monthsNominative[momentToFormat.month()];
            }
        },
        monthsShort : 'sty_lut_mar_kwi_maj_cze_lip_sie_wrz_paลบ_lis_gru'.split('_'),
        weekdays : 'niedziela_poniedziaลek_wtorek_ลroda_czwartek_piฤ…tek_sobota'.split('_'),
        weekdaysShort : 'nie_pon_wt_ลr_czw_pt_sb'.split('_'),
        weekdaysMin : 'N_Pn_Wt_ลr_Cz_Pt_So'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Dziล o] LT',
            nextDay: '[Jutro o] LT',
            nextWeek: '[W] dddd [o] LT',
            lastDay: '[Wczoraj o] LT',
            lastWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[W zeszลฤ… niedzielฤ o] LT';
                case 3:
                    return '[W zeszลฤ… ลrodฤ o] LT';
                case 6:
                    return '[W zeszลฤ… sobotฤ o] LT';
                default:
                    return '[W zeszลy] dddd [o] LT';
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'za %s',
            past : '%s temu',
            s : 'kilka sekund',
            m : translate,
            mm : translate,
            h : translate,
            hh : translate,
            d : '1 dzieล',
            dd : '%d dni',
            M : 'miesiฤ…c',
            MM : translate,
            y : 'rok',
            yy : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : brazilian portuguese (pt-br)
// author : Caio Ribeiro Pereira : https://github.com/caio-ribeiro-pereira

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('pt-br', {
        months : 'janeiro_fevereiro_marรงo_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro'.split('_'),
        monthsShort : 'jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez'.split('_'),
        weekdays : 'domingo_segunda-feira_terรงa-feira_quarta-feira_quinta-feira_sexta-feira_sรกbado'.split('_'),
        weekdaysShort : 'dom_seg_ter_qua_qui_sex_sรกb'.split('_'),
        weekdaysMin : 'dom_2ยช_3ยช_4ยช_5ยช_6ยช_sรกb'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D [de] MMMM [de] YYYY',
            LLL : 'D [de] MMMM [de] YYYY [ร s] LT',
            LLLL : 'dddd, D [de] MMMM [de] YYYY [ร s] LT'
        },
        calendar : {
            sameDay: '[Hoje ร s] LT',
            nextDay: '[Amanhรฃ ร s] LT',
            nextWeek: 'dddd [ร s] LT',
            lastDay: '[Ontem ร s] LT',
            lastWeek: function () {
                return (this.day() === 0 || this.day() === 6) ?
                    '[รltimo] dddd [ร s] LT' : // Saturday + Sunday
                    '[รltima] dddd [ร s] LT'; // Monday - Friday
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'em %s',
            past : '%s atrรกs',
            s : 'segundos',
            m : 'um minuto',
            mm : '%d minutos',
            h : 'uma hora',
            hh : '%d horas',
            d : 'um dia',
            dd : '%d dias',
            M : 'um mรชs',
            MM : '%d meses',
            y : 'um ano',
            yy : '%d anos'
        },
        ordinalParse: /\d{1,2}ยบ/,
        ordinal : '%dยบ'
    });
}));
// moment.js locale configuration
// locale : portuguese (pt)
// author : Jefferson : https://github.com/jalex79

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('pt', {
        months : 'janeiro_fevereiro_marรงo_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro'.split('_'),
        monthsShort : 'jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez'.split('_'),
        weekdays : 'domingo_segunda-feira_terรงa-feira_quarta-feira_quinta-feira_sexta-feira_sรกbado'.split('_'),
        weekdaysShort : 'dom_seg_ter_qua_qui_sex_sรกb'.split('_'),
        weekdaysMin : 'dom_2ยช_3ยช_4ยช_5ยช_6ยช_sรกb'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D [de] MMMM [de] YYYY',
            LLL : 'D [de] MMMM [de] YYYY LT',
            LLLL : 'dddd, D [de] MMMM [de] YYYY LT'
        },
        calendar : {
            sameDay: '[Hoje ร s] LT',
            nextDay: '[Amanhรฃ ร s] LT',
            nextWeek: 'dddd [ร s] LT',
            lastDay: '[Ontem ร s] LT',
            lastWeek: function () {
                return (this.day() === 0 || this.day() === 6) ?
                    '[รltimo] dddd [ร s] LT' : // Saturday + Sunday
                    '[รltima] dddd [ร s] LT'; // Monday - Friday
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'em %s',
            past : 'hรก %s',
            s : 'segundos',
            m : 'um minuto',
            mm : '%d minutos',
            h : 'uma hora',
            hh : '%d horas',
            d : 'um dia',
            dd : '%d dias',
            M : 'um mรชs',
            MM : '%d meses',
            y : 'um ano',
            yy : '%d anos'
        },
        ordinalParse: /\d{1,2}ยบ/,
        ordinal : '%dยบ',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : romanian (ro)
// author : Vlad Gurdiga : https://github.com/gurdiga
// author : Valentin Agachi : https://github.com/avaly

(function (factory) {
    factory(moment);
}(function (moment) {
    function relativeTimeWithPlural(number, withoutSuffix, key) {
        var format = {
                'mm': 'minute',
                'hh': 'ore',
                'dd': 'zile',
                'MM': 'luni',
                'yy': 'ani'
            },
            separator = ' ';
        if (number % 100 >= 20 || (number >= 100 && number % 100 === 0)) {
            separator = ' de ';
        }

        return number + separator + format[key];
    }

    return moment.defineLocale('ro', {
        months : 'ianuarie_februarie_martie_aprilie_mai_iunie_iulie_august_septembrie_octombrie_noiembrie_decembrie'.split('_'),
        monthsShort : 'ian._febr._mart._apr._mai_iun._iul._aug._sept._oct._nov._dec.'.split('_'),
        weekdays : 'duminicฤ_luni_marศi_miercuri_joi_vineri_sรขmbฤtฤ'.split('_'),
        weekdaysShort : 'Dum_Lun_Mar_Mie_Joi_Vin_Sรขm'.split('_'),
        weekdaysMin : 'Du_Lu_Ma_Mi_Jo_Vi_Sรข'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY H:mm',
            LLLL : 'dddd, D MMMM YYYY H:mm'
        },
        calendar : {
            sameDay: '[azi la] LT',
            nextDay: '[mรขine la] LT',
            nextWeek: 'dddd [la] LT',
            lastDay: '[ieri la] LT',
            lastWeek: '[fosta] dddd [la] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'peste %s',
            past : '%s รฎn urmฤ',
            s : 'cรขteva secunde',
            m : 'un minut',
            mm : relativeTimeWithPlural,
            h : 'o orฤ',
            hh : relativeTimeWithPlural,
            d : 'o zi',
            dd : relativeTimeWithPlural,
            M : 'o lunฤ',
            MM : relativeTimeWithPlural,
            y : 'un an',
            yy : relativeTimeWithPlural
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : russian (ru)
// author : Viktorminator : https://github.com/Viktorminator
// Author : Menelion Elensรบle : https://github.com/Oire

(function (factory) {
    factory(moment);
}(function (moment) {
    function plural(word, num) {
        var forms = word.split('_');
        return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
    }

    function relativeTimeWithPlural(number, withoutSuffix, key) {
        var format = {
            'mm': withoutSuffix ? 'ะผะธะฝััะฐ_ะผะธะฝััั_ะผะธะฝัั' : 'ะผะธะฝััั_ะผะธะฝััั_ะผะธะฝัั',
            'hh': 'ัะฐั_ัะฐัะฐ_ัะฐัะพะฒ',
            'dd': 'ะดะตะฝั_ะดะฝั_ะดะฝะตะน',
            'MM': 'ะผะตััั_ะผะตัััะฐ_ะผะตัััะตะฒ',
            'yy': 'ะณะพะด_ะณะพะดะฐ_ะปะตั'
        };
        if (key === 'm') {
            return withoutSuffix ? 'ะผะธะฝััะฐ' : 'ะผะธะฝััั';
        }
        else {
            return number + ' ' + plural(format[key], +number);
        }
    }

    function monthsCaseReplace(m, format) {
        var months = {
            'nominative': 'ัะฝะฒะฐั€ั_ัะตะฒั€ะฐะปั_ะผะฐั€ั_ะฐะฟั€ะตะปั_ะผะฐะน_ะธัะฝั_ะธัะปั_ะฐะฒะณััั_ัะตะฝััะฑั€ั_ะพะบััะฑั€ั_ะฝะพัะฑั€ั_ะดะตะบะฐะฑั€ั'.split('_'),
            'accusative': 'ัะฝะฒะฐั€ั_ัะตะฒั€ะฐะปั_ะผะฐั€ัะฐ_ะฐะฟั€ะตะปั_ะผะฐั_ะธัะฝั_ะธัะปั_ะฐะฒะณัััะฐ_ัะตะฝััะฑั€ั_ะพะบััะฑั€ั_ะฝะพัะฑั€ั_ะดะตะบะฐะฑั€ั'.split('_')
        },

        nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return months[nounCase][m.month()];
    }

    function monthsShortCaseReplace(m, format) {
        var monthsShort = {
            'nominative': 'ัะฝะฒ_ัะตะฒ_ะผะฐั€ั_ะฐะฟั€_ะผะฐะน_ะธัะฝั_ะธัะปั_ะฐะฒะณ_ัะตะฝ_ะพะบั_ะฝะพั_ะดะตะบ'.split('_'),
            'accusative': 'ัะฝะฒ_ัะตะฒ_ะผะฐั€_ะฐะฟั€_ะผะฐั_ะธัะฝั_ะธัะปั_ะฐะฒะณ_ัะตะฝ_ะพะบั_ะฝะพั_ะดะตะบ'.split('_')
        },

        nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return monthsShort[nounCase][m.month()];
    }

    function weekdaysCaseReplace(m, format) {
        var weekdays = {
            'nominative': 'ะฒะพัะบั€ะตัะตะฝัะต_ะฟะพะฝะตะดะตะปัะฝะธะบ_ะฒัะพั€ะฝะธะบ_ัั€ะตะดะฐ_ัะตัะฒะตั€ะณ_ะฟััะฝะธัะฐ_ััะฑะฑะพัะฐ'.split('_'),
            'accusative': 'ะฒะพัะบั€ะตัะตะฝัะต_ะฟะพะฝะตะดะตะปัะฝะธะบ_ะฒัะพั€ะฝะธะบ_ัั€ะตะดั_ัะตัะฒะตั€ะณ_ะฟััะฝะธัั_ััะฑะฑะพัั'.split('_')
        },

        nounCase = (/\[ ?[ะ’ะฒ] ?(?:ะฟั€ะพัะปัั|ัะปะตะดััััั|ััั)? ?\] ?dddd/).test(format) ?
            'accusative' :
            'nominative';

        return weekdays[nounCase][m.day()];
    }

    return moment.defineLocale('ru', {
        months : monthsCaseReplace,
        monthsShort : monthsShortCaseReplace,
        weekdays : weekdaysCaseReplace,
        weekdaysShort : 'ะฒั_ะฟะฝ_ะฒั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        weekdaysMin : 'ะฒั_ะฟะฝ_ะฒั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        monthsParse : [/^ัะฝะฒ/i, /^ัะตะฒ/i, /^ะผะฐั€/i, /^ะฐะฟั€/i, /^ะผะฐ[ะน|ั]/i, /^ะธัะฝ/i, /^ะธัะป/i, /^ะฐะฒะณ/i, /^ัะตะฝ/i, /^ะพะบั/i, /^ะฝะพั/i, /^ะดะตะบ/i],
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY ะณ.',
            LLL : 'D MMMM YYYY ะณ., LT',
            LLLL : 'dddd, D MMMM YYYY ะณ., LT'
        },
        calendar : {
            sameDay: '[ะกะตะณะพะดะฝั ะฒ] LT',
            nextDay: '[ะ—ะฐะฒัั€ะฐ ะฒ] LT',
            lastDay: '[ะ’ัะตั€ะฐ ะฒ] LT',
            nextWeek: function () {
                return this.day() === 2 ? '[ะ’ะพ] dddd [ะฒ] LT' : '[ะ’] dddd [ะฒ] LT';
            },
            lastWeek: function (now) {
                if (now.week() !== this.week()) {
                    switch (this.day()) {
                    case 0:
                        return '[ะ’ ะฟั€ะพัะปะพะต] dddd [ะฒ] LT';
                    case 1:
                    case 2:
                    case 4:
                        return '[ะ’ ะฟั€ะพัะปัะน] dddd [ะฒ] LT';
                    case 3:
                    case 5:
                    case 6:
                        return '[ะ’ ะฟั€ะพัะปัั] dddd [ะฒ] LT';
                    }
                } else {
                    if (this.day() === 2) {
                        return '[ะ’ะพ] dddd [ะฒ] LT';
                    } else {
                        return '[ะ’] dddd [ะฒ] LT';
                    }
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'ัะตั€ะตะท %s',
            past : '%s ะฝะฐะทะฐะด',
            s : 'ะฝะตัะบะพะปัะบะพ ัะตะบัะฝะด',
            m : relativeTimeWithPlural,
            mm : relativeTimeWithPlural,
            h : 'ัะฐั',
            hh : relativeTimeWithPlural,
            d : 'ะดะตะฝั',
            dd : relativeTimeWithPlural,
            M : 'ะผะตััั',
            MM : relativeTimeWithPlural,
            y : 'ะณะพะด',
            yy : relativeTimeWithPlural
        },

        meridiemParse: /ะฝะพัะธ|ััั€ะฐ|ะดะฝั|ะฒะตัะตั€ะฐ/i,
        isPM : function (input) {
            return /^(ะดะฝั|ะฒะตัะตั€ะฐ)$/.test(input);
        },

        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'ะฝะพัะธ';
            } else if (hour < 12) {
                return 'ััั€ะฐ';
            } else if (hour < 17) {
                return 'ะดะฝั';
            } else {
                return 'ะฒะตัะตั€ะฐ';
            }
        },

        ordinalParse: /\d{1,2}-(ะน|ะณะพ|ั)/,
        ordinal: function (number, period) {
            switch (period) {
            case 'M':
            case 'd':
            case 'DDD':
                return number + '-ะน';
            case 'D':
                return number + '-ะณะพ';
            case 'w':
            case 'W':
                return number + '-ั';
            default:
                return number;
            }
        },

        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : slovak (sk)
// author : Martin Minka : https://github.com/k2s
// based on work of petrbela : https://github.com/petrbela

(function (factory) {
    factory(moment);
}(function (moment) {
    var months = 'januรกr_februรกr_marec_aprรญl_mรกj_jรบn_jรบl_august_september_oktรณber_november_december'.split('_'),
        monthsShort = 'jan_feb_mar_apr_mรกj_jรบn_jรบl_aug_sep_okt_nov_dec'.split('_');

    function plural(n) {
        return (n > 1) && (n < 5);
    }

    function translate(number, withoutSuffix, key, isFuture) {
        var result = number + ' ';
        switch (key) {
        case 's':  // a few seconds / in a few seconds / a few seconds ago
            return (withoutSuffix || isFuture) ? 'pรกr sekรบnd' : 'pรกr sekundami';
        case 'm':  // a minute / in a minute / a minute ago
            return withoutSuffix ? 'minรบta' : (isFuture ? 'minรบtu' : 'minรบtou');
        case 'mm': // 9 minutes / in 9 minutes / 9 minutes ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'minรบty' : 'minรบt');
            } else {
                return result + 'minรบtami';
            }
            break;
        case 'h':  // an hour / in an hour / an hour ago
            return withoutSuffix ? 'hodina' : (isFuture ? 'hodinu' : 'hodinou');
        case 'hh': // 9 hours / in 9 hours / 9 hours ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'hodiny' : 'hodรญn');
            } else {
                return result + 'hodinami';
            }
            break;
        case 'd':  // a day / in a day / a day ago
            return (withoutSuffix || isFuture) ? 'deล' : 'dลom';
        case 'dd': // 9 days / in 9 days / 9 days ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'dni' : 'dnรญ');
            } else {
                return result + 'dลami';
            }
            break;
        case 'M':  // a month / in a month / a month ago
            return (withoutSuffix || isFuture) ? 'mesiac' : 'mesiacom';
        case 'MM': // 9 months / in 9 months / 9 months ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'mesiace' : 'mesiacov');
            } else {
                return result + 'mesiacmi';
            }
            break;
        case 'y':  // a year / in a year / a year ago
            return (withoutSuffix || isFuture) ? 'rok' : 'rokom';
        case 'yy': // 9 years / in 9 years / 9 years ago
            if (withoutSuffix || isFuture) {
                return result + (plural(number) ? 'roky' : 'rokov');
            } else {
                return result + 'rokmi';
            }
            break;
        }
    }

    return moment.defineLocale('sk', {
        months : months,
        monthsShort : monthsShort,
        monthsParse : (function (months, monthsShort) {
            var i, _monthsParse = [];
            for (i = 0; i < 12; i++) {
                // use custom parser to solve problem with July (ฤervenec)
                _monthsParse[i] = new RegExp('^' + months[i] + '$|^' + monthsShort[i] + '$', 'i');
            }
            return _monthsParse;
        }(months, monthsShort)),
        weekdays : 'nedeฤพa_pondelok_utorok_streda_ลกtvrtok_piatok_sobota'.split('_'),
        weekdaysShort : 'ne_po_ut_st_ลกt_pi_so'.split('_'),
        weekdaysMin : 'ne_po_ut_st_ลกt_pi_so'.split('_'),
        longDateFormat : {
            LT: 'H:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd D. MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[dnes o] LT',
            nextDay: '[zajtra o] LT',
            nextWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[v nedeฤพu o] LT';
                case 1:
                case 2:
                    return '[v] dddd [o] LT';
                case 3:
                    return '[v stredu o] LT';
                case 4:
                    return '[vo ลกtvrtok o] LT';
                case 5:
                    return '[v piatok o] LT';
                case 6:
                    return '[v sobotu o] LT';
                }
            },
            lastDay: '[vฤera o] LT',
            lastWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[minulรบ nedeฤพu o] LT';
                case 1:
                case 2:
                    return '[minulรฝ] dddd [o] LT';
                case 3:
                    return '[minulรบ stredu o] LT';
                case 4:
                case 5:
                    return '[minulรฝ] dddd [o] LT';
                case 6:
                    return '[minulรบ sobotu o] LT';
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'za %s',
            past : 'pred %s',
            s : translate,
            m : translate,
            mm : translate,
            h : translate,
            hh : translate,
            d : translate,
            dd : translate,
            M : translate,
            MM : translate,
            y : translate,
            yy : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : slovenian (sl)
// author : Robert Sedovลกek : https://github.com/sedovsek

(function (factory) {
    factory(moment);
}(function (moment) {
    function translate(number, withoutSuffix, key) {
        var result = number + ' ';
        switch (key) {
        case 'm':
            return withoutSuffix ? 'ena minuta' : 'eno minuto';
        case 'mm':
            if (number === 1) {
                result += 'minuta';
            } else if (number === 2) {
                result += 'minuti';
            } else if (number === 3 || number === 4) {
                result += 'minute';
            } else {
                result += 'minut';
            }
            return result;
        case 'h':
            return withoutSuffix ? 'ena ura' : 'eno uro';
        case 'hh':
            if (number === 1) {
                result += 'ura';
            } else if (number === 2) {
                result += 'uri';
            } else if (number === 3 || number === 4) {
                result += 'ure';
            } else {
                result += 'ur';
            }
            return result;
        case 'dd':
            if (number === 1) {
                result += 'dan';
            } else {
                result += 'dni';
            }
            return result;
        case 'MM':
            if (number === 1) {
                result += 'mesec';
            } else if (number === 2) {
                result += 'meseca';
            } else if (number === 3 || number === 4) {
                result += 'mesece';
            } else {
                result += 'mesecev';
            }
            return result;
        case 'yy':
            if (number === 1) {
                result += 'leto';
            } else if (number === 2) {
                result += 'leti';
            } else if (number === 3 || number === 4) {
                result += 'leta';
            } else {
                result += 'let';
            }
            return result;
        }
    }

    return moment.defineLocale('sl', {
        months : 'januar_februar_marec_april_maj_junij_julij_avgust_september_oktober_november_december'.split('_'),
        monthsShort : 'jan._feb._mar._apr._maj._jun._jul._avg._sep._okt._nov._dec.'.split('_'),
        weekdays : 'nedelja_ponedeljek_torek_sreda_ฤetrtek_petek_sobota'.split('_'),
        weekdaysShort : 'ned._pon._tor._sre._ฤet._pet._sob.'.split('_'),
        weekdaysMin : 'ne_po_to_sr_ฤe_pe_so'.split('_'),
        longDateFormat : {
            LT : 'H:mm',
            LTS : 'LT:ss',
            L : 'DD. MM. YYYY',
            LL : 'D. MMMM YYYY',
            LLL : 'D. MMMM YYYY LT',
            LLLL : 'dddd, D. MMMM YYYY LT'
        },
        calendar : {
            sameDay  : '[danes ob] LT',
            nextDay  : '[jutri ob] LT',

            nextWeek : function () {
                switch (this.day()) {
                case 0:
                    return '[v] [nedeljo] [ob] LT';
                case 3:
                    return '[v] [sredo] [ob] LT';
                case 6:
                    return '[v] [soboto] [ob] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[v] dddd [ob] LT';
                }
            },
            lastDay  : '[vฤeraj ob] LT',
            lastWeek : function () {
                switch (this.day()) {
                case 0:
                case 3:
                case 6:
                    return '[prejลกnja] dddd [ob] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[prejลกnji] dddd [ob] LT';
                }
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ฤez %s',
            past   : '%s nazaj',
            s      : 'nekaj sekund',
            m      : translate,
            mm     : translate,
            h      : translate,
            hh     : translate,
            d      : 'en dan',
            dd     : translate,
            M      : 'en mesec',
            MM     : translate,
            y      : 'eno leto',
            yy     : translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Albanian (sq)
// author : Flakรซrim Ismani : https://github.com/flakerimi
// author: Menelion Elensรบle: https://github.com/Oire (tests)
// author : Oerd Cukalla : https://github.com/oerd (fixes)

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('sq', {
        months : 'Janar_Shkurt_Mars_Prill_Maj_Qershor_Korrik_Gusht_Shtator_Tetor_Nรซntor_Dhjetor'.split('_'),
        monthsShort : 'Jan_Shk_Mar_Pri_Maj_Qer_Kor_Gus_Sht_Tet_Nรซn_Dhj'.split('_'),
        weekdays : 'E Diel_E Hรซnรซ_E Martรซ_E Mรซrkurรซ_E Enjte_E Premte_E Shtunรซ'.split('_'),
        weekdaysShort : 'Die_Hรซn_Mar_Mรซr_Enj_Pre_Sht'.split('_'),
        weekdaysMin : 'D_H_Ma_Mรซ_E_P_Sh'.split('_'),
        meridiemParse: /PD|MD/,
        isPM: function (input) {
            return input.charAt(0) === 'M';
        },
        meridiem : function (hours, minutes, isLower) {
            return hours < 12 ? 'PD' : 'MD';
        },
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[Sot nรซ] LT',
            nextDay : '[Nesรซr nรซ] LT',
            nextWeek : 'dddd [nรซ] LT',
            lastDay : '[Dje nรซ] LT',
            lastWeek : 'dddd [e kaluar nรซ] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'nรซ %s',
            past : '%s mรซ parรซ',
            s : 'disa sekonda',
            m : 'njรซ minutรซ',
            mm : '%d minuta',
            h : 'njรซ orรซ',
            hh : '%d orรซ',
            d : 'njรซ ditรซ',
            dd : '%d ditรซ',
            M : 'njรซ muaj',
            MM : '%d muaj',
            y : 'njรซ vit',
            yy : '%d vite'
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Serbian-cyrillic (sr-cyrl)
// author : Milan Janaฤkoviฤ<milanjanackovic@gmail.com> : https://github.com/milan-j

(function (factory) {
    factory(moment);
}(function (moment) {
    var translator = {
        words: { //Different grammatical cases
            m: ['ัะตะดะฐะฝ ะผะธะฝัั', 'ัะตะดะฝะต ะผะธะฝััะต'],
            mm: ['ะผะธะฝัั', 'ะผะธะฝััะต', 'ะผะธะฝััะฐ'],
            h: ['ัะตะดะฐะฝ ัะฐั', 'ัะตะดะฝะพะณ ัะฐัะฐ'],
            hh: ['ัะฐั', 'ัะฐัะฐ', 'ัะฐัะธ'],
            dd: ['ะดะฐะฝ', 'ะดะฐะฝะฐ', 'ะดะฐะฝะฐ'],
            MM: ['ะผะตัะตั', 'ะผะตัะตัะฐ', 'ะผะตัะตัะธ'],
            yy: ['ะณะพะดะธะฝะฐ', 'ะณะพะดะธะฝะต', 'ะณะพะดะธะฝะฐ']
        },
        correctGrammaticalCase: function (number, wordKey) {
            return number === 1 ? wordKey[0] : (number >= 2 && number <= 4 ? wordKey[1] : wordKey[2]);
        },
        translate: function (number, withoutSuffix, key) {
            var wordKey = translator.words[key];
            if (key.length === 1) {
                return withoutSuffix ? wordKey[0] : wordKey[1];
            } else {
                return number + ' ' + translator.correctGrammaticalCase(number, wordKey);
            }
        }
    };

    return moment.defineLocale('sr-cyrl', {
        months: ['ัะฐะฝัะฐั€', 'ัะตะฑั€ัะฐั€', 'ะผะฐั€ั', 'ะฐะฟั€ะธะป', 'ะผะฐั', 'ััะฝ', 'ััะป', 'ะฐะฒะณััั', 'ัะตะฟัะตะผะฑะฐั€', 'ะพะบัะพะฑะฐั€', 'ะฝะพะฒะตะผะฑะฐั€', 'ะดะตัะตะผะฑะฐั€'],
        monthsShort: ['ัะฐะฝ.', 'ัะตะฑ.', 'ะผะฐั€.', 'ะฐะฟั€.', 'ะผะฐั', 'ััะฝ', 'ััะป', 'ะฐะฒะณ.', 'ัะตะฟ.', 'ะพะบั.', 'ะฝะพะฒ.', 'ะดะตั.'],
        weekdays: ['ะฝะตะดะตัะฐ', 'ะฟะพะฝะตะดะตัะฐะบ', 'ััะพั€ะฐะบ', 'ัั€ะตะดะฐ', 'ัะตัะฒั€ัะฐะบ', 'ะฟะตัะฐะบ', 'ััะฑะพัะฐ'],
        weekdaysShort: ['ะฝะตะด.', 'ะฟะพะฝ.', 'ััะพ.', 'ัั€ะต.', 'ัะตั.', 'ะฟะตั.', 'ััะฑ.'],
        weekdaysMin: ['ะฝะต', 'ะฟะพ', 'ัั', 'ัั€', 'ัะต', 'ะฟะต', 'ัั'],
        longDateFormat: {
            LT: 'H:mm',
            LTS : 'LT:ss',
            L: 'DD. MM. YYYY',
            LL: 'D. MMMM YYYY',
            LLL: 'D. MMMM YYYY LT',
            LLLL: 'dddd, D. MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[ะดะฐะฝะฐั ั] LT',
            nextDay: '[ัััั€ะฐ ั] LT',

            nextWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[ั] [ะฝะตะดะตัั] [ั] LT';
                case 3:
                    return '[ั] [ัั€ะตะดั] [ั] LT';
                case 6:
                    return '[ั] [ััะฑะพัั] [ั] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[ั] dddd [ั] LT';
                }
            },
            lastDay  : '[ัััะต ั] LT',
            lastWeek : function () {
                var lastWeekDays = [
                    '[ะฟั€ะพัะปะต] [ะฝะตะดะตัะต] [ั] LT',
                    '[ะฟั€ะพัะปะพะณ] [ะฟะพะฝะตะดะตัะบะฐ] [ั] LT',
                    '[ะฟั€ะพัะปะพะณ] [ััะพั€ะบะฐ] [ั] LT',
                    '[ะฟั€ะพัะปะต] [ัั€ะตะดะต] [ั] LT',
                    '[ะฟั€ะพัะปะพะณ] [ัะตัะฒั€ัะบะฐ] [ั] LT',
                    '[ะฟั€ะพัะปะพะณ] [ะฟะตัะบะฐ] [ั] LT',
                    '[ะฟั€ะพัะปะต] [ััะฑะพัะต] [ั] LT'
                ];
                return lastWeekDays[this.day()];
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ะทะฐ %s',
            past   : 'ะฟั€ะต %s',
            s      : 'ะฝะตะบะพะปะธะบะพ ัะตะบัะฝะดะธ',
            m      : translator.translate,
            mm     : translator.translate,
            h      : translator.translate,
            hh     : translator.translate,
            d      : 'ะดะฐะฝ',
            dd     : translator.translate,
            M      : 'ะผะตัะตั',
            MM     : translator.translate,
            y      : 'ะณะพะดะธะฝั',
            yy     : translator.translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Serbian-latin (sr)
// author : Milan Janaฤkoviฤ<milanjanackovic@gmail.com> : https://github.com/milan-j

(function (factory) {
    factory(moment);
}(function (moment) {
    var translator = {
        words: { //Different grammatical cases
            m: ['jedan minut', 'jedne minute'],
            mm: ['minut', 'minute', 'minuta'],
            h: ['jedan sat', 'jednog sata'],
            hh: ['sat', 'sata', 'sati'],
            dd: ['dan', 'dana', 'dana'],
            MM: ['mesec', 'meseca', 'meseci'],
            yy: ['godina', 'godine', 'godina']
        },
        correctGrammaticalCase: function (number, wordKey) {
            return number === 1 ? wordKey[0] : (number >= 2 && number <= 4 ? wordKey[1] : wordKey[2]);
        },
        translate: function (number, withoutSuffix, key) {
            var wordKey = translator.words[key];
            if (key.length === 1) {
                return withoutSuffix ? wordKey[0] : wordKey[1];
            } else {
                return number + ' ' + translator.correctGrammaticalCase(number, wordKey);
            }
        }
    };

    return moment.defineLocale('sr', {
        months: ['januar', 'februar', 'mart', 'april', 'maj', 'jun', 'jul', 'avgust', 'septembar', 'oktobar', 'novembar', 'decembar'],
        monthsShort: ['jan.', 'feb.', 'mar.', 'apr.', 'maj', 'jun', 'jul', 'avg.', 'sep.', 'okt.', 'nov.', 'dec.'],
        weekdays: ['nedelja', 'ponedeljak', 'utorak', 'sreda', 'ฤetvrtak', 'petak', 'subota'],
        weekdaysShort: ['ned.', 'pon.', 'uto.', 'sre.', 'ฤet.', 'pet.', 'sub.'],
        weekdaysMin: ['ne', 'po', 'ut', 'sr', 'ฤe', 'pe', 'su'],
        longDateFormat: {
            LT: 'H:mm',
            LTS : 'LT:ss',
            L: 'DD. MM. YYYY',
            LL: 'D. MMMM YYYY',
            LLL: 'D. MMMM YYYY LT',
            LLLL: 'dddd, D. MMMM YYYY LT'
        },
        calendar: {
            sameDay: '[danas u] LT',
            nextDay: '[sutra u] LT',

            nextWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[u] [nedelju] [u] LT';
                case 3:
                    return '[u] [sredu] [u] LT';
                case 6:
                    return '[u] [subotu] [u] LT';
                case 1:
                case 2:
                case 4:
                case 5:
                    return '[u] dddd [u] LT';
                }
            },
            lastDay  : '[juฤe u] LT',
            lastWeek : function () {
                var lastWeekDays = [
                    '[proลกle] [nedelje] [u] LT',
                    '[proลกlog] [ponedeljka] [u] LT',
                    '[proลกlog] [utorka] [u] LT',
                    '[proลกle] [srede] [u] LT',
                    '[proลกlog] [ฤetvrtka] [u] LT',
                    '[proลกlog] [petka] [u] LT',
                    '[proลกle] [subote] [u] LT'
                ];
                return lastWeekDays[this.day()];
            },
            sameElse : 'L'
        },
        relativeTime : {
            future : 'za %s',
            past   : 'pre %s',
            s      : 'nekoliko sekundi',
            m      : translator.translate,
            mm     : translator.translate,
            h      : translator.translate,
            hh     : translator.translate,
            d      : 'dan',
            dd     : translator.translate,
            M      : 'mesec',
            MM     : translator.translate,
            y      : 'godinu',
            yy     : translator.translate
        },
        ordinalParse: /\d{1,2}\./,
        ordinal : '%d.',
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : swedish (sv)
// author : Jens Alm : https://github.com/ulmus

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('sv', {
        months : 'januari_februari_mars_april_maj_juni_juli_augusti_september_oktober_november_december'.split('_'),
        monthsShort : 'jan_feb_mar_apr_maj_jun_jul_aug_sep_okt_nov_dec'.split('_'),
        weekdays : 'sรถndag_mรฅndag_tisdag_onsdag_torsdag_fredag_lรถrdag'.split('_'),
        weekdaysShort : 'sรถn_mรฅn_tis_ons_tor_fre_lรถr'.split('_'),
        weekdaysMin : 'sรถ_mรฅ_ti_on_to_fr_lรถ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'YYYY-MM-DD',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[Idag] LT',
            nextDay: '[Imorgon] LT',
            lastDay: '[Igรฅr] LT',
            nextWeek: 'dddd LT',
            lastWeek: '[Fรถrra] dddd[en] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'om %s',
            past : 'fรถr %s sedan',
            s : 'nรฅgra sekunder',
            m : 'en minut',
            mm : '%d minuter',
            h : 'en timme',
            hh : '%d timmar',
            d : 'en dag',
            dd : '%d dagar',
            M : 'en mรฅnad',
            MM : '%d mรฅnader',
            y : 'ett รฅr',
            yy : '%d รฅr'
        },
        ordinalParse: /\d{1,2}(e|a)/,
        ordinal : function (number) {
            var b = number % 10,
                output = (~~(number % 100 / 10) === 1) ? 'e' :
                (b === 1) ? 'a' :
                (b === 2) ? 'a' :
                (b === 3) ? 'e' : 'e';
            return number + output;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : tamil (ta)
// author : Arjunkumar Krishnamoorthy : https://github.com/tk120404

(function (factory) {
    factory(moment);
}(function (moment) {
    /*var symbolMap = {
            '1': 'เฏง',
            '2': 'เฏจ',
            '3': 'เฏฉ',
            '4': 'เฏช',
            '5': 'เฏซ',
            '6': 'เฏฌ',
            '7': 'เฏญ',
            '8': 'เฏฎ',
            '9': 'เฏฏ',
            '0': 'เฏฆ'
        },
        numberMap = {
            'เฏง': '1',
            'เฏจ': '2',
            'เฏฉ': '3',
            'เฏช': '4',
            'เฏซ': '5',
            'เฏฌ': '6',
            'เฏญ': '7',
            'เฏฎ': '8',
            'เฏฏ': '9',
            'เฏฆ': '0'
        }; */

    return moment.defineLocale('ta', {
        months : 'เฎเฎฉเฎตเฎฐเฎฟ_เฎชเฎฟเฎชเฏเฎฐเฎตเฎฐเฎฟ_เฎฎเฎพเฎฐเฏเฎเฏ_เฎเฎชเฏเฎฐเฎฒเฏ_เฎฎเฏ_เฎเฏเฎฉเฏ_เฎเฏเฎฒเฏ_เฎเฎ•เฎธเฏเฎเฏ_เฎเฏเฎชเฏเฎเฏเฎฎเฏเฎชเฎฐเฏ_เฎ…เฎ•เฏเฎเฏเฎพเฎชเฎฐเฏ_เฎจเฎตเฎฎเฏเฎชเฎฐเฏ_เฎเฎฟเฎเฎฎเฏเฎชเฎฐเฏ'.split('_'),
        monthsShort : 'เฎเฎฉเฎตเฎฐเฎฟ_เฎชเฎฟเฎชเฏเฎฐเฎตเฎฐเฎฟ_เฎฎเฎพเฎฐเฏเฎเฏ_เฎเฎชเฏเฎฐเฎฒเฏ_เฎฎเฏ_เฎเฏเฎฉเฏ_เฎเฏเฎฒเฏ_เฎเฎ•เฎธเฏเฎเฏ_เฎเฏเฎชเฏเฎเฏเฎฎเฏเฎชเฎฐเฏ_เฎ…เฎ•เฏเฎเฏเฎพเฎชเฎฐเฏ_เฎจเฎตเฎฎเฏเฎชเฎฐเฏ_เฎเฎฟเฎเฎฎเฏเฎชเฎฐเฏ'.split('_'),
        weekdays : 'เฎเฎพเฎฏเฎฟเฎฑเฏเฎฑเฏเฎ•เฏเฎ•เฎฟเฎดเฎฎเฏ_เฎคเฎฟเฎเฏเฎ•เฎเฏเฎ•เฎฟเฎดเฎฎเฏ_เฎเฏเฎตเฏเฎตเฎพเฎฏเฏเฎ•เฎฟเฎดเฎฎเฏ_เฎชเฏเฎคเฎฉเฏเฎ•เฎฟเฎดเฎฎเฏ_เฎตเฎฟเฎฏเฎพเฎดเฎ•เฏเฎ•เฎฟเฎดเฎฎเฏ_เฎตเฏเฎณเฏเฎณเฎฟเฎ•เฏเฎ•เฎฟเฎดเฎฎเฏ_เฎเฎฉเฎฟเฎ•เฏเฎ•เฎฟเฎดเฎฎเฏ'.split('_'),
        weekdaysShort : 'เฎเฎพเฎฏเฎฟเฎฑเฏ_เฎคเฎฟเฎเฏเฎ•เฎณเฏ_เฎเฏเฎตเฏเฎตเฎพเฎฏเฏ_เฎชเฏเฎคเฎฉเฏ_เฎตเฎฟเฎฏเฎพเฎดเฎฉเฏ_เฎตเฏเฎณเฏเฎณเฎฟ_เฎเฎฉเฎฟ'.split('_'),
        weekdaysMin : 'เฎเฎพ_เฎคเฎฟ_เฎเฏ_เฎชเฏ_เฎตเฎฟ_เฎตเฏ_เฎ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY, LT',
            LLLL : 'dddd, D MMMM YYYY, LT'
        },
        calendar : {
            sameDay : '[เฎเฎฉเฏเฎฑเฏ] LT',
            nextDay : '[เฎจเฎพเฎณเฏ] LT',
            nextWeek : 'dddd, LT',
            lastDay : '[เฎจเฏเฎฑเฏเฎฑเฏ] LT',
            lastWeek : '[เฎ•เฎเฎจเฏเฎค เฎตเฎพเฎฐเฎฎเฏ] dddd, LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s เฎเฎฒเฏ',
            past : '%s เฎฎเฏเฎฉเฏ',
            s : 'เฎ’เฎฐเฏ เฎเฎฟเฎฒ เฎตเฎฟเฎจเฎพเฎเฎฟเฎ•เฎณเฏ',
            m : 'เฎ’เฎฐเฏ เฎจเฎฟเฎฎเฎฟเฎเฎฎเฏ',
            mm : '%d เฎจเฎฟเฎฎเฎฟเฎเฎเฏเฎ•เฎณเฏ',
            h : 'เฎ’เฎฐเฏ เฎฎเฎฃเฎฟ เฎจเฏเฎฐเฎฎเฏ',
            hh : '%d เฎฎเฎฃเฎฟ เฎจเฏเฎฐเฎฎเฏ',
            d : 'เฎ’เฎฐเฏ เฎจเฎพเฎณเฏ',
            dd : '%d เฎจเฎพเฎเฏเฎ•เฎณเฏ',
            M : 'เฎ’เฎฐเฏ เฎฎเฎพเฎคเฎฎเฏ',
            MM : '%d เฎฎเฎพเฎคเฎเฏเฎ•เฎณเฏ',
            y : 'เฎ’เฎฐเฏ เฎตเฎฐเฏเฎเฎฎเฏ',
            yy : '%d เฎเฎฃเฏเฎเฏเฎ•เฎณเฏ'
        },
/*        preparse: function (string) {
            return string.replace(/[เฏงเฏจเฏฉเฏชเฏซเฏฌเฏญเฏฎเฏฏเฏฆ]/g, function (match) {
                return numberMap[match];
            });
        },
        postformat: function (string) {
            return string.replace(/\d/g, function (match) {
                return symbolMap[match];
            });
        },*/
        ordinalParse: /\d{1,2}เฎตเฎคเฏ/,
        ordinal : function (number) {
            return number + 'เฎตเฎคเฏ';
        },


        // refer http://ta.wikipedia.org/s/1er1
        meridiemParse: /เฎฏเฎพเฎฎเฎฎเฏ|เฎตเฏเฎ•เฎฑเฏ|เฎ•เฎพเฎฒเฏ|เฎจเฎฃเฏเฎชเฎ•เฎฒเฏ|เฎเฎฑเฏเฎชเฎพเฎเฏ|เฎฎเฎพเฎฒเฏ/,
        meridiem : function (hour, minute, isLower) {
            if (hour < 2) {
                return ' เฎฏเฎพเฎฎเฎฎเฏ';
            } else if (hour < 6) {
                return ' เฎตเฏเฎ•เฎฑเฏ';  // เฎตเฏเฎ•เฎฑเฏ
            } else if (hour < 10) {
                return ' เฎ•เฎพเฎฒเฏ'; // เฎ•เฎพเฎฒเฏ
            } else if (hour < 14) {
                return ' เฎจเฎฃเฏเฎชเฎ•เฎฒเฏ'; // เฎจเฎฃเฏเฎชเฎ•เฎฒเฏ
            } else if (hour < 18) {
                return ' เฎเฎฑเฏเฎชเฎพเฎเฏ'; // เฎเฎฑเฏเฎชเฎพเฎเฏ
            } else if (hour < 22) {
                return ' เฎฎเฎพเฎฒเฏ'; // เฎฎเฎพเฎฒเฏ
            } else {
                return ' เฎฏเฎพเฎฎเฎฎเฏ';
            }
        },
        meridiemHour : function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'เฎฏเฎพเฎฎเฎฎเฏ') {
                return hour < 2 ? hour : hour + 12;
            } else if (meridiem === 'เฎตเฏเฎ•เฎฑเฏ' || meridiem === 'เฎ•เฎพเฎฒเฏ') {
                return hour;
            } else if (meridiem === 'เฎจเฎฃเฏเฎชเฎ•เฎฒเฏ') {
                return hour >= 10 ? hour : hour + 12;
            } else {
                return hour + 12;
            }
        },
        week : {
            dow : 0, // Sunday is the first day of the week.
            doy : 6  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : thai (th)
// author : Kridsada Thanabulpong : https://github.com/sirn

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('th', {
        months : 'เธกเธเธฃเธฒเธเธก_เธเธธเธกเธ เธฒเธเธฑเธเธเน_เธกเธตเธเธฒเธเธก_เน€เธกเธฉเธฒเธขเธ_เธเธคเธฉเธ เธฒเธเธก_เธกเธดเธ–เธธเธเธฒเธขเธ_เธเธฃเธเธเธฒเธเธก_เธชเธดเธเธซเธฒเธเธก_เธเธฑเธเธขเธฒเธขเธ_เธ•เธธเธฅเธฒเธเธก_เธเธคเธจเธเธดเธเธฒเธขเธ_เธเธฑเธเธงเธฒเธเธก'.split('_'),
        monthsShort : 'เธกเธเธฃเธฒ_เธเธธเธกเธ เธฒ_เธกเธตเธเธฒ_เน€เธกเธฉเธฒ_เธเธคเธฉเธ เธฒ_เธกเธดเธ–เธธเธเธฒ_เธเธฃเธเธเธฒ_เธชเธดเธเธซเธฒ_เธเธฑเธเธขเธฒ_เธ•เธธเธฅเธฒ_เธเธคเธจเธเธดเธเธฒ_เธเธฑเธเธงเธฒ'.split('_'),
        weekdays : 'เธญเธฒเธ—เธดเธ•เธขเน_เธเธฑเธเธ—เธฃเน_เธญเธฑเธเธเธฒเธฃ_เธเธธเธ_เธเธคเธซเธฑเธชเธเธ”เธต_เธจเธธเธเธฃเน_เน€เธชเธฒเธฃเน'.split('_'),
        weekdaysShort : 'เธญเธฒเธ—เธดเธ•เธขเน_เธเธฑเธเธ—เธฃเน_เธญเธฑเธเธเธฒเธฃ_เธเธธเธ_เธเธคเธซเธฑเธช_เธจเธธเธเธฃเน_เน€เธชเธฒเธฃเน'.split('_'), // yes, three characters difference
        weekdaysMin : 'เธญเธฒ._เธ._เธญ._เธ._เธเธค._เธจ._เธช.'.split('_'),
        longDateFormat : {
            LT : 'H เธเธฒเธฌเธดเธเธฒ m เธเธฒเธ—เธต',
            LTS : 'LT s เธงเธดเธเธฒเธ—เธต',
            L : 'YYYY/MM/DD',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY เน€เธงเธฅเธฒ LT',
            LLLL : 'เธงเธฑเธddddเธ—เธตเน D MMMM YYYY เน€เธงเธฅเธฒ LT'
        },
        meridiemParse: /เธเนเธญเธเน€เธ—เธตเนเธขเธ|เธซเธฅเธฑเธเน€เธ—เธตเนเธขเธ/,
        isPM: function (input) {
            return input === 'เธซเธฅเธฑเธเน€เธ—เธตเนเธขเธ';
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 12) {
                return 'เธเนเธญเธเน€เธ—เธตเนเธขเธ';
            } else {
                return 'เธซเธฅเธฑเธเน€เธ—เธตเนเธขเธ';
            }
        },
        calendar : {
            sameDay : '[เธงเธฑเธเธเธตเน เน€เธงเธฅเธฒ] LT',
            nextDay : '[เธเธฃเธธเนเธเธเธตเน เน€เธงเธฅเธฒ] LT',
            nextWeek : 'dddd[เธซเธเนเธฒ เน€เธงเธฅเธฒ] LT',
            lastDay : '[เน€เธกเธทเนเธญเธงเธฒเธเธเธตเน เน€เธงเธฅเธฒ] LT',
            lastWeek : '[เธงเธฑเธ]dddd[เธ—เธตเนเนเธฅเนเธง เน€เธงเธฅเธฒ] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'เธญเธตเธ %s',
            past : '%sเธ—เธตเนเนเธฅเนเธง',
            s : 'เนเธกเนเธเธตเนเธงเธดเธเธฒเธ—เธต',
            m : '1 เธเธฒเธ—เธต',
            mm : '%d เธเธฒเธ—เธต',
            h : '1 เธเธฑเนเธงเนเธกเธ',
            hh : '%d เธเธฑเนเธงเนเธกเธ',
            d : '1 เธงเธฑเธ',
            dd : '%d เธงเธฑเธ',
            M : '1 เน€เธ”เธทเธญเธ',
            MM : '%d เน€เธ”เธทเธญเธ',
            y : '1 เธเธต',
            yy : '%d เธเธต'
        }
    });
}));
// moment.js locale configuration
// locale : Tagalog/Filipino (tl-ph)
// author : Dan Hagman

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('tl-ph', {
        months : 'Enero_Pebrero_Marso_Abril_Mayo_Hunyo_Hulyo_Agosto_Setyembre_Oktubre_Nobyembre_Disyembre'.split('_'),
        monthsShort : 'Ene_Peb_Mar_Abr_May_Hun_Hul_Ago_Set_Okt_Nob_Dis'.split('_'),
        weekdays : 'Linggo_Lunes_Martes_Miyerkules_Huwebes_Biyernes_Sabado'.split('_'),
        weekdaysShort : 'Lin_Lun_Mar_Miy_Huw_Biy_Sab'.split('_'),
        weekdaysMin : 'Li_Lu_Ma_Mi_Hu_Bi_Sab'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'MM/D/YYYY',
            LL : 'MMMM D, YYYY',
            LLL : 'MMMM D, YYYY LT',
            LLLL : 'dddd, MMMM DD, YYYY LT'
        },
        calendar : {
            sameDay: '[Ngayon sa] LT',
            nextDay: '[Bukas sa] LT',
            nextWeek: 'dddd [sa] LT',
            lastDay: '[Kahapon sa] LT',
            lastWeek: 'dddd [huling linggo] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'sa loob ng %s',
            past : '%s ang nakalipas',
            s : 'ilang segundo',
            m : 'isang minuto',
            mm : '%d minuto',
            h : 'isang oras',
            hh : '%d oras',
            d : 'isang araw',
            dd : '%d araw',
            M : 'isang buwan',
            MM : '%d buwan',
            y : 'isang taon',
            yy : '%d taon'
        },
        ordinalParse: /\d{1,2}/,
        ordinal : function (number) {
            return number;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : turkish (tr)
// authors : Erhan Gundogan : https://github.com/erhangundogan,
//           Burak Yiฤit Kaya: https://github.com/BYK

(function (factory) {
    factory(moment);
}(function (moment) {
    var suffixes = {
        1: '\'inci',
        5: '\'inci',
        8: '\'inci',
        70: '\'inci',
        80: '\'inci',

        2: '\'nci',
        7: '\'nci',
        20: '\'nci',
        50: '\'nci',

        3: '\'รผncรผ',
        4: '\'รผncรผ',
        100: '\'รผncรผ',

        6: '\'ncฤฑ',

        9: '\'uncu',
        10: '\'uncu',
        30: '\'uncu',

        60: '\'ฤฑncฤฑ',
        90: '\'ฤฑncฤฑ'
    };

    return moment.defineLocale('tr', {
        months : 'Ocak_ลubat_Mart_Nisan_Mayฤฑs_Haziran_Temmuz_Aฤustos_Eylรผl_Ekim_Kasฤฑm_Aralฤฑk'.split('_'),
        monthsShort : 'Oca_ลub_Mar_Nis_May_Haz_Tem_Aฤu_Eyl_Eki_Kas_Ara'.split('_'),
        weekdays : 'Pazar_Pazartesi_Salฤฑ_รarลamba_Perลembe_Cuma_Cumartesi'.split('_'),
        weekdaysShort : 'Paz_Pts_Sal_รar_Per_Cum_Cts'.split('_'),
        weekdaysMin : 'Pz_Pt_Sa_รa_Pe_Cu_Ct'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd, D MMMM YYYY LT'
        },
        calendar : {
            sameDay : '[bugรผn saat] LT',
            nextDay : '[yarฤฑn saat] LT',
            nextWeek : '[haftaya] dddd [saat] LT',
            lastDay : '[dรผn] LT',
            lastWeek : '[geรงen hafta] dddd [saat] LT',
            sameElse : 'L'
        },
        relativeTime : {
            future : '%s sonra',
            past : '%s รถnce',
            s : 'birkaรง saniye',
            m : 'bir dakika',
            mm : '%d dakika',
            h : 'bir saat',
            hh : '%d saat',
            d : 'bir gรผn',
            dd : '%d gรผn',
            M : 'bir ay',
            MM : '%d ay',
            y : 'bir yฤฑl',
            yy : '%d yฤฑl'
        },
        ordinalParse: /\d{1,2}'(inci|nci|รผncรผ|ncฤฑ|uncu|ฤฑncฤฑ)/,
        ordinal : function (number) {
            if (number === 0) {  // special case for zero
                return number + '\'ฤฑncฤฑ';
            }
            var a = number % 10,
                b = number % 100 - a,
                c = number >= 100 ? 100 : null;

            return number + (suffixes[a] || suffixes[b] || suffixes[c]);
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Morocco Central Atlas Tamaziษฃt in Latin (tzm-latn)
// author : Abdel Said : https://github.com/abdelsaid

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('tzm-latn', {
        months : 'innayr_brหคayrหค_marหคsหค_ibrir_mayyw_ywnyw_ywlywz_ษฃwลกt_ลกwtanbir_ktหคwbrหค_nwwanbir_dwjnbir'.split('_'),
        monthsShort : 'innayr_brหคayrหค_marหคsหค_ibrir_mayyw_ywnyw_ywlywz_ษฃwลกt_ลกwtanbir_ktหคwbrหค_nwwanbir_dwjnbir'.split('_'),
        weekdays : 'asamas_aynas_asinas_akras_akwas_asimwas_asiแธyas'.split('_'),
        weekdaysShort : 'asamas_aynas_asinas_akras_akwas_asimwas_asiแธyas'.split('_'),
        weekdaysMin : 'asamas_aynas_asinas_akras_akwas_asimwas_asiแธyas'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[asdkh g] LT',
            nextDay: '[aska g] LT',
            nextWeek: 'dddd [g] LT',
            lastDay: '[assant g] LT',
            lastWeek: 'dddd [g] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'dadkh s yan %s',
            past : 'yan %s',
            s : 'imik',
            m : 'minuแธ',
            mm : '%d minuแธ',
            h : 'saษa',
            hh : '%d tassaษin',
            d : 'ass',
            dd : '%d ossan',
            M : 'ayowr',
            MM : '%d iyyirn',
            y : 'asgas',
            yy : '%d isgasn'
        },
        week : {
            dow : 6, // Saturday is the first day of the week.
            doy : 12  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : Morocco Central Atlas Tamaziษฃt (tzm)
// author : Abdel Said : https://github.com/abdelsaid

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('tzm', {
        months : 'โตโตโตโดฐโตขโต”_โดฑโต•โดฐโตขโต•_โตโดฐโต•โต_โตโดฑโต”โตโต”_โตโดฐโตขโตขโต“_โตขโต“โตโตขโต“_โตขโต“โตโตขโต“โตฃ_โต–โต“โตโต_โตโต“โตโดฐโตโดฑโตโต”_โดฝโตโต“โดฑโต•_โตโต“โตกโดฐโตโดฑโตโต”_โดทโต“โตโตโดฑโตโต”'.split('_'),
        monthsShort : 'โตโตโตโดฐโตขโต”_โดฑโต•โดฐโตขโต•_โตโดฐโต•โต_โตโดฑโต”โตโต”_โตโดฐโตขโตขโต“_โตขโต“โตโตขโต“_โตขโต“โตโตขโต“โตฃ_โต–โต“โตโต_โตโต“โตโดฐโตโดฑโตโต”_โดฝโตโต“โดฑโต•_โตโต“โตกโดฐโตโดฑโตโต”_โดทโต“โตโตโดฑโตโต”'.split('_'),
        weekdays : 'โดฐโตโดฐโตโดฐโต_โดฐโตขโตโดฐโต_โดฐโตโตโตโดฐโต_โดฐโดฝโต”โดฐโต_โดฐโดฝโตกโดฐโต_โดฐโตโตโตโตกโดฐโต_โดฐโตโตโดนโตขโดฐโต'.split('_'),
        weekdaysShort : 'โดฐโตโดฐโตโดฐโต_โดฐโตขโตโดฐโต_โดฐโตโตโตโดฐโต_โดฐโดฝโต”โดฐโต_โดฐโดฝโตกโดฐโต_โดฐโตโตโตโตกโดฐโต_โดฐโตโตโดนโตขโดฐโต'.split('_'),
        weekdaysMin : 'โดฐโตโดฐโตโดฐโต_โดฐโตขโตโดฐโต_โดฐโตโตโตโดฐโต_โดฐโดฝโต”โดฐโต_โดฐโดฝโตกโดฐโต_โดฐโตโตโตโตกโดฐโต_โดฐโตโตโดนโตขโดฐโต'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS: 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'dddd D MMMM YYYY LT'
        },
        calendar : {
            sameDay: '[โดฐโตโดทโต… โดด] LT',
            nextDay: '[โดฐโตโดฝโดฐ โดด] LT',
            nextWeek: 'dddd [โดด] LT',
            lastDay: '[โดฐโตโดฐโตโต โดด] LT',
            lastWeek: 'dddd [โดด] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'โดทโดฐโดทโต… โต โตขโดฐโต %s',
            past : 'โตขโดฐโต %s',
            s : 'โตโตโตโดฝ',
            m : 'โตโตโตโต“โดบ',
            mm : '%d โตโตโตโต“โดบ',
            h : 'โตโดฐโตโดฐ',
            hh : '%d โตโดฐโตโตโดฐโตโตโต',
            d : 'โดฐโตโต',
            dd : '%d oโตโตโดฐโต',
            M : 'โดฐโตขoโต“โต”',
            MM : '%d โตโตขโตขโตโต”โต',
            y : 'โดฐโตโดณโดฐโต',
            yy : '%d โตโตโดณโดฐโตโต'
        },
        week : {
            dow : 6, // Saturday is the first day of the week.
            doy : 12  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : ukrainian (uk)
// author : zemlanin : https://github.com/zemlanin
// Author : Menelion Elensรบle : https://github.com/Oire

(function (factory) {
    factory(moment);
}(function (moment) {
    function plural(word, num) {
        var forms = word.split('_');
        return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
    }

    function relativeTimeWithPlural(number, withoutSuffix, key) {
        var format = {
            'mm': 'ั…ะฒะธะปะธะฝะฐ_ั…ะฒะธะปะธะฝะธ_ั…ะฒะธะปะธะฝ',
            'hh': 'ะณะพะดะธะฝะฐ_ะณะพะดะธะฝะธ_ะณะพะดะธะฝ',
            'dd': 'ะดะตะฝั_ะดะฝั–_ะดะฝั–ะฒ',
            'MM': 'ะผั–ัััั_ะผั–ัััั–_ะผั–ัััั–ะฒ',
            'yy': 'ั€ั–ะบ_ั€ะพะบะธ_ั€ะพะบั–ะฒ'
        };
        if (key === 'm') {
            return withoutSuffix ? 'ั…ะฒะธะปะธะฝะฐ' : 'ั…ะฒะธะปะธะฝั';
        }
        else if (key === 'h') {
            return withoutSuffix ? 'ะณะพะดะธะฝะฐ' : 'ะณะพะดะธะฝั';
        }
        else {
            return number + ' ' + plural(format[key], +number);
        }
    }

    function monthsCaseReplace(m, format) {
        var months = {
            'nominative': 'ัั–ัะตะฝั_ะปััะธะน_ะฑะตั€ะตะทะตะฝั_ะบะฒั–ัะตะฝั_ัั€ะฐะฒะตะฝั_ัะตั€ะฒะตะฝั_ะปะธะฟะตะฝั_ัะตั€ะฟะตะฝั_ะฒะตั€ะตัะตะฝั_ะถะพะฒัะตะฝั_ะปะธััะพะฟะฐะด_ะณั€ัะดะตะฝั'.split('_'),
            'accusative': 'ัั–ัะฝั_ะปััะพะณะพ_ะฑะตั€ะตะทะฝั_ะบะฒั–ัะฝั_ัั€ะฐะฒะฝั_ัะตั€ะฒะฝั_ะปะธะฟะฝั_ัะตั€ะฟะฝั_ะฒะตั€ะตัะฝั_ะถะพะฒัะฝั_ะปะธััะพะฟะฐะดะฐ_ะณั€ัะดะฝั'.split('_')
        },

        nounCase = (/D[oD]? *MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return months[nounCase][m.month()];
    }

    function weekdaysCaseReplace(m, format) {
        var weekdays = {
            'nominative': 'ะฝะตะดั–ะปั_ะฟะพะฝะตะดั–ะปะพะบ_ะฒั–ะฒัะพั€ะพะบ_ัะตั€ะตะดะฐ_ัะตัะฒะตั€_ะฟโ€ััะฝะธัั_ััะฑะพัะฐ'.split('_'),
            'accusative': 'ะฝะตะดั–ะปั_ะฟะพะฝะตะดั–ะปะพะบ_ะฒั–ะฒัะพั€ะพะบ_ัะตั€ะตะดั_ัะตัะฒะตั€_ะฟโ€ััะฝะธัั_ััะฑะพัั'.split('_'),
            'genitive': 'ะฝะตะดั–ะปั–_ะฟะพะฝะตะดั–ะปะบะฐ_ะฒั–ะฒัะพั€ะบะฐ_ัะตั€ะตะดะธ_ัะตัะฒะตั€ะณะฐ_ะฟโ€ััะฝะธัั–_ััะฑะพัะธ'.split('_')
        },

        nounCase = (/(\[[ะ’ะฒะฃั]\]) ?dddd/).test(format) ?
            'accusative' :
            ((/\[?(?:ะผะธะฝัะปะพั—|ะฝะฐัััะฟะฝะพั—)? ?\] ?dddd/).test(format) ?
                'genitive' :
                'nominative');

        return weekdays[nounCase][m.day()];
    }

    function processHoursFunction(str) {
        return function () {
            return str + 'ะพ' + (this.hours() === 11 ? 'ะฑ' : '') + '] LT';
        };
    }

    return moment.defineLocale('uk', {
        months : monthsCaseReplace,
        monthsShort : 'ัั–ั_ะปัั_ะฑะตั€_ะบะฒั–ั_ัั€ะฐะฒ_ัะตั€ะฒ_ะปะธะฟ_ัะตั€ะฟ_ะฒะตั€_ะถะพะฒั_ะปะธัั_ะณั€ัะด'.split('_'),
        weekdays : weekdaysCaseReplace,
        weekdaysShort : 'ะฝะด_ะฟะฝ_ะฒั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        weekdaysMin : 'ะฝะด_ะฟะฝ_ะฒั_ัั€_ัั_ะฟั_ัะฑ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY ั€.',
            LLL : 'D MMMM YYYY ั€., LT',
            LLLL : 'dddd, D MMMM YYYY ั€., LT'
        },
        calendar : {
            sameDay: processHoursFunction('[ะกัะพะณะพะดะฝั– '),
            nextDay: processHoursFunction('[ะ—ะฐะฒัั€ะฐ '),
            lastDay: processHoursFunction('[ะ’ัะพั€ะฐ '),
            nextWeek: processHoursFunction('[ะฃ] dddd ['),
            lastWeek: function () {
                switch (this.day()) {
                case 0:
                case 3:
                case 5:
                case 6:
                    return processHoursFunction('[ะะธะฝัะปะพั—] dddd [').call(this);
                case 1:
                case 2:
                case 4:
                    return processHoursFunction('[ะะธะฝัะปะพะณะพ] dddd [').call(this);
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'ะทะฐ %s',
            past : '%s ัะพะผั',
            s : 'ะดะตะบั–ะปัะบะฐ ัะตะบัะฝะด',
            m : relativeTimeWithPlural,
            mm : relativeTimeWithPlural,
            h : 'ะณะพะดะธะฝั',
            hh : relativeTimeWithPlural,
            d : 'ะดะตะฝั',
            dd : relativeTimeWithPlural,
            M : 'ะผั–ัััั',
            MM : relativeTimeWithPlural,
            y : 'ั€ั–ะบ',
            yy : relativeTimeWithPlural
        },

        // M. E.: those two are virtually unused but a user might want to implement them for his/her website for some reason

        meridiemParse: /ะฝะพัั–|ั€ะฐะฝะบั|ะดะฝั|ะฒะตัะพั€ะฐ/,
        isPM: function (input) {
            return /^(ะดะฝั|ะฒะตัะพั€ะฐ)$/.test(input);
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'ะฝะพัั–';
            } else if (hour < 12) {
                return 'ั€ะฐะฝะบั';
            } else if (hour < 17) {
                return 'ะดะฝั';
            } else {
                return 'ะฒะตัะพั€ะฐ';
            }
        },

        ordinalParse: /\d{1,2}-(ะน|ะณะพ)/,
        ordinal: function (number, period) {
            switch (period) {
            case 'M':
            case 'd':
            case 'DDD':
            case 'w':
            case 'W':
                return number + '-ะน';
            case 'D':
                return number + '-ะณะพ';
            default:
                return number;
            }
        },

        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : uzbek (uz)
// author : Sardor Muminov : https://github.com/muminoff

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('uz', {
        months : 'ัะฝะฒะฐั€ั_ัะตะฒั€ะฐะปั_ะผะฐั€ั_ะฐะฟั€ะตะปั_ะผะฐะน_ะธัะฝั_ะธัะปั_ะฐะฒะณััั_ัะตะฝััะฑั€ั_ะพะบััะฑั€ั_ะฝะพัะฑั€ั_ะดะตะบะฐะฑั€ั'.split('_'),
        monthsShort : 'ัะฝะฒ_ัะตะฒ_ะผะฐั€_ะฐะฟั€_ะผะฐะน_ะธัะฝ_ะธัะป_ะฐะฒะณ_ัะตะฝ_ะพะบั_ะฝะพั_ะดะตะบ'.split('_'),
        weekdays : 'ะฏะบัะฐะฝะฑะฐ_ะ”ััะฐะฝะฑะฐ_ะกะตัะฐะฝะฑะฐ_ะงะพั€ัะฐะฝะฑะฐ_ะะฐะนัะฐะฝะฑะฐ_ะ–ัะผะฐ_ะจะฐะฝะฑะฐ'.split('_'),
        weekdaysShort : 'ะฏะบั_ะ”ัั_ะกะตั_ะงะพั€_ะะฐะน_ะ–ัะผ_ะจะฐะฝ'.split('_'),
        weekdaysMin : 'ะฏะบ_ะ”ั_ะกะต_ะงะพ_ะะฐ_ะ–ั_ะจะฐ'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY LT',
            LLLL : 'D MMMM YYYY, dddd LT'
        },
        calendar : {
            sameDay : '[ะ‘ัะณัะฝ ัะพะฐั] LT [ะดะฐ]',
            nextDay : '[ะญั€ัะฐะณะฐ] LT [ะดะฐ]',
            nextWeek : 'dddd [ะบัะฝะธ ัะพะฐั] LT [ะดะฐ]',
            lastDay : '[ะะตัะฐ ัะพะฐั] LT [ะดะฐ]',
            lastWeek : '[ะฃัะณะฐะฝ] dddd [ะบัะฝะธ ัะพะฐั] LT [ะดะฐ]',
            sameElse : 'L'
        },
        relativeTime : {
            future : 'ะฏะบะธะฝ %s ะธัะธะดะฐ',
            past : 'ะ‘ะธั€ ะฝะตัะฐ %s ะพะปะดะธะฝ',
            s : 'ััั€ัะฐั',
            m : 'ะฑะธั€ ะดะฐะบะธะบะฐ',
            mm : '%d ะดะฐะบะธะบะฐ',
            h : 'ะฑะธั€ ัะพะฐั',
            hh : '%d ัะพะฐั',
            d : 'ะฑะธั€ ะบัะฝ',
            dd : '%d ะบัะฝ',
            M : 'ะฑะธั€ ะพะน',
            MM : '%d ะพะน',
            y : 'ะฑะธั€ ะนะธะป',
            yy : '%d ะนะธะป'
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : vietnamese (vi)
// author : Bang Nguyen : https://github.com/bangnk

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('vi', {
        months : 'thรกng 1_thรกng 2_thรกng 3_thรกng 4_thรกng 5_thรกng 6_thรกng 7_thรกng 8_thรกng 9_thรกng 10_thรกng 11_thรกng 12'.split('_'),
        monthsShort : 'Th01_Th02_Th03_Th04_Th05_Th06_Th07_Th08_Th09_Th10_Th11_Th12'.split('_'),
        weekdays : 'chแปง nhแบญt_thแปฉ hai_thแปฉ ba_thแปฉ tฦฐ_thแปฉ nฤm_thแปฉ sรกu_thแปฉ bแบฃy'.split('_'),
        weekdaysShort : 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
        weekdaysMin : 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'LT:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM [nฤm] YYYY',
            LLL : 'D MMMM [nฤm] YYYY LT',
            LLLL : 'dddd, D MMMM [nฤm] YYYY LT',
            l : 'DD/M/YYYY',
            ll : 'D MMM YYYY',
            lll : 'D MMM YYYY LT',
            llll : 'ddd, D MMM YYYY LT'
        },
        calendar : {
            sameDay: '[Hรดm nay lรบc] LT',
            nextDay: '[Ngร y mai lรบc] LT',
            nextWeek: 'dddd [tuแบงn tแปi lรบc] LT',
            lastDay: '[Hรดm qua lรบc] LT',
            lastWeek: 'dddd [tuแบงn rแป“i lรบc] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : '%s tแปi',
            past : '%s trฦฐแปc',
            s : 'vร i giรขy',
            m : 'mแปt phรบt',
            mm : '%d phรบt',
            h : 'mแปt giแป',
            hh : '%d giแป',
            d : 'mแปt ngร y',
            dd : '%d ngร y',
            M : 'mแปt thรกng',
            MM : '%d thรกng',
            y : 'mแปt nฤm',
            yy : '%d nฤm'
        },
        ordinalParse: /\d{1,2}/,
        ordinal : function (number) {
            return number;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : chinese (zh-cn)
// author : suupic : https://github.com/suupic
// author : Zeno Zeng : https://github.com/zenozeng

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('zh-cn', {
        months : 'ไธ€ๆ_ไบๆ_ไธๆ_ๅๆ_ไบ”ๆ_ๅ…ญๆ_ไธๆ_ๅ…ซๆ_ไนๆ_ๅๆ_ๅไธ€ๆ_ๅไบๆ'.split('_'),
        monthsShort : '1ๆ_2ๆ_3ๆ_4ๆ_5ๆ_6ๆ_7ๆ_8ๆ_9ๆ_10ๆ_11ๆ_12ๆ'.split('_'),
        weekdays : 'ๆๆๆ—ฅ_ๆๆไธ€_ๆๆไบ_ๆๆไธ_ๆๆๅ_ๆๆไบ”_ๆๆๅ…ญ'.split('_'),
        weekdaysShort : 'ๅ‘จๆ—ฅ_ๅ‘จไธ€_ๅ‘จไบ_ๅ‘จไธ_ๅ‘จๅ_ๅ‘จไบ”_ๅ‘จๅ…ญ'.split('_'),
        weekdaysMin : 'ๆ—ฅ_ไธ€_ไบ_ไธ_ๅ_ไบ”_ๅ…ญ'.split('_'),
        longDateFormat : {
            LT : 'Ah็นmm',
            LTS : 'Ah็นmๅs็ง’',
            L : 'YYYY-MM-DD',
            LL : 'YYYYๅนดMMMDๆ—ฅ',
            LLL : 'YYYYๅนดMMMDๆ—ฅLT',
            LLLL : 'YYYYๅนดMMMDๆ—ฅddddLT',
            l : 'YYYY-MM-DD',
            ll : 'YYYYๅนดMMMDๆ—ฅ',
            lll : 'YYYYๅนดMMMDๆ—ฅLT',
            llll : 'YYYYๅนดMMMDๆ—ฅddddLT'
        },
        meridiemParse: /ๅๆจ|ๆ—ฉไธ|ไธๅ|ไธญๅ|ไธๅ|ๆไธ/,
        meridiemHour: function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'ๅๆจ' || meridiem === 'ๆ—ฉไธ' ||
                    meridiem === 'ไธๅ') {
                return hour;
            } else if (meridiem === 'ไธๅ' || meridiem === 'ๆไธ') {
                return hour + 12;
            } else {
                // 'ไธญๅ'
                return hour >= 11 ? hour : hour + 12;
            }
        },
        meridiem : function (hour, minute, isLower) {
            var hm = hour * 100 + minute;
            if (hm < 600) {
                return 'ๅๆจ';
            } else if (hm < 900) {
                return 'ๆ—ฉไธ';
            } else if (hm < 1130) {
                return 'ไธๅ';
            } else if (hm < 1230) {
                return 'ไธญๅ';
            } else if (hm < 1800) {
                return 'ไธๅ';
            } else {
                return 'ๆไธ';
            }
        },
        calendar : {
            sameDay : function () {
                return this.minutes() === 0 ? '[ไปๅคฉ]Ah[็นๆ•ด]' : '[ไปๅคฉ]LT';
            },
            nextDay : function () {
                return this.minutes() === 0 ? '[ๆๅคฉ]Ah[็นๆ•ด]' : '[ๆๅคฉ]LT';
            },
            lastDay : function () {
                return this.minutes() === 0 ? '[ๆจๅคฉ]Ah[็นๆ•ด]' : '[ๆจๅคฉ]LT';
            },
            nextWeek : function () {
                var startOfWeek, prefix;
                startOfWeek = moment().startOf('week');
                prefix = this.unix() - startOfWeek.unix() >= 7 * 24 * 3600 ? '[ไธ]' : '[ๆฌ]';
                return this.minutes() === 0 ? prefix + 'dddAh็นๆ•ด' : prefix + 'dddAh็นmm';
            },
            lastWeek : function () {
                var startOfWeek, prefix;
                startOfWeek = moment().startOf('week');
                prefix = this.unix() < startOfWeek.unix()  ? '[ไธ]' : '[ๆฌ]';
                return this.minutes() === 0 ? prefix + 'dddAh็นๆ•ด' : prefix + 'dddAh็นmm';
            },
            sameElse : 'LL'
        },
        ordinalParse: /\d{1,2}(ๆ—ฅ|ๆ|ๅ‘จ)/,
        ordinal : function (number, period) {
            switch (period) {
            case 'd':
            case 'D':
            case 'DDD':
                return number + 'ๆ—ฅ';
            case 'M':
                return number + 'ๆ';
            case 'w':
            case 'W':
                return number + 'ๅ‘จ';
            default:
                return number;
            }
        },
        relativeTime : {
            future : '%sๅ…',
            past : '%sๅ',
            s : 'ๅ ็ง’',
            m : '1ๅ้’',
            mm : '%dๅ้’',
            h : '1ๅฐๆ—ถ',
            hh : '%dๅฐๆ—ถ',
            d : '1ๅคฉ',
            dd : '%dๅคฉ',
            M : '1ไธชๆ',
            MM : '%dไธชๆ',
            y : '1ๅนด',
            yy : '%dๅนด'
        },
        week : {
            // GB/T 7408-1994ใ€ๆ•ฐๆฎๅ…ๅ’ไบคๆขๆ ผๅผยทไฟกๆฏไบคๆขยทๆ—ฅๆๅ’ๆ—ถ้—ด่กจ็คบๆณ•ใ€ไธISO 8601:1988็ญๆ•
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));
// moment.js locale configuration
// locale : traditional chinese (zh-tw)
// author : Ben : https://github.com/ben-lin

(function (factory) {
    factory(moment);
}(function (moment) {
    return moment.defineLocale('zh-tw', {
        months : 'ไธ€ๆ_ไบๆ_ไธๆ_ๅๆ_ไบ”ๆ_ๅ…ญๆ_ไธๆ_ๅ…ซๆ_ไนๆ_ๅๆ_ๅไธ€ๆ_ๅไบๆ'.split('_'),
        monthsShort : '1ๆ_2ๆ_3ๆ_4ๆ_5ๆ_6ๆ_7ๆ_8ๆ_9ๆ_10ๆ_11ๆ_12ๆ'.split('_'),
        weekdays : 'ๆๆๆ—ฅ_ๆๆไธ€_ๆๆไบ_ๆๆไธ_ๆๆๅ_ๆๆไบ”_ๆๆๅ…ญ'.split('_'),
        weekdaysShort : '้€ฑๆ—ฅ_้€ฑไธ€_้€ฑไบ_้€ฑไธ_้€ฑๅ_้€ฑไบ”_้€ฑๅ…ญ'.split('_'),
        weekdaysMin : 'ๆ—ฅ_ไธ€_ไบ_ไธ_ๅ_ไบ”_ๅ…ญ'.split('_'),
        longDateFormat : {
            LT : 'Ah้ปmm',
            LTS : 'Ah้ปmๅs็ง’',
            L : 'YYYYๅนดMMMDๆ—ฅ',
            LL : 'YYYYๅนดMMMDๆ—ฅ',
            LLL : 'YYYYๅนดMMMDๆ—ฅLT',
            LLLL : 'YYYYๅนดMMMDๆ—ฅddddLT',
            l : 'YYYYๅนดMMMDๆ—ฅ',
            ll : 'YYYYๅนดMMMDๆ—ฅ',
            lll : 'YYYYๅนดMMMDๆ—ฅLT',
            llll : 'YYYYๅนดMMMDๆ—ฅddddLT'
        },
        meridiemParse: /ๆ—ฉไธ|ไธๅ|ไธญๅ|ไธๅ|ๆไธ/,
        meridiemHour : function (hour, meridiem) {
            if (hour === 12) {
                hour = 0;
            }
            if (meridiem === 'ๆ—ฉไธ' || meridiem === 'ไธๅ') {
                return hour;
            } else if (meridiem === 'ไธญๅ') {
                return hour >= 11 ? hour : hour + 12;
            } else if (meridiem === 'ไธๅ' || meridiem === 'ๆไธ') {
                return hour + 12;
            }
        },
        meridiem : function (hour, minute, isLower) {
            var hm = hour * 100 + minute;
            if (hm < 900) {
                return 'ๆ—ฉไธ';
            } else if (hm < 1130) {
                return 'ไธๅ';
            } else if (hm < 1230) {
                return 'ไธญๅ';
            } else if (hm < 1800) {
                return 'ไธๅ';
            } else {
                return 'ๆไธ';
            }
        },
        calendar : {
            sameDay : '[ไปๅคฉ]LT',
            nextDay : '[ๆๅคฉ]LT',
            nextWeek : '[ไธ]ddddLT',
            lastDay : '[ๆจๅคฉ]LT',
            lastWeek : '[ไธ]ddddLT',
            sameElse : 'L'
        },
        ordinalParse: /\d{1,2}(ๆ—ฅ|ๆ|้€ฑ)/,
        ordinal : function (number, period) {
            switch (period) {
            case 'd' :
            case 'D' :
            case 'DDD' :
                return number + 'ๆ—ฅ';
            case 'M' :
                return number + 'ๆ';
            case 'w' :
            case 'W' :
                return number + '้€ฑ';
            default :
                return number;
            }
        },
        relativeTime : {
            future : '%sๅ…ง',
            past : '%sๅ',
            s : 'ๅนพ็ง’',
            m : 'ไธ€ๅ้',
            mm : '%dๅ้',
            h : 'ไธ€ๅฐๆ',
            hh : '%dๅฐๆ',
            d : 'ไธ€ๅคฉ',
            dd : '%dๅคฉ',
            M : 'ไธ€ๅ€ๆ',
            MM : '%dๅ€ๆ',
            y : 'ไธ€ๅนด',
            yy : '%dๅนด'
        }
    });
}));

    moment.locale('en');


    /************************************
        Exposing Moment
    ************************************/

    function makeGlobal(shouldDeprecate) {
        /*global ender:false */
        if (typeof ender !== 'undefined') {
            return;
        }
        oldGlobalMoment = globalScope.moment;
        if (shouldDeprecate) {
            globalScope.moment = deprecate(
                    'Accessing Moment through the global scope is ' +
                    'deprecated, and will be removed in an upcoming ' +
                    'release.',
                    moment);
        } else {
            globalScope.moment = moment;
        }
    }

    // CommonJS module is defined
    if (hasModule) {
        module.exports = moment;
    } else if (typeof define === 'function' && define.amd) {
        define(function (require, exports, module) {
            if (module.config && module.config() && module.config().noGlobal === true) {
                // release the global variable
                globalScope.moment = oldGlobalMoment;
            }

            return moment;
        });
        makeGlobal(true);
    } else {
        makeGlobal();
    }
}).call(this);