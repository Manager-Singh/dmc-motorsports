(function(){var lt=document&&document.currentScript&&document.currentScript.src;(window.webpackJsonpruntime=window.webpackJsonpruntime||[]).push([[2],{"/9aa":function(x,b,h){var C=h("NykK"),f=h("ExA7"),v="[object Symbol]";function S(T){return typeof T=="symbol"||f(T)&&C(T)==v}x.exports=S},DI7c:function(x,b,h){"use strict";h.r(b),h.d(b,"init",function(){return nt}),h.d(b,"insert",function(){return et}),h.d(b,"clean",function(){return st}),h.d(b,"getCurrentGallery",function(){return ot}),h.d(b,"initGallery",function(){return rt});var C=h("yXPU"),f=h.n(C),v=h("DzJC"),S=h.n(v),T=h("TtGZ"),M=h("WrkR");const{THUMBNAIL:P}=M.a,O=/(-)\d+(w\.[^\.]*?$)/;function w(u){return u.includes("/multi/opt/")}function d(u,s=P){const r=typeof s=="number"?Math.round(s):M.c[s]||160;return u.replace(O,`$1${r}$2`)}var A=h("AZZa"),y=h("NO3N"),j=h("qVr0"),N=h("x5tw"),p=h("C+iK"),k=h("stIE");class B{constructor(s){this.images=void 0,this.gallery=void 0,this.wrapImage=e=>{const a=e.find(">");return a.is(".thumbnailInnerWrapper")||a.wrapAll('<div class="thumbnailInnerWrapper" style="opacity:0"/>'),e},this.add=(e,a)=>{const i=a?0:this.images.length;return this.images.splice(i,0,this.wrapImage(e)),this.images},this.get=()=>this.images,this.getAsJQuery=()=>{const e=this.get();return $(e).map(function(){return this.toArray()})},this.clear=()=>{this.images=[]},this.swap=(e,a)=>{const i=this.images[a];return this.images.splice(a,1),this.images.splice(e,0,i),this.images},this.remove=e=>(this.images=this.images.filter(a=>a.attr("id")!==e),this.images),this.getImageAt=e=>e<this.images.length?this.images[e]:null,this.getNextImage=e=>{const a=e.attr("id"),i=Array.from(this.images).findIndex(n=>n.attr("id")===a);return i<0||i===this.images.length-1?null:this.images[i+1]},this.gallery=s;let r=Array.from(this.gallery.find("li.photoGalleryThumbs"));r.length&&r[0].hasAttribute("data-index")&&(r=r.sort((e,a)=>{const i=Number(e.dataset.index),n=Number(a.dataset.index);return(i||-1)>(n||-1)?1:-1})),this.images=r.map(e=>this.wrapImage($(e)))}}B.displayName="ImagesStack";function J(u){return u?u.jquery?u.get(0):u:null}const{SQUARE:D,VERTICAL:z,PINTEREST:V,PANORAMIC:X,ASYMETRIC:q,ASYMETRIC2:U,ASYMETRIC3:E,CLASSIC_ROUNDED:Y,CLASSIC_DROPS:_,PINTEREST_ROUNDED:K,VERTICAL_ROUNDED:F}=y.e;class m{constructor(s,r){this.layout=void 0,this.gallery=void 0,this.textLayout=void 0,this.imagesStack=void 0,this.layoutContainer=void 0,this.viewAll=void 0,this.galleryHolder=void 0,this.updateCaptionAlignment=()=>"captionAlignment-"+this.gallery.attr(`data-${this.device}-caption-alignment`)||!1,this.updateTextLayout=()=>{let t=this.gallery.attr(`data-${this.device}-text-layout`);return t||this.gallery.hasClass("upgradedGallery")&&(t=this.gallery.attr("data-text-layout")),t||y.f.BOTTOM},this.getNumberOfRow=(t,e)=>{const a=this.layout.numberOfImagesPerColumn,i=Math.floor(e/a);return t===1?i:Math.floor(i/t)},this.setLayout=t=>{t&&(this.gallery.attr("data-"+this.device+"-layout",t),this.layout=t)},this.get=()=>this.layout,this.getTextLayout=()=>this.textLayout,this.generateRow=(t,e="")=>$(`<div class='photogallery-row ${e}' data-index='${t}'/>`),this.generateColumn=(t,e="")=>$(`<div class='photogallery-column ${e}' data-index='${t}'/>`),this.generateImage=(t,e,a)=>(t.removeClass().addClass("photoGalleryThumbs "+(a||"")),t.attr("data-index",e),t),this.appendColumnsToRow=(t,e,a="")=>{for(let i=0;i<e;i++)t.append(this.generateColumn(i,`${a} column-${e}`))},this.getMaxHeight=t=>{let e=0;return t.each((a,i)=>{const n=$(i).height();n>e&&(e=n)}),e},this.generateLayoutContainer=()=>$('<div class="layout-container '+this.layout+'" />'),this.clearCaptionInlineHeight=t=>{this.getRows(t).find(".photogallery-column .caption-container").css("height","")},this.getRows=t=>t?t.closest(".photogallery-row"):this.gallery.find(".photogallery-row"),this.equalCaptionsHeight=t=>{const e=this.getRows(t);if(this.textLayout===y.f.OVER)e.find(".photogallery-column .caption-container").css("height","100%");else if(this.textLayout===y.f.FIXED)e.find(".photogallery-column .caption-container").css("height","auto");else switch(this.layout){case V:case K:e.each((a,i)=>{const n=$(i).find(".photogallery-column >:first-child .caption-container");n.css("height",""),n.height(this.getMaxHeight(n));const o=$(i).find(".photogallery-column >:last-child .caption-container");o.height(this.getMaxHeight(o))});break;case U:case E:e.each((a,i)=>{const n=$(i).find(".caption-container");n.css("height","");let o=0;n.each((l,g)=>{const c=$(g).height();c>o&&(o=c)}),n.height(o),$(i).find(".asymetric-big-image .caption-container").height(o*2)});break;default:e.each((a,i)=>{const n=$(i).find(".photogallery-column .caption-container");n.css("height",""),n.height(this.getMaxHeight(n))});break}},this.isEven=t=>t%2===0,this.findColumnByIndex=(t,e)=>t.find('.photogallery-column[data-index="'+e+'"]'),this.drawSquare=()=>{const t=this.imagesStack.get(),e=this.getNumberOfColumns();let a;for(let i=0;i<t.length;i++){const n=this.generateImage(t[i],i);i%e===0&&(a=this.generateRow(Math.floor(i/e)),this.layoutContainer.append(a),this.appendColumnsToRow(a,e));const o=i%e;this.findColumnByIndex(a,o).append(n)}},this.calculateImageHeight=t=>{const e=t.find("img"),a=e.attr("data-src");let i=t.attr("data-ratio");if(i)this.updateImageHeightByRatio(i,t);else{const n=e.attr("irh"),o=e.attr("irw");if(n&&o)i=n/o,this.updateImageHeightByRatio(i,t);else{const l=new Image;l.onload=()=>{const g=l.naturalHeight,c=l.naturalWidth;i=g/c,this.updateImageHeightByRatio(i,t)},l.src=a}}},this.updateImageHeightByRatio=(t,e)=>{const a=e.find("a");a.css("padding","inherit"),a.css("height",t*e.width())},this.drawPinterest=()=>{const t=this.imagesStack.get(),e=this.getNumberOfColumns()*1;let a,i,n,o=0;const l=this.isEven(e)===0,g=e===1?e:e*2;for(let c=0;c<t.length;c++){c%g===0&&(i=Math.floor(c/e),a=this.generateRow(i),this.layoutContainer.append(a),this.appendColumnsToRow(a,e)),o=c%e,n=this.findColumnByIndex(a,o);let I;this.isEven(c)&&this.isEven(o)&&n.children().length===0||(!this.isEven(c)||!l)&&!this.isEven(o)&&n.children().length===1?I=this.generateImage(t[c],c,"pinterest-low"):I=this.generateImage(t[c],c,"pinterest-high"),n.append(I)}},this.drawPanoramic=()=>{const t=this.imagesStack.get();let e;for(let a=0;a<t.length;a++){const i=this.generateImage(t[a],a,"panoramic-height");e=this.generateRow(Math.floor(a)),this.layoutContainer.append(e),e.append(this.generateColumn(0,"column-1")),e.find(".photogallery-column").append(i)}},this.drawVertical=()=>{const t=this.imagesStack.get(),e=this.getNumberOfColumns();let a;for(let i=0;i<t.length;i++){const n=this.generateImage(t[i],i,"vertical-height");i%e===0&&(a=this.generateRow(Math.floor(i/e)),this.layoutContainer.append(a),this.appendColumnsToRow(a,e));const o=i%e;this.findColumnByIndex(a,o).append(n)}},this.calculateAsymetricsColumns=()=>{const t=this.getNumberOfColumns()*1;if(t===1||!(this.layout===U||this.layout===E))return;const e=this.layout===E?2:1.5;let a;const i=100/t,n=Math.ceil(t/2),l=40/Math.floor(t/2),g=60/n,c=this.gallery.find(".photogallery-column"),I=c.eq(0).find("li").css("padding")||"0px";c.each((H,W)=>{const Q=$(W),it=Q.find(".image-container a");Q.hasClass("row-direction")?(Q.css("width",g+"%"),a=i/g*100+"%",it.css("padding-top",a),this.layout===E&&Q.find(".asymetric3-long-image .image-container a").css("padding-top",i/g*50+"%")):(Q.css("width",l+"%"),a=`calc(${i/l*100}% + ${I.replace("px","")*e}px)`,it.css("padding-top",a))})},this.drawAsymetric2=()=>{const t=this.imagesStack.get(),e=this.getNumberOfColumns();let a=0,i=this.generateRow(a),n=0,o=0,l=this.isEven(a),g;for(let c=0;c<t.length;c++){if(o===0){n===e*1&&(a++,i=this.generateRow(a),l=this.isEven(a),n=0),l=!l,o=l?1:4;const W=(l?"":"row-direction ")+"column-"+e;g=this.generateColumn(n,W),i.append(g),this.layoutContainer.append(i),n++}const I=l?"asymetric-big-image":"flex column width-50",H=this.generateImage(t[c],c,I);g.append(H),o--}},this.drawAsymetric3=()=>{const t=this.imagesStack.get(),e=this.getNumberOfColumns();let a=0,i=this.generateRow(a),n=0,o=0,l=!this.isEven(a),g;for(let c=0;c<t.length;c++){if(o===0){n===e*1&&(a++,i=this.generateRow(a),l=!this.isEven(a),n=0),l=!l,o=l?1:3;const W=(l?"":"row-direction ")+"column-"+e;g=this.generateColumn(n,W),i.append(g),this.layoutContainer.append(i),n++}let I;l?I="asymetric-big-image":o===1?I="flex column asymetric3-long-image":I="flex column width-50";const H=this.generateImage(t[c],c,I);g.append(H),o--}},this.getNumberOfColumns=({ignoreAutoAdjust:t}={})=>{let e=this.gallery.attr("data-"+this.device+"-columns");const a=this.gallery.attr("data-auto-adjust-columns")==="true";if(this.device===y.b.MOBILE&&(this.layout===U||this.layout===E))return"1";if(!e)if(this.device===y.b.DESKTOP)e="4";else if(this.device===y.b.TABLET)e=this.gallery.attr("data-desktop-columns")||"4";else{const n=(this.gallery.attr("data-desktop-columns")||4)*1;e=Math.min(2,n).toString()}const i=t||this.layout===U||this.layout===E||this.layout===X;if(a&&!i){const n=this.imagesStack.images.length,o=parseInt(e,10);return""+this.getAutoAdjustedNumberOfColumns(n,o)}return e},this.getAutoAdjustedNumberOfColumns=(t,e)=>{if(t<=e)return t;if(t%e===0)return e;let i=1;for(i=1;i<3;i++){if(e-i>1&&t%(e-i)===0)return e-i;if(t%(e+i)===0)return e+i}return e},this.draw=()=>{var t;this.layoutContainer&&this.layoutContainer.remove(),this.layoutContainer=this.generateLayoutContainer();const e=this.imagesStack.getAsJQuery();switch(e.css("background-image",""),e.find("a").attr("style",""),this.layout){case D:case Y:case _:case q:this.drawSquare();break;case V:case K:this.drawPinterest();break;case X:this.drawPanoramic();break;case z:case F:this.drawVertical();break;case U:this.drawAsymetric2();break;case E:this.drawAsymetric3();break}this.viewAll.length?this.layoutContainer.insertBefore(this.viewAll):this.layoutContainer.insertAfter(this.galleryHolder),this.calculateAsymetricsColumns();const a=J(this.gallery);a==null||(t=a.classList)===null||t===void 0||t.forEach(i=>{i.startsWith("text-layout-")&&this.gallery.removeClass(i)}),this.gallery.removeClass(this.captionAlignment),this.textLayout=this.updateTextLayout(),this.captionAlignment=this.updateCaptionAlignment(),this.gallery.addClass("text-layout-"+this.textLayout),this.gallery.addClass(this.captionAlignment),this.gallery.addClass("photo-gallery-done"),this.layoutContainer.find(".photogallery-row").addClass("photogallery-hidden-row")},this.isCaptionElementVisible=(t,e)=>{const a=t.find(".caption-inner"),i=t.find(".caption-container");return a.length>0?a.css("display")==="none"||i.css("display")==="none"?!1:t.find(e).css("display")!=="none":!1},this.gallery=s,this.layout=this.gallery.attr("data-"+this.device+"-layout")||this.gallery.attr("data-desktop-layout")||D,this.textLayout=this.updateTextLayout(),this.captionAlignment=this.updateCaptionAlignment(),this.imagesStack=r,this.viewAll=this.gallery.find(".photoGalleryViewAll"),this.galleryHolder=this.gallery.find(".dmPhotoGalleryHolder"),this.gallery.find(".layout-container").length&&this.gallery.find(".layout-container").remove()}get device(){return p.getCurrentLayoutDevice()}}m.displayName="LayoutProvider";const{inEditorMode:L,inPreviewMode:R,inRuntimeMode:Z}=p,at=500;class tt{constructor(s){var r=this;this.layoutProvider=void 0,this.imagesStack=void 0,this.gallery=void 0,this.galleryType=void 0,this.galleryId=void 0,this.rowsToShow=void 0,this.rows=void 0,this.imagesToUnveil=void 0,this.viewImagesButton=void 0,this.animationDelay=0,this.enableLazyLoading=void 0,this.unveilThreshold=void 0,this.init=t=>{this.getElementDimensions=this.getElementDimensions.bind(this),this.gallery=t,this.galleryId=this.gallery.attr("id"),this.galleryType=this.gallery.attr("data-link-gallery")&&this.gallery.attr("data-link-gallery")==="true"?"link":"photoSwipe",this.rowsToShow=this.getRowsToShow(),this.enableLazyLoading=this.getLazyLoading(),this.viewImagesButton=this.gallery.find(".photoGalleryViewAll"),this.imagesStack=new B(this.gallery),this.imagesToUnveil=[],this.animation=this.gallery.attr("data-image-animation")||"none",this.layoutProvider=new m(this.gallery,this.imagesStack),this.initLayout()},this.initLayout=(t,e)=>{this.unveilThreshold=this.animation?0:at,this.cleanAnchors(),this.layoutProvider.setLayout(t),this.layoutProvider.draw(),this.rows=this.gallery.find(".photogallery-row"),this.manageRowsVisibility(),this.initUnveilImages({skipAnimation:e}),this.addEvents(e),this.initLinks()},this.getLazyLoading=()=>{const t=this.gallery.attr("data-enable-lazy-loading");return!t||t==="true"},this.initLinks=()=>{this.imagesStack.get().forEach(t=>{const e=$(t).find(".image-container a"),a=e.find("img"),i=e.attr("href")||"",n=a.attr("data-src")||"";i&&n===i&&i.length&&e.attr("href","")})},this.changeRowsToShow=t=>{const e=this.isInstagramConnected()?"data-"+this.device+"-rows-to-show":"data-rows-to-show";this.gallery.attr(e,t),this.rowsToShow=t,this.initLayout()},this.getRowsToShow=()=>this.isInstagramConnected()?this.gallery.attr("data-"+this.device+"-rows-to-show"):this.gallery.attr("data-rows-to-show")||"4",this.manageRowsVisibility=()=>{let t;const e=this.gallery.attr(A.a.VIEW_MORE_VISIBILITY_ATTRIBUTE);this.rowsToShow==="100"?t=this.rows:(this.viewImagesButton.attr("data-mode")||"all")==="all"?(t=this.rows.slice(0,this.rowsToShow),this.viewImagesButton.text(this.viewImagesButton.attr("data-viewall"))):(t=this.rows,this.viewImagesButton.text(this.viewImagesButton.attr("data-viewless"))),e!=="false"&&this.rows.length>this.rowsToShow?this.viewImagesButton.show():this.viewImagesButton.hide(),t.removeClass("photogallery-hidden-row")},this.handleViewMoreVisibleChange=t=>{t==="false"&&this.viewImagesButton.attr("data-mode","all"),this.initLayout()},this.onUnveil=t=>{if(!this.enableLazyLoading){this.imagesToUnveil=[],this.revealElements(this.imagesStack.getAsJQuery(),t);return}if(!Object(T.b)(this.gallery[0],this.unveilThreshold))return;const e=this.imagesToUnveil.filter((a,i)=>Object(T.b)(i,this.unveilThreshold));e.length&&(this.imagesToUnveil=this.imagesToUnveil.not(e),this.revealElements(this.isInPopup()?this.imagesStack.getAsJQuery():e,t))},this.initUnveilImages=(t={})=>{const e=p.getSiteLayout(this.device),a=e===8||e===7?$("#iscrollBody"):$(window);this.imagesToUnveil=this.imagesStack.getAsJQuery();const i=`touchmove.unveil-${this.galleryId}
        scroll.unveil-${this.galleryId}
        resize.unveil-${this.galleryId}
        lookup.unveil-${this.galleryId} `;return a.off(i).on(i,S()(()=>this.onUnveil(t.skipAnimation),500)),this.onUnveil(t.skipAnimation),this},this.getImagePhotoswipeObject=t=>{if(!t.length)return null;const e=t.find("img"),a=t.find(".caption-title"),i=e.attr("data-src");let n="";this.layoutProvider.isCaptionElementVisible(t,".caption-text")&&t.find(".caption-text").contents().filter(l=>l.nodeType!==3).each((l,g)=>{n+=g.textContent.trim()+" "});const o=new Image;return o.src=i,{w:o.width,h:o.height,src:i,el:t,author:a.length?a.text().trim():"",title:n||""}},this.getImagesAsPhotoswipeItems=t=>t.map(e=>this.getImagePhotoswipeObject($(e))),this.initPhotoSwipeFromDOM=t=>{this.imagesStack.getAsJQuery().off("click.photoSwipe").on("click.photoSwipe",e=>{e.preventDefault&&e.preventDefault(),e.stopPropagation&&e.stopPropagation();const a=e.target||e.srcElement,i=$(a).closest("li"),n=i.attr("data-index");this.openPhotoSwipe(n,i)})},this.openPhotoSwipe=(t,e)=>{const a=document.querySelectorAll(".pswp")[0],i={galleryUID:this.galleryId,index:t*1,shareEl:!this.gallery.attr("data-hide-share")},n=this.getImagesAsPhotoswipeItems(this.imagesStack.get());this.photoSwipeGallery=new window.PhotoSwipe(a,window.PhotoSwipeUI_Default,n,i),this.photoSwipeGallery.listen("gettingData",(o,l)=>{if(l.w<1||l.h<1){const g=new Image,c=this.photoSwipeGallery;g.onload=function(){l.w=this.width,l.h=this.height,l.needsUpdate=!0,c.updateSize(!0)},g.src=l.src}}),this.photoSwipeGallery.init()},this.revealElements=(t,e)=>{let a=100;Array.from(t).filter(i=>i.querySelector("[data-src]")).forEach(function(){var i=f()(function*(n){const o=$(n);if(r.animation&&(n.style.setProperty("animation-delay",`${a}ms`),a+=100),!n.querySelector("[data-src]").getAttribute("data-src"))return;const g=n.querySelector(".image-container");g.querySelectorAll("a").forEach(I=>{const H=I.querySelector("[data-src]").getAttribute("data-src");if(!H)return;const W=r.getSourceByDevice(H,o);requestAnimationFrame(()=>{I.style.setProperty("background-image",`url('${W}')`)})}),yield N.c($(g),{background:!0}),g.classList.add("revealed"),r.layoutProvider.get()===y.e.ASYMETRIC&&r.oldLayoutFix({thumb:o})&&(yield r.waitForTransition(g)),g.closest(".thumbnailInnerWrapper").style.setProperty("opacity","1")});return function(n){return i.apply(this,arguments)}}()),this.layoutProvider.getTextLayout()===y.f.BOTTOM?this.layoutProvider.equalCaptionsHeight(t):this.layoutProvider.clearCaptionInlineHeight(t),e||(t.removeClass("animated "+this.animation),t.addClass("animated "+this.animation))},this.getSourceByDevice=(t,e)=>{if(L()&&!R()||this.gallery.attr("data-dm-multisize-skip-opt")==="true")return t;{if(this.isSignedUrl(t))return t;const{width:a,height:i}=this.getElementDimensions(e);if(Object(j.a)("feature.flag.photo.gallery.exact.size")){const o=a>=i,l=o?i/4:a/4,g=(o?a:i)+l;return this.replaceSourcePath(t,g)}else return a>=i?a<=160&&i<=90?this.replaceSourcePath(t,"thumbnail"):a<=640?this.replaceSourcePath(t,"mobile"):a<=1280?this.replaceSourcePath(t,"tablet"):t:a<=160&&i<=90?this.replaceSourcePath(t,"thumbnail"):this.device==="mobile"?this.replaceSourcePath(t,"mobile"):a<=1280?this.replaceSourcePath(t,"tablet"):t}},this.updateLazyLoading=t=>{this.enableLazyLoading=t},this.changeTextLayout=t=>{this.gallery.attr("data-desktop-text-layout",t),this.initLayout()},this.changeNumberOfColumns=t=>{this.gallery.attr("data-desktop-columns",this.numberOfColumns),this.initLayout()},this.onViewImagesClicked=t=>{t.preventDefault(),t.stopPropagation();const e=this.viewImagesButton.attr("data-mode")||"all";this.viewImagesButton.attr("data-mode",e==="all"?"less":"all"),this.initLayout()},this.cleanAnchors=()=>{this.imagesStack.getAsJQuery().find(".image-container a").css("background-image","")},this.addEvents=t=>{const e=this.gallery.find(".caption-button");if(this.viewImagesButton.off("click.viewallbutton").on("click.viewallbutton",this.onViewImagesClicked),R()||Z()){const a=this.gallery.find(".image-container > a");if(a.off("click.photogallery").on("click.photogallery",function(i){(!this.getAttribute("href")||this.getAttribute("href")===this.getAttribute("data-image-url"))&&i.preventDefault()}),R()?k.a(e):e.on("click",i=>{i.stopPropagation()}),this.galleryType==="photoSwipe"){if(L()&&!R()){this.imagesStack.getAsJQuery().off("click.photoSwipe");return}this.initPhotoSwipeFromDOM()}else this.imagesStack.getAsJQuery().off("click.photoSwipe");k.c(a),k.c(e)}if(L()){const a=setInterval(()=>{var i;const n=(i=window)===null||i===void 0||(i=i.parent)===null||i===void 0||(i=i.$)===null||i===void 0?void 0:i.dmx;if(n)clearInterval(a),n.events&&(window.parent.$.dmx.events.on("siteHeightChange",()=>{this.onUnveil(t)}),window.parent.$.dmx.events.on("previewMobileOrientationRotated.photogallery-"+this.galleryId,()=>{this.initLayout()},!0,{scope:"page"}),window.parent.$.dmx.events.off("onePreviewToggle.photogallery-"+this.galleryId).on("onePreviewToggle.photogallery-"+this.galleryId,o=>{this.photoSwipeGallery&&this.photoSwipeGallery.close(),o&&o.preview?this.initLayout():this.imagesStack.getAsJQuery().off("click.photoSwipe")}));else return},300)}},this.getNumberOfColumns=()=>this.layoutProvider.getNumberOfColumns(),this.equalCaptionsHeight=t=>{this.layoutProvider.equalCaptionsHeight(t)},this.setLinkGallery=t=>{t?(this.galleryType="link",this.imagesStack.get().forEach(e=>{const a=$(e).find(".image-container a"),i=a.attr("data-link-url")||"";a.attr("href",i)})):(this.imagesStack.get().forEach(e=>{const a=$(e).find(".image-container a"),i=a.attr("href");a.attr("data-link-url",i)}),this.galleryType="photoSwipe"),this.initLayout()},this.initAnimation=(t,e)=>{this.gallery.find("li.photoGalleryThumbs").removeClass("animated "+e).addClass("animated "+t).css("animation-name",""),this.gallery.attr("data-image-animation",t),this.animation=t,this.initLayout()},this.getNextImage=t=>this.imagesStack.getNextImage(t),this.getId=()=>this.gallery[0].id,this.swapImages=(t,e)=>{this.imagesStack.swap(t,e),this.initLayout()},this.getImages=()=>this.imagesStack.get(),this.addImage=(t,e)=>{this.imagesStack.add($(t),e),this.initLayout()},this.removeImage=t=>{this.imagesStack.remove(t)},this.isInPopup=()=>this.gallery.closest("#dmPopup"),this.init(s)}get device(){return p.getCurrentLayoutDevice()}get animation(){return this._animation}set animation(s){if(this._animation!==s){if(s==="none"){this._animation=null;return}this._animation=s}}isInstagramConnected(){return this.gallery.attr(A.a.INSTAGRAM_USERNAME_ATTRIBUTE)}oldLayoutFix({thumb:s}){this.layoutProvider.calculateImageHeight(s);const r=this.gallery.attr("data-image-hover-effect");return this.animation&&r&&r!=="false"&&r!=="none"}waitForTransition(s){return new Promise(r=>{$(s).one("transitionend",r)})}getElementDimensions(s){const r=s.length?s[0]:s;try{const t=r.getBoundingClientRect();return{width:t.width,height:t.height}}catch(t){return{width:0,height:0}}}isSignedUrl(s){if(!s)return!1;try{const r=new URL(s);return r&&r.pathname&&r.pathname.startsWith("/s/")}catch(r){return!1}}replaceSourcePath(s,r){return w(s)||typeof r=="number"?d(s,r):s.replace(/\/multi\/(?:desktop\/|tablet\/|thumbnail\/|mobile\/)?/gi,`/multi/${r}/`)}}tt.displayName="PhotoGallery";let G=[];function nt(u={}){var s;const r=$(".dmPhotoGallery"),t=r.length;G=[],$.dmrt.components.photogallery={load(){},default:{ready(){},load(){}}},(s=$.dmrt)!==null&&s!==void 0&&(s=s.photogallery)!==null&&s!==void 0&&s.oldComponent&&($.dmrt.components.photogallery.oldComponent=Object.assign({},$.dmrt.photogallery.oldComponent));for(let e=0;e<t;e++)et(r.eq(e),u)}function et(u,s={}){var r;let t;u.hasClass("newPhotoGallery")?(u.data("initialized")&&!s.force?t=u.data("initialized"):(s.disableLazyLoading&&u.attr("data-enable-lazy-loading","false"),s.disableAnimation&&u.removeAttr("data-image-animation"),t=new tt(u),u.data("initialized",t)),G.push(t)):(r=$.dmrt.components)!==null&&r!==void 0&&r.photogallery.oldComponent&&$.dmrt.components.photogallery.oldComponent.default.ready()}function st(){}function ot(u){for(let s=0;s<G.length;s++)if(G[s].getId()===u)return G[s];return null}function rt(u){G||(G=[]);const s=new tt(u);u.data("initialized",s),G.push(s)}},DzJC:function(x,b,h){var C=h("sEfC"),f=h("GoyQ"),v="Expected a function";function S(T,M,P){var O=!0,w=!0;if(typeof T!="function")throw new TypeError(v);return f(P)&&(O="leading"in P?!!P.leading:O,w="trailing"in P?!!P.trailing:w),C(T,M,{leading:O,maxWait:M,trailing:w})}x.exports=S},QIyF:function(x,b,h){var C=h("Kz5y"),f=function(){return C.Date.now()};x.exports=f},TO8r:function(x,b){var h=/\s/;function C(f){for(var v=f.length;v--&&h.test(f.charAt(v)););return v}x.exports=C},jXQH:function(x,b,h){var C=h("TO8r"),f=/^\s+/;function v(S){return S&&S.slice(0,C(S)+1).replace(f,"")}x.exports=v},sEfC:function(x,b,h){var C=h("GoyQ"),f=h("QIyF"),v=h("tLB3"),S="Expected a function",T=Math.max,M=Math.min;function P(O,w,d){var A,y,j,N,p,k,B=0,J=!1,D=!1,z=!0;if(typeof O!="function")throw new TypeError(S);w=v(w)||0,C(d)&&(J=!!d.leading,D="maxWait"in d,j=D?T(v(d.maxWait)||0,w):j,z="trailing"in d?!!d.trailing:z);function V(m){var L=A,R=y;return A=y=void 0,B=m,N=O.apply(R,L),N}function X(m){return B=m,p=setTimeout(E,w),J?V(m):N}function q(m){var L=m-k,R=m-B,Z=w-L;return D?M(Z,j-R):Z}function U(m){var L=m-k,R=m-B;return k===void 0||L>=w||L<0||D&&R>=j}function E(){var m=f();if(U(m))return Y(m);p=setTimeout(E,q(m))}function Y(m){return p=void 0,z&&A?V(m):(A=y=void 0,N)}function _(){p!==void 0&&clearTimeout(p),B=0,A=k=y=p=void 0}function K(){return p===void 0?N:Y(f())}function F(){var m=f(),L=U(m);if(A=arguments,y=this,k=m,L){if(p===void 0)return X(k);if(D)return clearTimeout(p),p=setTimeout(E,w),V(k)}return p===void 0&&(p=setTimeout(E,w)),N}return F.cancel=_,F.flush=K,F}x.exports=P},tLB3:function(x,b,h){var C=h("jXQH"),f=h("GoyQ"),v=h("/9aa"),S=0/0,T=/^[-+]0x[0-9a-f]+$/i,M=/^0b[01]+$/i,P=/^0o[0-7]+$/i,O=parseInt;function w(d){if(typeof d=="number")return d;if(v(d))return S;if(f(d)){var A=typeof d.valueOf=="function"?d.valueOf():d;d=f(A)?A+"":A}if(typeof d!="string")return d===0?d:+d;d=C(d);var y=M.test(d);return y||P.test(d)?O(d.slice(2),y?2:8):T.test(d)?S:+d}x.exports=w}}])})();
