<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Management - Monti Textile HRM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier Newmonospace";--color-red-50:oklch(.971 .013 17.38);--color-red-100:oklch(.936 .032 17.717);--color-red-200:oklch(.885 .062 18.334);--color-red-300:oklch(.808 .114 19.571);--color-red-400:oklch(.704 .191 22.216);--color-red-500:oklch(.637 .237 25.331);--color-red-600:oklch(.577 .245 27.325);--color-red-700:oklch(.505 .213 27.518);--color-red-800:oklch(.444 .177 26.899);--color-red-900:oklch(.396 .141 25.723);--color-red-950:oklch(.258 .092 26.042);--color-orange-50:oklch(.98 .016 73.684);--color-orange-100:oklch(.954 .038 75.164);--color-orange-200:oklch(.901 .076 70.697);--color-orange-300:oklch(.837 .128 66.29);--color-orange-400:oklch(.75 .183 55.934);--color-orange-500:oklch(.705 .213 47.604);--color-orange-600:oklch(.646 .222 41.116);--color-orange-700:oklch(.553 .195 38.402);--color-orange-800:oklch(.47 .157 37.304);--color-orange-900:oklch(.408 .123 38.172);--color-orange-950:oklch(.266 .079 36.259);--color-amber-50:oklch(.987 .022 95.277);--color-amber-100:oklch(.962 .059 95.617);--color-amber-200:oklch(.924 .12 95.746);--color-amber-300:oklch(.879 .169 91.605);--color-amber-400:oklch(.828 .189 84.429);--color-amber-500:oklch(.769 .188 70.08);--color-amber-600:oklch(.666 .179 58.318);--color-amber-700:oklch(.555 .163 48.998);--color-amber-800:oklch(.473 .137 46.201);--color-amber-900:oklch(.414 .112 45.904);--color-amber-950:oklch(.279 .077 45.635);--color-yellow-50:oklch(.987 .026 102.212);--color-yellow-100:oklch(.973 .071 103.193);--color-yellow-200:oklch(.945 .129 101.54);--color-yellow-300:oklch(.905 .182 98.111);--color-yellow-400:oklch(.852 .199 91.936);--color-yellow-500:oklch(.795 .184 86.047);--color-yellow-600:oklch(.681 .162 75.834);--color-yellow-700:oklch(.554 .135 66.442);--color-yellow-800:oklch(.476 .114 61.907);--color-yellow-900:oklch(.421 .095 57.708);--color-yellow-950:oklch(.286 .066 53.813);--color-lime-50:oklch(.986 .031 120.757);--color-lime-100:oklch(.967 .067 122.328);--color-lime-200:oklch(.938 .127 124.321);--color-lime-300:oklch(.897 .196 126.665);--color-lime-400:oklch(.841 .238 128.85);--color-lime-500:oklch(.768 .233 130.85);--color-lime-600:oklch(.648 .2 131.684);--color-lime-700:oklch(.532 .157 131.589);--color-lime-800:oklch(.453 .124 130.933);--color-lime-900:oklch(.405 .101 131.063);--color-lime-950:oklch(.274 .072 132.109);--color-green-50:oklch(.982 .018 155.826);--color-green-100:oklch(.962 .044 156.743);--color-green-200:oklch(.925 .084 155.995);--color-green-300:oklch(.871 .15 154.449);--color-green-400:oklch(.792 .209 151.711);--color-green-500:oklch(.723 .219 149.579);--color-green-600:oklch(.627 .194 149.214);--color-green-700:oklch(.527 .154 150.069);--color-green-800:oklch(.448 .119 151.328);--color-green-900:oklch(.393 .095 152.535);--color-green-950:oklch(.266 .065 152.934);--color-emerald-50:oklch(.979 .021 166.113);--color-emerald-100:oklch(.95 .052 163.051);--color-emerald-200:oklch(.905 .093 164.15);--color-emerald-300:oklch(.845 .143 164.978);--color-emerald-400:oklch(.765 .177 163.223);--color-emerald-500:oklch(.696 .17 162.48);--color-emerald-600:oklch(.596 .145 163.225);--color-emerald-700:oklch(.508 .118 165.612);--color-emerald-800:oklch(.432 .095 166.913);--color-emerald-900:oklch(.378 .077 168.94);--color-emerald-950:oklch(.262 .051 172.552);--color-teal-50:oklch(.984 .014 180.72);--color-teal-100:oklch(.953 .051 180.801);--color-teal-200:oklch(.91 .096 180.426);--color-teal-300:oklch(.855 .138 181.071);--color-teal-400:oklch(.777 .152 181.912);--color-teal-500:oklch(.704 .14 182.503);--color-teal-600:oklch(.6 .118 184.704);--color-teal-700:oklch(.511 .096 186.391);--color-teal-800:oklch(.437 .078 188.216);--color-teal-900:oklch(.386 .063 188.416);--color-teal-950:oklch(.277 .046 192.524);--color-cyan-50:oklch(.984 .019 200.873);--color-cyan-100:oklch(.956 .045 203.388);--color-cyan-200:oklch(.917 .08 205.041);--color-cyan-300:oklch(.865 .127 207.078);--color-cyan-400:oklch(.789 .154 211.53);--color-cyan-500:oklch(.715 .143 215.221);--color-cyan-600:oklch(.609 .126 221.723);--color-cyan-700:oklch(.52 .105 223.128);--color-cyan-800:oklch(.45 .085 224.283);--color-cyan-900:oklch(.398 .07 227.392);--color-cyan-950:oklch(.302 .056 229.695);--color-sky-50:oklch(.977 .013 236.62);--color-sky-100:oklch(.951 .026 236.824);--color-sky-200:oklch(.901 .058 230.902);--color-sky-300:oklch(.828 .111 230.318);--color-sky-400:oklch(.746 .16 232.661);--color-sky-500:oklch(.685 .169 237.323);--color-sky-600:oklch(.588 .158 241.966);--color-sky-700:oklch(.5 .134 242.749);--color-sky-800:oklch(.443 .11 240.79);--color-sky-900:oklch(.391 .09 240.876);--color-sky-950:oklch(.293 .066 243.157);--color-blue-50:oklch(.97 .014 254.604);--color-blue-100:oklch(.932 .032 255.585);--color-blue-200:oklch(.882 .059 254.128);--color-blue-300:oklch(.809 .105 251.813);--color-blue-400:oklch(.707 .165 254.624);--color-blue-500:oklch(.623 .214 259.815);--color-blue-600:oklch(.546 .245 262.881);--color-blue-700:oklch(.488 .243 264.376);--color-blue-800:oklch(.424 .199 265.638);--color-blue-900:oklch(.379 .146 265.522);--color-blue-950:oklch(.282 .091 267.935);--color-indigo-50:oklch(.962 .018 272.314);--color-indigo-100:oklch(.93 .034 272.788);--color-indigo-200:oklch(.87 .065 274.039);--color-indigo-300:oklch(.785 .115 274.713);--color-indigo-400:oklch(.673 .182 276.935);--color-indigo-500:oklch(.585 .233 277.117);--color-indigo-600:oklch(.511 .262 276.966);--color-indigo-700:oklch(.457 .24 277.023);--color-indigo-800:oklch(.398 .195 277.366);--color-indigo-900:oklch(.359 .144 278.697);--color-indigo-950:oklch(.257 .09 281.288);--color-violet-50:oklch(.969 .016 293.756);--color-violet-100:oklch(.943 .029 294.588);--color-violet-200:oklch(.894 .057 293.283);--color-violet-300:oklch(.811 .111 293.571);--color-violet-400:oklch(.702 .183 293.541);--color-violet-500:oklch(.606 .25 292.717);--color-violet-600:oklch(.541 .281 293.009);--color-violet-700:oklch(.491 .27 292.581);--color-violet-800:oklch(.432 .232 292.759);--color-violet-900:oklch(.38 .189 293.745);--color-violet-950:oklch(.283 .141 291.089);--color-purple-50:oklch(.977 .014 308.299);--color-purple-100:oklch(.946 .033 307.174);--color-purple-200:oklch(.902 .063 306.703);--color-purple-300:oklch(.827 .119 306.383);--color-purple-400:oklch(.714 .203 305.504);--color-purple-500:oklch(.627 .265 303.9);--color-purple-600:oklch(.558 .288 302.321);--color-purple-700:oklch(.496 .265 301.924);--color-purple-800:oklch(.438 .218 303.724);--color-purple-900:oklch(.381 .176 304.987);--color-purple-950:oklch(.291 .149 302.717);--color-fuchsia-50:oklch(.977 .017 320.058);--color-fuchsia-100:oklch(.952 .037 318.852);--color-fuchsia-200:oklch(.903 .076 319.62);--color-fuchsia-300:oklch(.833 .145 321.434);--color-fuchsia-400:oklch(.74 .238 322.16);--color-fuchsia-500:oklch(.667 .295 322.15);--color-fuchsia-600:oklch(.591 .293 322.896);--color-fuchsia-700:oklch(.518 .253 323.949);--color-fuchsia-800:oklch(.452 .211 324.591);--color-fuchsia-900:oklch(.401 .17 325.612);--color-fuchsia-950:oklch(.293 .136 325.661);--color-pink-50:oklch(.971 .014 343.198);--color-pink-100:oklch(.948 .028 342.258);--color-pink-200:oklch(.899 .061 343.231);--color-pink-300:oklch(.823 .12 346.018);--color-pink-400:oklch(.718 .202 349.761);--color-pink-500:oklch(.656 .241 354.308);--color-pink-600:oklch(.592 .249 .584);--color-pink-700:oklch(.525 .223 3.958);--color-pink-800:oklch(.459 .187 3.815);--color-pink-900:oklch(.408 .153 2.432);--color-pink-950:oklch(.284 .109 3.907);--color-rose-50:oklch(.969 .015 12.422);--color-rose-100:oklch(.941 .03 12.58);--color-rose-200:oklch(.892 .058 10.001);--color-rose-300:oklch(.81 .117 11.638);--color-rose-400:oklch(.712 .194 13.428);--color-rose-500:oklch(.645 .246 16.439);--color-rose-600:oklch(.586 .253 17.585);--color-rose-700:oklch(.514 .222 16.935);--color-rose-800:oklch(.455 .188 13.697);--color-rose-900:oklch(.41 .159 10.272);--color-rose-950:oklch(.271 .105 12.094);--color-slate-50:oklch(.984 .003 247.858);--color-slate-100:oklch(.968 .007 247.896);--color-slate-200:oklch(.929 .013 255.508);--color-slate-300:oklch(.869 .022 252.894);--color-slate-400:oklch(.704 .04 256.788);--color-slate-500:oklch(.554 .046 257.417);--color-slate-600:oklch(.446 .043 257.281);--color-slate-700:oklch(.372 .044 257.287);--color-slate-800:oklch(.279 .041 260.031);--color-slate-900:oklch(.208 .042 265.755);--color-slate-950:oklch(.129 .042 264.695);--color-gray-50:oklch(.985 .002 247.839);--color-gray-100:oklch(.967 .003 264.542);--color-gray-200:oklch(.928 .006 264.531);--color-gray-300:oklch(.872 .01 258.338);--color-gray-400:oklch(.707 .022 261.325);--color-gray-500:oklch(.551 .027 264.364);--color-gray-600:oklch(.446 .03 256.802);--color-gray-700:oklch(.373 .034 259.733);--color-gray-800:oklch(.278 .033 256.848);--color-gray-900:oklch(.21 .034 264.665);--color-gray-950:oklch(.13 .028 261.692);--color-zinc-50:oklch(.985 0 0);--color-zinc-100:oklch(.967 .001 286.375);--color-zinc-200:oklch(.92 .004 286.32);--color-zinc-300:oklch(.871 .006 286.286);--color-zinc-400:oklch(.705 .015 286.067);--color-zinc-500:oklch(.552 .016 285.938);--color-zinc-600:oklch(.442 .017 285.786);--color-zinc-700:oklch(.37 .013 285.805);--color-zinc-800:oklch(.274 .006 286.033);--color-zinc-900:oklch(.21 .006 285.885);--color-zinc-950:oklch(.141 .005 285.823);--color-neutral-50:oklch(.985 0 0);--color-neutral-100:oklch(.97 0 0);--color-neutral-200:oklch(.922 0 0);--color-neutral-300:oklch(.87 0 0);--color-neutral-400:oklch(.708 0 0);--color-neutral-500:oklch(.556 0 0);--color-neutral-600:oklch(.439 0 0);--color-neutral-700:oklch(.371 0 0);--color-neutral-800:oklch(.269 0 0);--color-neutral-900:oklch(.205 0 0);--color-neutral-950:oklch(.145 0 0);--color-stone-50:oklch(.985 .001 106.423);--color-stone-100:oklch(.97 .001 106.424);--color-stone-200:oklch(.923 .003 48.717);--color-stone-300:oklch(.869 .005 56.366);--color-stone-400:oklch(.709 .01 56.259);--color-stone-500:oklch(.553 .013 58.071);--color-stone-600:oklch(.444 .011 73.639);--color-stone-700:oklch(.374 .01 67.558);--color-stone-800:oklch(.268 .007 34.298);--color-stone-900:oklch(.216 .006 56.043);--color-stone-950:oklch(.147 .004 49.25);--color-black:#000;--color-white:#fff;--spacing:.25rem;--breakpoint-sm:40rem;--breakpoint-md:48rem;--breakpoint-lg:64rem;--breakpoint-xl:80rem;--breakpoint-2xl:96rem;--container-3xs:16rem;--container-2xs:18rem;--container-xs:20rem;--container-sm:24rem;--container-md:28rem;--container-lg:32rem;--container-xl:36rem;--container-2xl:42rem;--container-3xl:48rem;--container-4xl:56rem;--container-5xl:64rem;--container-6xl:72rem;--container-7xl:80rem;--text-xs:.75rem;--text-xs--line-height:calc(1/.75);--text-sm:.875rem;--text-sm--line-height:calc(1.25/.875);--text-base:1rem;--text-base--line-height: 1.5 ;--text-lg:1.125rem;--text-lg--line-height:calc(1.75/1.125);--text-xl:1.25rem;--text-xl--line-height:calc(1.75/1.25);--text-2xl:1.5rem;--text-2xl--line-height:calc(2/1.5);--text-3xl:1.875rem;--text-3xl--line-height: 1.2 ;--text-4xl:2.25rem;--text-4xl--line-height:calc(2.5/2.25);--text-5xl:3rem;--text-5xl--line-height:1;--text-6xl:3.75rem;--text-6xl--line-height:1;--text-7xl:4.5rem;--text-7xl--line-height:1;--text-8xl:6rem;--text-8xl--line-height:1;--text-9xl:8rem;--text-9xl--line-height:1;--font-weight-thin:100;--font-weight-extralight:200;--font-weight-light:300;--font-weight-normal:400;--font-weight-medium:500;--font-weight-semibold:600;--font-weight-bold:700;--font-weight-extrabold:800;--font-weight-black:900;--tracking-tighter:-.05em;--tracking-tight:-.025em;--tracking-normal:0em;--tracking-wide:.025em;--tracking-wider:.05em;--tracking-widest:.1em;--leading-tight:1.25;--leading-snug:1.375;--leading-normal:1.5;--leading-relaxed:1.625;--leading-loose:2;--radius-xs:.125rem;--radius-sm:.25rem;--radius-md:.375rem;--radius-lg:.5rem;--radius-xl:.75rem;--radius-2xl:1rem;--radius-3xl:1.5rem;--radius-4xl:2rem;--shadow-2xs:0 1px #0000000d;--shadow-xs:0 1px 2px 0 #0000000d;--shadow-sm:0 1px 3px 0 #0000001a,0 1px 2px -1px #0000001a;--shadow-md:0 4px 6px -1px #0000001a,0 2px 4px -2px #0000001a;--shadow-lg:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--shadow-xl:0 20px 25px -5px #0000001a,0 8px 10px -6px #0000001a;--shadow-2xl:0 25px 50px -12px #00000040;--inset-shadow-2xs:inset 0 1px #0000000d;--inset-shadow-xs:inset 0 1px 1px #0000000d;--inset-shadow-sm:inset 0 2px 4px #0000000d;--drop-shadow-xs:0 1px 1px #0000000d;--drop-shadow-sm:0 1px 2px #00000026;--drop-shadow-md:0 3px 3px #0000001f;--drop-shadow-lg:0 4px 4px #00000026;--drop-shadow-xl:0 9px 7px #0000001a;--drop-shadow-2xl:0 25px 25px #00000026;--ease-in:cubic-bezier(.4,0,1,1);--ease-out:cubic-bezier(0,0,.2,1);--ease-in-out:cubic-bezier(.4,0,.2,1);--animate-spin:spin 1s linear infinite;--animate-ping:ping 1s cubic-bezier(0,0,.2,1)infinite;--animate-pulse:pulse 2s cubic-bezier(.4,0,.6,1)infinite;--animate-bounce:bounce 1s infinite;--blur-xs:4px;--blur-sm:8px;--blur-md:12px;--blur-lg:16px;--blur-xl:24px;--blur-2xl:40px;--blur-3xl:64px;--perspective-dramatic:100px;--perspective-near:300px;--perspective-normal:500px;--perspective-midrange:800px;--perspective-distant:1200px;--aspect-video:16/9;--default-transition-duration:.15s;--default-transition-timing-function:cubic-bezier(.4,0,.2,1);--default-font-family:var(--font-sans);--default-font-feature-settings:var(--font-sans--font-feature-settings);--default-font-variation-settings:var(--font-sans--font-variation-settings);--default-mono-font-family:var(--font-mono);--default-mono-font-feature-settings:var(--font-mono--font-feature-settings);--default-mono-font-variation-settings:var(--font-mono--font-variation-settings)}}@layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}::file-selector-button{box-sizing:border-box;border:0 solid;margin:0;padding:0}html,:host{-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;line-height:1.5;font-family:var(--default-font-family,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji");font-feature-settings:var(--default-font-feature-settings,normal);font-variation-settings:var(--default-font-variation-settings,normal);-webkit-tap-highlight-color:transparent}body{line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;-webkit-text-decoration:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:var(--default-mono-font-family,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier Newmonospace");font-feature-settings:var(--default-mono-font-feature-settings,normal);font-variation-settings:var(--default-mono-font-variation-settings,normal);font-size:1em}small{font-size:80%}sub,sup{vertical-align:baseline;font-size:75%;line-height:0;position:relative}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}:-moz-focusring{outline:auto}progress{vertical-align:baseline}summary{display:list-item}ol,ul,menu{list-style:none}img,svg,video,canvas,audio,iframe,embed,object{vertical-align:middle;display:block}img,video{max-width:100%;height:auto}button,input,select,optgroup,textarea{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}::file-selector-button{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}:where(select:is([multiple],[size])) optgroup{font-weight:bolder}:where(select:is([multiple],[size])) optgroup option{padding-inline-start:20px}::file-selector-button{margin-inline-end:4px}::placeholder{opacity:1;color:color-mix(in oklab,currentColor 50%,transparent)}textarea{resize:vertical}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-date-and-time-value{min-height:1lh;text-align:inherit}::-webkit-datetime-edit{display:inline-flex}::-webkit-datetime-edit-fields-wrapper{padding:0}::-webkit-datetime-edit{padding-block:0}::-webkit-datetime-edit-year-field{padding-block:0}::-webkit-datetime-edit-month-field{padding-block:0}::-webkit-datetime-edit-day-field{padding-block:0}::-webkit-datetime-edit-hour-field{padding-block:0}::-webkit-datetime-edit-minute-field{padding-block:0}::-webkit-datetime-edit-second-field{padding-block:0}::-webkit-datetime-edit-millisecond-field{padding-block:0}::-webkit-datetime-edit-meridiem-field{padding-block:0}:-moz-ui-invalid{box-shadow:none}button,input:where([type=button],[type=reset],[type=submit]){-webkit-appearance:button;-moz-appearance:button;appearance:button}::file-selector-button{-webkit-appearance:button;-moz-appearance:button;appearance:button}::-webkit-inner-spin-button{height:auto}::-webkit-outer-spin-button{height:auto}[hidden]:where(:not([hidden=until-found])){display:none!important}}@layer components;@layer utilities{.absolute{position:absolute}.relative{position:relative}.static{position:static}.inset-0{inset:calc(var(--spacing)*0)}.-mt-\[4\.9rem\]{margin-top:-4.9rem}.-mb-px{margin-bottom:-1px}.mb-1{margin-bottom:calc(var(--spacing)*1)}.mb-2{margin-bottom:calc(var(--spacing)*2)}.mb-4{margin-bottom:calc(var(--spacing)*4)}.mb-6{margin-bottom:calc(var(--spacing)*6)}.-ml-8{margin-left:calc(var(--spacing)*-8)}.flex{display:flex}.hidden{display:none}.inline-block{display:inline-block}.inline-flex{display:inline-flex}.table{display:table}.aspect-\[335\/376\]{aspect-ratio:335/376}.h-1{height:calc(var(--spacing)*1)}.h-1\.5{height:calc(var(--spacing)*1.5)}.h-2{height:calc(var(--spacing)*2)}.h-2\.5{height:calc(var(--spacing)*2.5)}.h-3{height:calc(var(--spacing)*3)}.h-3\.5{height:calc(var(--spacing)*3.5)}.h-14{height:calc(var(--spacing)*14)}.h-14\.5{height:calc(var(--spacing)*14.5)}.min-h-screen{min-height:100vh}.w-1{width:calc(var(--spacing)*1)}.w-1\.5{width:calc(var(--spacing)*1.5)}.w-2{width:calc(var(--spacing)*2)}.w-2\.5{width:calc(var(--spacing)*2.5)}.w-3{width:calc(var(--spacing)*3)}.w-3\.5{width:calc(var(--spacing)*3.5)}.w-\[448px\]{width:448px}.w-full{width:100%}.max-w-\[335px\]{max-width:335px}.max-w-none{max-width:none}.flex-1{flex:1}.shrink-0{flex-shrink:0}.translate-y-0{--tw-translate-y:calc(var(--spacing)*0);translate:var(--tw-translate-x)var(--tw-translate-y)}.transform{transform:var(--tw-rotate-x)var(--tw-rotate-y)var(--tw-rotate-z)var(--tw-skew-x)var(--tw-skew-y)}.flex-col{flex-direction:column}.flex-col-reverse{flex-direction:column-reverse}.items-center{align-items:center}.justify-center{justify-content:center}.justify-end{justify-content:flex-end}.gap-3{gap:calc(var(--spacing)*3)}.gap-4{gap:calc(var(--spacing)*4)}:where(.space-x-1>:not(:last-child)){--tw-space-x-reverse:0;margin-inline-start:calc(calc(var(--spacing)*1)*var(--tw-space-x-reverse));margin-inline-end:calc(calc(var(--spacing)*1)*calc(1 - var(--tw-space-x-reverse)))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:3.40282e38px}.rounded-sm{border-radius:var(--radius-sm)}.rounded-t-lg{border-top-left-radius:var(--radius-lg);border-top-right-radius:var(--radius-lg)}.rounded-br-lg{border-bottom-right-radius:var(--radius-lg)}.rounded-bl-lg{border-bottom-left-radius:var(--radius-lg)}.border{border-style:var(--tw-border-style);border-width:1px}.border-\[\#19140035\]{border-color:#19140035}.border-\[\#e3e3e0\]{border-color:#e3e3e0}.border-black{border-color:var(--color-black)}.border-transparent{border-color:#0000}.bg-\[\#1b1b18\]{background-color:#1b1b18}.bg-\[\#FDFDFC\]{background-color:#fdfdfc}.bg-\[\#dbdbd7\]{background-color:#dbdbd7}.bg-\[\#fff2f2\]{background-color:#fff2f2}.bg-white{background-color:var(--color-white)}.p-6{padding:calc(var(--spacing)*6)}.px-5{padding-inline:calc(var(--spacing)*5)}.py-1{padding-block:calc(var(--spacing)*1)}.py-1\.5{padding-block:calc(var(--spacing)*1.5)}.py-2{padding-block:calc(var(--spacing)*2)}.pb-12{padding-bottom:calc(var(--spacing)*12)}.text-sm{font-size:var(--text-sm);line-height:var(--tw-leading,var(--text-sm--line-height))}.text-\[13px\]{font-size:13px}.leading-\[20px\]{--tw-leading:20px;line-height:20px}.leading-normal{--tw-leading:var(--leading-normal);line-height:var(--leading-normal)}.font-medium{--tw-font-weight:var(--font-weight-medium);font-weight:var(--font-weight-medium)}.text-\[\#1b1b18\]{color:#1b1b18}.text-\[\#706f6c\]{color:#706f6c}.text-\[\#F53003\],.text-\[\#f53003\]{color:#f53003}.text-white{color:var(--color-white)}.underline{text-decoration-line:underline}.underline-offset-4{text-underline-offset:4px}.opacity-100{opacity:1}.shadow-\[0px_0px_1px_0px_rgba\(0\,0\,0\,0\.03\)\,0px_1px_2px_0px_rgba\(0\,0\,0\,0\.06\)\]{--tw-shadow:0px 0px 1px 0px var(--tw-shadow-color,#00000008),0px 1px 2px 0px var(--tw-shadow-color,#0000000f);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.shadow-\[inset_0px_0px_0px_1px_rgba\(26\,26\,0\,0\.16\)\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#1a1a0029);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.\!filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)!important}.filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)}.transition-all{transition-property:all;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.transition-opacity{transition-property:opacity;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.delay-300{transition-delay:.3s}.duration-750{--tw-duration:.75s;transition-duration:.75s}.not-has-\[nav\]\:hidden:not(:has(:is(nav))){display:none}.before\:absolute:before{content:var(--tw-content);position:absolute}.before\:top-0:before{content:var(--tw-content);top:calc(var(--spacing)*0)}.before\:top-1\/2:before{content:var(--tw-content);top:50%}.before\:bottom-0:before{content:var(--tw-content);bottom:calc(var(--spacing)*0)}.before\:bottom-1\/2:before{content:var(--tw-content);bottom:50%}.before\:left-\[0\.4rem\]:before{content:var(--tw-content);left:.4rem}.before\:border-l:before{content:var(--tw-content);border-left-style:var(--tw-border-style);border-left-width:1px}.before\:border-\[\#e3e3e0\]:before{content:var(--tw-content);border-color:#e3e3e0}@media (hover:hover){.hover\:border-\[\#1915014a\]:hover{border-color:#1915014a}.hover\:border-\[\#19140035\]:hover{border-color:#19140035}.hover\:border-black:hover{border-color:var(--color-black)}.hover\:bg-black:hover{background-color:var(--color-black)}}@media (width>=64rem){.lg\:-mt-\[6\.6rem\]{margin-top:-6.6rem}.lg\:mb-0{margin-bottom:calc(var(--spacing)*0)}.lg\:mb-6{margin-bottom:calc(var(--spacing)*6)}.lg\:-ml-px{margin-left:-1px}.lg\:ml-0{margin-left:calc(var(--spacing)*0)}.lg\:block{display:block}.lg\:aspect-auto{aspect-ratio:auto}.lg\:w-\[438px\]{width:438px}.lg\:max-w-4xl{max-width:var(--container-4xl)}.lg\:grow{flex-grow:1}.lg\:flex-row{flex-direction:row}.lg\:justify-center{justify-content:center}.lg\:rounded-t-none{border-top-left-radius:0;border-top-right-radius:0}.lg\:rounded-tl-lg{border-top-left-radius:var(--radius-lg)}.lg\:rounded-r-lg{border-top-right-radius:var(--radius-lg);border-bottom-right-radius:var(--radius-lg)}.lg\:rounded-br-none{border-bottom-right-radius:0}.lg\:p-8{padding:calc(var(--spacing)*8)}.lg\:p-20{padding:calc(var(--spacing)*20)}}@media (prefers-color-scheme:dark){.dark\:block{display:block}.dark\:hidden{display:none}.dark\:border-\[\#3E3E3A\]{border-color:#3e3e3a}.dark\:border-\[\#eeeeec\]{border-color:#eeeeec}.dark\:bg-\[\#0a0a0a\]{background-color:#0a0a0a}.dark\:bg-\[\#1D0002\]{background-color:#1d0002}.dark\:bg-\[\#3E3E3A\]{background-color:#3e3e3a}.dark\:bg-\[\#161615\]{background-color:#161615}.dark\:bg-\[\#eeeeec\]{background-color:#eeeeec}.dark\:text-\[\#1C1C1A\]{color:#1c1c1a}.dark\:text-\[\#A1A09A\]{color:#a1a09a}.dark\:text-\[\#EDEDEC\]{color:#ededec}.dark\:text-\[\#F61500\]{color:#f61500}.dark\:text-\[\#FF4433\]{color:#f43}.dark\:shadow-\[inset_0px_0px_0px_1px_\#fffaed2d\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#fffaed2d);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.dark\:before\:border-\[\#3E3E3A\]:before{content:var(--tw-content);border-color:#3e3e3a}@media (hover:hover){.dark\:hover\:border-\[\#3E3E3A\]:hover{border-color:#3e3e3a}.dark\:hover\:border-\[\#62605b\]:hover{border-color:#62605b}.dark\:hover\:border-white:hover{border-color:var(--color-white)}.dark\:hover\:bg-white:hover{background-color:var(--color-white)}}}@starting-style{.starting\:translate-y-4{--tw-translate-y:calc(var(--spacing)*4);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:translate-y-6{--tw-translate-y:calc(var(--spacing)*6);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:opacity-0{opacity:0}}}@keyframes spin{to{transform:rotate(360deg)}}@keyframes ping{75%,to{opacity:0;transform:scale(2)}}@keyframes pulse{50%{opacity:.5}}@keyframes bounce{0%,to{animation-timing-function:cubic-bezier(.8,0,1,1);transform:translateY(-25%)}50%{animation-timing-function:cubic-bezier(0,0,.2,1);transform:none}}@property --tw-translate-x{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-y{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-z{syntax:"*";inherits:false;initial-value:0}@property --tw-rotate-x{syntax:"*";inherits:false;initial-value:rotateX(0)}@property --tw-rotate-y{syntax:"*";inherits:false;initial-value:rotateY(0)}@property --tw-rotate-z{syntax:"*";inherits:false;initial-value:rotateZ(0)}@property --tw-skew-x{syntax:"*";inherits:false;initial-value:skewX(0)}@property --tw-skew-y{syntax:"*";inherits:false;initial-value:skewY(0)}@property --tw-space-x-reverse{syntax:"*";inherits:false;initial-value:0}@property --tw-border-style{syntax:"*";inherits:false;initial-value:solid}@property --tw-leading{syntax:"*";inherits:false}@property --tw-font-weight{syntax:"*";inherits:false}@property --tw-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-shadow-color{syntax:"*";inherits:false}@property --tw-inset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-shadow-color{syntax:"*";inherits:false}@property --tw-ring-color{syntax:"*";inherits:false}@property --tw-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-ring-color{syntax:"*";inherits:false}@property --tw-inset-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-ring-inset{syntax:"*";inherits:false}@property --tw-ring-offset-width{syntax:"<length>";inherits:false;initial-value:0}@property --tw-ring-offset-color{syntax:"*";inherits:false;initial-value:#fff}@property --tw-ring-offset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-blur{syntax:"*";inherits:false}@property --tw-brightness{syntax:"*";inherits:false}@property --tw-contrast{syntax:"*";inherits:false}@property --tw-grayscale{syntax:"*";inherits:false}@property --tw-hue-rotate{syntax:"*";inherits:false}@property --tw-invert{syntax:"*";inherits:false}@property --tw-opacity{syntax:"*";inherits:false}@property --tw-saturate{syntax:"*";inherits:false}@property --tw-sepia{syntax:"*";inherits:false}@property --tw-drop-shadow{syntax:"*";inherits:false}@property --tw-duration{syntax:"*";inherits:false}@property --tw-content{syntax:"*";inherits:false;initial-value:""}
        </style>
    @endif

    <!-- Custom color overrides for gold/blue theme -->
    <style>
        .bg-blue-theme { background-color: #2563eb; }
        .bg-gold-theme { background-color: #d4af37; }
        .bg-emerald-theme { background-color: #059669; }
        .text-blue-theme { color: #2563eb; }
        .text-gold-theme { color: #d4af37; }
        .text-emerald-theme { color: #059669; }
        .border-blue-theme { border-color: #2563eb; }
        .border-gold-theme { border-color: #d4af37; }
        .border-emerald-theme { border-color: #059669; }
        .hover\:bg-blue-theme:hover { background-color: #1d4ed8; }
        .hover\:bg-gold-theme:hover { background-color: #b8860b; }
        .hover\:bg-emerald-theme:hover { background-color: #047857; }
        .dark .bg-blue-theme { background-color: #1e40af; }
        .dark .bg-gold-theme { background-color: #92400e; }
        .dark .bg-emerald-theme { background-color: #065f46; }
        .dark .text-blue-theme { color: #60a5fa; }
        .dark .text-gold-theme { color: #fbbf24; }
        .dark .text-emerald-theme { color: #34d399; }
        
        .input-field { 
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: border-color 0.15s ease-in-out;
        }
        .input-field:focus { 
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .dark .input-field {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        .dark .input-field:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }
        
        .sidebar {
            width: 260px;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        
        .sidebar-item {
            position: relative;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
        }
        
        .sidebar-item:hover::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 24px;
            width: 4px;
            background: linear-gradient(to bottom, #3b82f6, #60a5fa);
            border-radius: 0 4px 4px 0;
        }
        
        .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        .sidebar-item.active .sidebar-icon {
            color: #3b82f6;
        }
        
        .main-content {
            transition: margin-left 0.3s ease;
        }
        
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            background: white;
        }
        
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(to bottom right, #ef4444, #f87171);
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        }
        
        .profile-image {
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .nav-tab {
            position: relative;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .nav-tab:hover {
            background-color: #f3f4f6;
        }
        
        .nav-tab.active {
            color: #3b82f6;
            font-weight: 500;
        }
        
        .nav-tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            border-radius: 3px 3px 0 0;
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .status-online {
            background-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }
        
        .status-offline {
            background-color: #94a3b8;
            box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.3);
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }
        
        .featured-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }
        
        .payroll-status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .payroll-status-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }
        
        .payroll-status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .payroll-status-paid {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .payroll-status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .amount-positive {
            color: #059669;
            font-weight: 600;
        }
        
        .amount-negative {
            color: #dc2626;
            font-weight: 600;
        }
        
        .payroll-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .payroll-action-approve {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .payroll-action-reject {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .payroll-action-view {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Mobile Sidebar */
        .mobile-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .mobile-sidebar-overlay.active {
            display: block;
        }
        
        /* Dark mode adjustments */
        .dark .card {
            background-color: #374151;
            border-color: #4b5563;
        }
        
        .dark .sidebar {
            background-color: #1f2937;
            border-color: #374151;
        }
        
        .dark .sidebar-item:hover {
            background-color: #374151;
        }
        
        .dark .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.2);
        }
        
        .dark .featured-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
        }
        
        .dark .payroll-status-pending {
            background-color: #713f12;
            color: #fde047;
        }
        
        .dark .payroll-status-processing {
            background-color: #1e3a8a;
            color: #93c5fd;
        }
        
        .dark .payroll-status-paid {
            background-color: #14532d;
            color: #86efac;
        }
        
        .dark .payroll-status-failed {
            background-color: #7f1d1d;
            color: #fca5a5;
        }
        
        .dark .payroll-action-approve {
            background-color: #14532d;
            color: #86efac;
        }
        
        .dark .payroll-action-reject {
            background-color: #7f1d1d;
            color: #fca5a5;
        }
        
        .dark .payroll-action-view {
            background-color: #1e3a8a;
            color: #93c5fd;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                height: 100%;
                top: 0;
                left: 0;
                background: white;
            }
            
            .dark .sidebar {
                background-color: #1f2937;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100%;
            }
            
            .search-input {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .main-grid {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .featured-banner {
                text-align: center;
                padding: 1.5rem !important;
            }
            
            .featured-banner-content {
                padding-right: 0 !important;
            }
            
            .featured-banner img {
                display: none;
            }
            
            .payroll-period-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .payroll-period-grid {
                grid-template-columns: 1fr;
            }
            
            .header-title {
                font-size: 1.5rem;
            }
            
            .featured-banner {
                text-align: center;
            }
            
            .featured-banner-button {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <!-- Mobile Overlay -->
    <div class="mobile-sidebar-overlay" id="mobile-overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col py-6 px-4 fixed h-full z-10" id="sidebar">
        <div class="flex items-center justify-between px-2 mb-8">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gold-theme flex items-center justify-center">
                    <i class="fas fa-crown text-white text-xl"></i>
                </div>
                <span class="font-bold text-xl text-gray-900 dark:text-white">Monti Textile</span>
            </div>
            
            <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400" id="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="flex-1 space-y-1">
            <a href="{{ route('hrm.manager.dashboard') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
                <div class="sidebar-icon w-6 text-center">
                    <i class="fas fa-home"></i>
                </div>
                <span class="sidebar-text font-medium">Employee Information</span>
            </a>
            
            <a href="{{ route('hrm.manager.onboarding') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
                <div class="sidebar-icon w-6 text-center">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <span class="sidebar-text font-medium">Recruitment & Onboarding</span>
            </a>
            <a href="{{ route('hrm.manager.payroll') }}" class="sidebar-item flex items-center active space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 text-blue-theme">
                <div class="sidebar-icon w-6 text-center">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <span class="sidebar-text font-medium">Payroll Management</span>
            </a>
            <a href="{{ route('hrm.manager.analytics') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
                <div class="sidebar-icon w-6 text-center">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <span class="sidebar-text font-medium">HR Analytics & Reports</span>
            </a>
            
            <div class="py-4 px-4">
                <div class="border-t border-gray-200 dark:border-gray-700"></div>
            </div>
            
            <a href="#" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
                <div class="sidebar-icon w-6 text-center">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="sidebar-text font-medium">Settings</span>
            </a>
            
            <!-- Updated Logout Button -->
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
                <div class="sidebar-icon w-6 text-center">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <span class="sidebar-text font-medium">Logout</span>
            </a>
        </nav>
        
        <div class="px-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="bg-blue-50 dark:bg-blue-900 rounded-xl p-4">
                <div class="text-blue-800 dark:text-blue-200 font-medium text-sm mb-2">HR Manager Tools</div>
                <p class="text-blue-600 dark:text-blue-300 text-xs mb-3">Access advanced payroll management features</p>
                <button class="w-full bg-gold-theme hover:bg-gold-700 text-white py-2 rounded-lg text-xs font-medium transition-colors">
                    Admin Panel
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-64 min-h-screen flex flex-col" id="main-content">
        <!-- Top Header -->
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4 px-8 flex items-center justify-between sticky top-0 z-10">
            <div class="header-content flex items-center justify-between w-full">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Payroll Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Process & Approve Employee Salaries</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-search-toggle">
                            <i class="fas fa-search"></i>
                        </button>
                        
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">5</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-gold-100 dark:bg-gold-900 flex items-center justify-center text-gold-700 dark:text-gold-300 font-medium hidden md:flex">
                            HM
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Payroll Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-gold-100 dark:bg-gold-900 flex items-center justify-center mr-4">
                        <i class="fas fa-money-bill-wave text-gold-600 dark:text-gold-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Payroll</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">₱1,245,800</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mr-4">
                        <i class="fas fa-user-check text-emerald-600 dark:text-emerald-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Employees Paid</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">156</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Pending Approval</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">24</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-circle text-purple-600 dark:text-purple-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Discrepancies</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">3</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 main-grid">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Payroll Processing Banner -->
                    <div class="featured-banner">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="featured-banner-content mb-6 md:mb-0">
                                    <h2 class="text-2xl font-bold mb-3 text-white">Payroll Processing Center</h2>
                                    <p class="text-blue-100 mb-6 max-w-lg">Review, approve, and process payroll for all departments. Final authority for salary disbursements.</p>
                                    <button class="px-6 py-3 bg-gold-theme hover:bg-gold-600 text-white font-semibold rounded-xl transition-colors shadow-md flex items-center featured-banner-button" id="process-payroll-btn">
                                        <i class="fas fa-bolt mr-2"></i> Process Payroll Run
                                    </button>
                                </div>
                                <div class="featured-banner-image animate-float">
                                    <div class="w-48 h-32 bg-gradient-to-r from-gold-400 to-gold-300 dark:from-gold-500 dark:to-gold-400 rounded-lg shadow-xl flex items-center justify-center">
                                        <i class="fas fa-file-invoice-dollar text-white text-4xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payroll Period Management -->
                    <div class="card p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-xl text-gray-900 dark:text-white">Payroll Period Management</h3>
                            <div class="flex space-x-3">
                                <button class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm">
                                    <i class="fas fa-history mr-2"></i> View History
                                </button>
                                <button class="text-emerald-theme font-medium flex items-center hover:text-emerald-700 dark:hover:text-emerald-400 text-sm">
                                    <i class="fas fa-plus mr-2"></i> New Period
                                </button>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 payroll-period-grid">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-10 h-10 rounded-lg bg-gold-theme flex items-center justify-center">
                                        <i class="fas fa-calendar-check text-white text-lg"></i>
                                    </div>
                                    <span class="payroll-status-badge payroll-status-processing">PROCESSING</span>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Current Period</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Nov 1-15, 2023</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Progress</span>
                                        <span class="text-blue-theme font-medium">65%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-gold-theme h-2 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Due: Nov 30</span>
                                    <span>156/240</span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center">
                                        <i class="fas fa-check-circle text-white text-lg"></i>
                                    </div>
                                    <span class="payroll-status-badge payroll-status-paid">COMPLETED</span>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Last Period</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Oct 16-31, 2023</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Total Paid</span>
                                        <span class="text-emerald-theme font-medium">₱1,189,450</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-emerald-600 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Paid: Oct 31</span>
                                    <span>240/240</span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                                    </div>
                                    <span class="payroll-status-badge payroll-status-pending">UPCOMING</span>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Next Period</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Nov 16-30, 2023</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Starts In</span>
                                        <span class="text-blue-theme font-medium">3 days</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 15%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Starts: Nov 16</span>
                                    <span>Projected: ₱1.2M</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Payroll Manager Profile Card -->
                    <div class="card p-6">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-4">
                                <div class="profile-image w-20 h-20 rounded-full bg-gold-theme flex items-center justify-center text-white text-2xl font-bold">
                                    HM
                                </div>
                                <div class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-blue-theme flex items-center justify-center border-2 border-white dark:border-gray-800 cursor-pointer hover:bg-blue-700">
                                    <i class="fas fa-pen text-xs text-white"></i>
                                </div>
                            </div>
                            
                            <h2 class="font-bold text-lg text-gray-900 dark:text-white">Payroll Manager</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center justify-center">
                                <i class="fas fa-crown mr-1.5 text-gold-theme"></i> 
                                Senior Management
                            </p>
                            
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-5">
                                <div class="bg-gold-theme h-2.5 rounded-full" style="width: 95%"></div>
                            </div>
                            <div class="w-full flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                                <span>Approval Authority</span>
                                <span class="text-gray-900 dark:text-white font-medium">95%</span>
                            </div>
                            
                            <div class="w-full mt-5 grid grid-cols-2 gap-2">
                                <button class="py-3 bg-blue-theme hover:bg-blue-700 text-white rounded-xl font-medium transition-colors px-4">
                                    Audit Reports
                                </button>
                                <button class="py-3 bg-emerald-theme hover:bg-emerald-700 text-white rounded-xl font-medium transition-colors px-4">
                                    Tax Settings
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Payroll Actions -->
                    <div class="card p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                            <a href="#" class="text-blue-theme text-sm font-medium hover:text-blue-700 dark:hover:text-blue-400">More Tools</a>
                        </div>
                        
                        <div class="space-y-4">
                            <button class="w-full flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" id="generate-payslips">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-file-alt text-blue-600 dark:text-blue-300"></i>
                                    </div>
                                    <div class="text-left">
                                        <h4 class="font-medium text-gray-900 dark:text-white">Generate Payslips</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">For current period</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                            
                            <button class="w-full flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" id="export-reports">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-download text-emerald-600 dark:text-emerald-300"></i>
                                    </div>
                                    <div class="text-left">
                                        <h4 class="font-medium text-gray-900 dark:text-white">Export Reports</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">CSV, Excel, PDF</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                            
                            <button class="w-full flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" id="bank-transfer">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gold-100 dark:bg-gold-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-university text-gold-600 dark:text-gold-300"></i>
                                    </div>
                                    <div class="text-left">
                                        <h4 class="font-medium text-gray-900 dark:text-white">Bank Transfer</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">Initiate bulk transfer</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payroll Approval Queue -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white">Payroll Approval Queue</h3>
                    <div class="flex space-x-3">
                        <button class="px-4 py-2 bg-blue-theme hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center" id="filter-payroll">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <button class="px-4 py-2 bg-emerald-theme hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center" id="select-all-payroll">
                            <i class="fas fa-check-double mr-2"></i> Select All
                        </button>
                    </div>
                </div>
                
                <div class="card p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        <input type="checkbox" id="select-all-payroll-checkbox" class="rounded border-gray-300 text-blue-theme focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Basic Salary</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Allowances</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deductions</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Net Pay</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="payroll-table-body">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="payroll-checkbox rounded border-gray-300 text-blue-theme focus:ring-blue-500" data-id="1">
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-medium">
                                                SD
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Sarah Dela Cruz</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            Weaving
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">₱28,500</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Monthly</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-positive">+₱3,200</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Overtime: ₱2,800</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-negative">-₱2,450</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Tax: ₱1,850</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">₱29,250</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="payroll-status-badge payroll-status-pending">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="payroll-action-btn payroll-action-approve mr-2 approve-payroll-btn" data-id="1" data-name="Sarah Dela Cruz">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                        <button class="payroll-action-btn payroll-action-reject mr-2 reject-payroll-btn" data-id="1" data-name="Sarah Dela Cruz">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                        <button class="payroll-action-btn payroll-action-view view-payroll-btn" data-id="1">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="payroll-checkbox rounded border-gray-300 text-blue-theme focus:ring-blue-500" data-id="2">
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-medium">
                                                MP
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Michael Perez</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-002</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                            Dyeing
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">₱26,800</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Monthly</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-positive">+₱4,500</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Bonus: ₱3,000</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-negative">-₱2,150</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">SSS: ₱850</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">₱29,150</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="payroll-status-badge payroll-status-processing">
                                            Processing
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="payroll-action-btn payroll-action-approve mr-2 approve-payroll-btn" data-id="2" data-name="Michael Perez">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                        <button class="payroll-action-btn payroll-action-reject mr-2 reject-payroll-btn" data-id="2" data-name="Michael Perez">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                        <button class="payroll-action-btn payroll-action-view view-payroll-btn" data-id="2">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="payroll-checkbox rounded border-gray-300 text-blue-theme focus:ring-blue-500" data-id="3">
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 font-medium">
                                                AG
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Anna Gomez</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-003</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Finishing
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">₱24,500</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Monthly</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-positive">+₱2,800</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Allowance: ₱1,200</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-negative">-₱1,980</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">PhilHealth: ₱380</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">₱25,320</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="payroll-status-badge payroll-status-paid">
                                            Paid
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="payroll-action-btn payroll-action-view view-payroll-btn" data-id="3">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="payroll-checkbox rounded border-gray-300 text-blue-theme focus:ring-blue-500" data-id="4">
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 font-medium">
                                                RS
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Robert Santos</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-004</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Quality Control
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">₱27,300</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Monthly</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-positive">+₱1,500</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Attendance: ₱500</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm amount-negative">-₋₱3,200</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Loan: ₱1,500</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">₱25,600</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="payroll-status-badge payroll-status-failed">
                                            Discrepancy
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="payroll-action-btn payroll-action-approve mr-2 approve-payroll-btn" data-id="4" data-name="Robert Santos">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                        <button class="payroll-action-btn payroll-action-reject mr-2 reject-payroll-btn" data-id="4" data-name="Robert Santos">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                        <button class="payroll-action-btn payroll-action-view view-payroll-btn" data-id="4">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Bulk Actions Footer -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <span id="selected-payroll-count">0</span> payrolls selected
                        </div>
                        <div class="flex space-x-3">
                            <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium transition-colors" id="deselect-all-payroll">
                                Deselect All
                            </button>
                            <button class="px-4 py-2 bg-gold-theme hover:bg-gold-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center" id="bulk-approve-btn">
                                <i class="fas fa-check-double mr-2"></i> Approve Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Payroll Transactions -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white">Recent Payroll Transactions</h3>
                    <a href="#" class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm">
                        View All Transactions <i class="fas fa-chevron-right ml-2 text-xs"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="card p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="rounded-full w-12 h-12 bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 text-xl">
                                <i class="fas fa-money-check"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">₱1,189,450</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Oct 31, 2023</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-900 dark:text-white font-medium mb-2">October 2nd Half Payroll</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            240 employees processed
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                <i class="fas fa-check-circle mr-1"></i> Completed
                            </span>
                        </div>
                    </div>
                    
                    <div class="card p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="rounded-full w-12 h-12 bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 text-xl">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">₱1,245,800</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Processing</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-900 dark:text-white font-medium mb-2">November 1st Half Payroll</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            156/240 processed
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                <i class="fas fa-spinner fa-spin mr-1"></i> Processing
                            </span>
                        </div>
                    </div>
                    
                    <div class="card p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="rounded-full w-12 h-12 bg-gold-100 dark:bg-gold-900 flex items-center justify-center text-gold-600 dark:text-gold-300 text-xl">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">BIR 2316</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Due Dec 15</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-900 dark:text-white font-medium mb-2">Annual Tax Reports</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Year-end tax filing
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Payroll Approval Modal -->
    <div id="payroll-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 max-w-md w-full mx-4">
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-gold-100 dark:bg-gold-900 flex items-center justify-center text-gold-600 dark:text-gold-300 text-2xl mx-auto mb-4">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" id="modal-title">Approve Payroll</h3>
                <p class="text-gray-600 dark:text-gray-400" id="modal-description">Are you sure you want to approve this payroll?</p>
            </div>
            
            <div class="space-y-4 mb-6" id="payroll-details">
                <!-- Details will be inserted here -->
            </div>
            
            <div class="flex space-x-3">
                <button class="flex-1 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-xl font-medium transition-colors" id="cancel-payroll">
                    Cancel
                </button>
                <button class="flex-1 py-3 bg-gold-theme hover:bg-gold-600 text-white rounded-xl font-medium transition-colors" id="confirm-payroll">
                    Confirm Approval
                </button>
            </div>
        </div>
    </div>

    <!-- Payroll Rejection Modal -->
    <div id="rejection-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 max-w-md w-full mx-4">
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 text-2xl mx-auto mb-4">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Reject Payroll</h3>
                <p class="text-gray-600 dark:text-gray-400" id="rejection-description">Please provide a reason for rejecting this payroll.</p>
            </div>
            
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Rejection</label>
                    <select class="w-full input-field" id="rejection-reason">
                        <option value="">Select a reason</option>
                        <option value="discrepancy">Salary Discrepancy</option>
                        <option value="attendance">Attendance Issues</option>
                        <option value="documents">Missing Documents</option>
                        <option value="calculation">Calculation Error</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div id="other-reason-container" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Specify Reason</label>
                    <textarea class="w-full input-field" rows="3" id="other-reason" placeholder="Please specify the reason..."></textarea>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <button class="flex-1 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-xl font-medium transition-colors" id="cancel-rejection">
                    Cancel
                </button>
                <button class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-colors" id="confirm-rejection">
                    Confirm Rejection
                </button>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        
        // Payroll functionality
        const processPayrollBtn = document.getElementById('process-payroll-btn');
        const selectAllPayrollBtn = document.getElementById('select-all-payroll');
        const selectAllPayrollCheckbox = document.getElementById('select-all-payroll-checkbox');
        const deselectAllPayrollBtn = document.getElementById('deselect-all-payroll');
        const bulkApproveBtn = document.getElementById('bulk-approve-btn');
        const payrollCheckboxes = document.querySelectorAll('.payroll-checkbox');
        const approveBtns = document.querySelectorAll('.approve-payroll-btn');
        const rejectBtns = document.querySelectorAll('.reject-payroll-btn');
        const viewBtns = document.querySelectorAll('.view-payroll-btn');
        const payrollModal = document.getElementById('payroll-modal');
        const rejectionModal = document.getElementById('rejection-modal');
        const cancelPayrollBtn = document.getElementById('cancel-payroll');
        const confirmPayrollBtn = document.getElementById('confirm-payroll');
        const cancelRejectionBtn = document.getElementById('cancel-rejection');
        const confirmRejectionBtn = document.getElementById('confirm-rejection');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const payrollDetails = document.getElementById('payroll-details');
        const rejectionReason = document.getElementById('rejection-reason');
        const otherReasonContainer = document.getElementById('other-reason-container');
        const otherReason = document.getElementById('other-reason');
        
        // Quick action buttons
        const generatePayslipsBtn = document.getElementById('generate-payslips');
        const exportReportsBtn = document.getElementById('export-reports');
        const bankTransferBtn = document.getElementById('bank-transfer');
        
        let selectedPayroll = [];
        let payrollAction = 'single'; // 'single' or 'bulk'
        let currentPayrollId = null;
        let currentPayrollName = null;
        let currentPayrollAction = 'approve'; // 'approve' or 'reject'
        
        // Function to toggle sidebar
        function toggleSidebar() {
            if (window.innerWidth < 1024) {
                // Mobile behavior
                sidebar.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            } else {
                // Desktop behavior
                sidebar.classList.toggle('collapsed');
                mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '260px';
            }
        }
        
        // Function to close sidebar on mobile
        function closeSidebar() {
            if (window.innerWidth < 1024) {
                sidebar.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        // Event listeners
        sidebarToggle.addEventListener('click', toggleSidebar);
        mobileMenuToggle.addEventListener('click', toggleSidebar);
        mobileOverlay.addEventListener('click', closeSidebar);
        
        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            // Handle responsive behavior on load
            if (window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
            }
            
            // Initialize selected payroll count
            updateSelectedPayrollCount();
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
                sidebar.classList.remove('collapsed');
                
                // Close sidebar if open when resizing to mobile
                if (sidebar.classList.contains('active')) {
                    document.body.style.overflow = '';
                }
            } else {
                // Reset to desktop behavior
                mobileOverlay.classList.remove('active');
                sidebar.classList.remove('active');
                document.body.style.overflow = '';
                
                // Apply collapsed state if needed
                mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '260px';
            }
        });
        
        // Update selected payroll count
        function updateSelectedPayrollCount() {
            const selected = document.querySelectorAll('.payroll-checkbox:checked');
            const count = selected.length;
            document.getElementById('selected-payroll-count').textContent = count;
            
            // Update select all checkbox state
            const total = payrollCheckboxes.length;
            selectAllPayrollCheckbox.checked = count === total && total > 0;
            selectAllPayrollCheckbox.indeterminate = count > 0 && count < total;
        }
        
        // Select all payroll functionality
        selectAllPayrollBtn.addEventListener('click', () => {
            payrollCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectedPayrollCount();
            showToast('All payrolls selected for approval', 'info');
        });
        
        selectAllPayrollCheckbox.addEventListener('change', () => {
            payrollCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllPayrollCheckbox.checked;
            });
            updateSelectedPayrollCount();
        });
        
        // Deselect all functionality
        deselectAllPayrollBtn.addEventListener('click', () => {
            payrollCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedPayrollCount();
            showToast('All payrolls deselected', 'info');
        });
        
        // Individual checkbox change
        payrollCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedPayrollCount);
        });
        
        // Process payroll run
        processPayrollBtn.addEventListener('click', () => {
            showToast('Initiating payroll processing for current period...', 'info');
            
            // Simulate processing
            setTimeout(() => {
                showToast('Payroll processing completed successfully!', 'success');
            }, 2000);
        });
        
        // Bulk approve selected payroll
        bulkApproveBtn.addEventListener('click', () => {
            const selected = Array.from(payrollCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => {
                    const row = cb.closest('tr');
                    const name = row.querySelector('.text-sm.font-medium').textContent;
                    const netPay = row.querySelector('td:nth-child(7) .text-lg').textContent;
                    const status = row.querySelector('.payroll-status-badge').textContent;
                    return { name, netPay, status };
                });
            
            if (selected.length === 0) {
                showToast('Please select payrolls to approve', 'warning');
                return;
            }
            
            payrollAction = 'bulk';
            currentPayrollAction = 'approve';
            
            modalTitle.textContent = 'Approve Selected Payroll';
            modalDescription.textContent = `You are about to approve ${selected.length} selected payrolls.`;
            
            let detailsHtml = `
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Payrolls to be approved:</h4>
                    <ul class="space-y-2 max-h-40 overflow-y-auto">
            `;
            
            selected.forEach(payroll => {
                detailsHtml += `
                    <li class="flex items-center text-sm">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        <span class="text-gray-700 dark:text-gray-300">${payroll.name}</span>
                        <span class="ml-auto text-gray-500 dark:text-gray-400">${payroll.netPay}</span>
                    </li>
                `;
            });
            
            detailsHtml += `
                    </ul>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900 rounded-lg p-4">
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        This action will initiate payment processing for selected employees.
                    </p>
                </div>
            `;
            
            payrollDetails.innerHTML = detailsHtml;
            payrollModal.classList.remove('hidden');
        });
        
        // Individual approve buttons
        approveBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                payrollAction = 'single';
                currentPayrollAction = 'approve';
                currentPayrollId = btn.getAttribute('data-id');
                currentPayrollName = btn.getAttribute('data-name');
                
                const row = btn.closest('tr');
                const department = row.querySelector('td:nth-child(3) span').textContent;
                const basicSalary = row.querySelector('td:nth-child(4) .text-sm').textContent;
                const allowances = row.querySelector('td:nth-child(5) .text-sm').textContent;
                const deductions = row.querySelector('td:nth-child(6) .text-sm').textContent;
                const netPay = row.querySelector('td:nth-child(7) .text-lg').textContent;
                
                modalTitle.textContent = `Approve Payroll for ${currentPayrollName}`;
                modalDescription.textContent = `You are about to approve this payroll for processing.`;
                
                payrollDetails.innerHTML = `
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Employee:</span>
                                <span class="font-medium text-gray-900 dark:text-white">${currentPayrollName}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Department:</span>
                                <span class="font-medium text-gray-900 dark:text-white">${department}</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">Basic Salary:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${basicSalary}</span>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">Allowances:</span>
                                    <span class="font-medium text-green-600 dark:text-green-400">${allowances}</span>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">Deductions:</span>
                                    <span class="font-medium text-red-600 dark:text-red-400">${deductions}</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <span class="text-gray-900 dark:text-white">Net Pay:</span>
                                    <span class="text-gold-600 dark:text-gold-400">${netPay}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                payrollModal.classList.remove('hidden');
            });
        });
        
        // Individual reject buttons
        rejectBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                currentPayrollId = btn.getAttribute('data-id');
                currentPayrollName = btn.getAttribute('data-name');
                
                const row = btn.closest('tr');
                const netPay = row.querySelector('td:nth-child(7) .text-lg').textContent;
                
                document.getElementById('rejection-description').textContent = `Reject payroll for ${currentPayrollName} (${netPay})`;
                rejectionModal.classList.remove('hidden');
            });
        });
        
        // View payroll details
        viewBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const payrollId = this.getAttribute('data-id');
                const row = this.closest('tr');
                const name = row.querySelector('.text-sm.font-medium').textContent;
                const netPay = row.querySelector('td:nth-child(7) .text-lg').textContent;
                
                showToast(`Viewing payroll details for ${name} (${netPay})`, 'info');
            });
        });
        
        // Quick action buttons
        generatePayslipsBtn.addEventListener('click', () => {
            showToast('Generating payslips for current period...', 'info');
            setTimeout(() => {
                showToast('Payslips generated successfully!', 'success');
            }, 1500);
        });
        
        exportReportsBtn.addEventListener('click', () => {
            showToast('Exporting payroll reports...', 'info');
            setTimeout(() => {
                showToast('Reports exported successfully!', 'success');
            }, 1500);
        });
        
        bankTransferBtn.addEventListener('click', () => {
            showToast('Initiating bank transfer process...', 'info');
            setTimeout(() => {
                showToast('Bank transfer initiated successfully!', 'success');
            }, 1500);
        });
        
        // Cancel payroll approval
        cancelPayrollBtn.addEventListener('click', () => {
            payrollModal.classList.add('hidden');
        });
        
        // Confirm payroll approval
        confirmPayrollBtn.addEventListener('click', () => {
            payrollModal.classList.add('hidden');
            
            if (payrollAction === 'single') {
                // Update single payroll
                const row = document.querySelector(`.payroll-checkbox[data-id="${currentPayrollId}"]`).closest('tr');
                const statusCell = row.querySelector('td:nth-child(8)');
                
                // Update status
                const statusBadge = statusCell.querySelector('.payroll-status-badge');
                statusBadge.className = 'payroll-status-badge payroll-status-paid';
                statusBadge.textContent = 'Paid';
                
                // Disable action buttons
                const approveBtn = row.querySelector('.approve-payroll-btn');
                const rejectBtn = row.querySelector('.reject-payroll-btn');
                
                if (approveBtn) {
                    approveBtn.style.display = 'none';
                }
                if (rejectBtn) {
                    rejectBtn.style.display = 'none';
                }
                
                showToast(`${currentPayrollName}'s payroll approved successfully!`, 'success');
                
            } else if (payrollAction === 'bulk') {
                // Update all selected payrolls
                const selectedCheckboxes = Array.from(payrollCheckboxes).filter(cb => cb.checked);
                
                selectedCheckboxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const name = row.querySelector('.text-sm.font-medium').textContent;
                    const statusCell = row.querySelector('td:nth-child(8)');
                    
                    // Update status
                    const statusBadge = statusCell.querySelector('.payroll-status-badge');
                    if (statusBadge) {
                        statusBadge.className = 'payroll-status-badge payroll-status-paid';
                        statusBadge.textContent = 'Paid';
                    }
                    
                    // Disable action buttons
                    const approveBtn = row.querySelector('.approve-payroll-btn');
                    const rejectBtn = row.querySelector('.reject-payroll-btn');
                    
                    if (approveBtn) {
                        approveBtn.style.display = 'none';
                    }
                    if (rejectBtn) {
                        rejectBtn.style.display = 'none';
                    }
                });
                
                // Deselect all checkboxes
                payrollCheckboxes.forEach(cb => cb.checked = false);
                updateSelectedPayrollCount();
                
                showToast(`${selectedCheckboxes.length} payrolls approved successfully!`, 'success');
            }
        });
        
        // Handle rejection reason selection
        rejectionReason.addEventListener('change', () => {
            if (rejectionReason.value === 'other') {
                otherReasonContainer.classList.remove('hidden');
            } else {
                otherReasonContainer.classList.add('hidden');
            }
        });
        
        // Cancel rejection
        cancelRejectionBtn.addEventListener('click', () => {
            rejectionModal.classList.add('hidden');
            rejectionReason.value = '';
            otherReasonContainer.classList.add('hidden');
            otherReason.value = '';
        });
        
        // Confirm rejection
        confirmRejectionBtn.addEventListener('click', () => {
            const reason = rejectionReason.value === 'other' ? otherReason.value : rejectionReason.value;
            
            if (!reason) {
                showToast('Please provide a rejection reason', 'warning');
                return;
            }
            
            rejectionModal.classList.add('hidden');
            
            // Update payroll status
            const row = document.querySelector(`.payroll-checkbox[data-id="${currentPayrollId}"]`).closest('tr');
            const statusCell = row.querySelector('td:nth-child(8)');
            
            // Update status
            const statusBadge = statusCell.querySelector('.payroll-status-badge');
            statusBadge.className = 'payroll-status-badge payroll-status-failed';
            statusBadge.textContent = 'Rejected';
            
            // Add rejection note
            const actionsCell = row.querySelector('td:nth-child(9)');
            actionsCell.innerHTML = `
                <span class="text-xs text-gray-500 dark:text-gray-400" title="Reason: ${reason}">
                    <i class="fas fa-ban text-red-500 mr-1"></i> Rejected
                </span>
            `;
            
            showToast(`${currentPayrollName}'s payroll rejected. Reason: ${reason}`, 'error');
            
            // Reset form
            rejectionReason.value = '';
            otherReasonContainer.classList.add('hidden');
            otherReason.value = '';
        });
        
        function showToast(message, type) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${
                type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                type === 'warning' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                type === 'error' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' :
                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
            }`;
            toast.textContent = message;
            
            // Add to DOM
            document.body.appendChild(toast);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>