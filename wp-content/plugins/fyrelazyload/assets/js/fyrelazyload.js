(function($) {
    $('img').each(function(index){
        if( $(this).data('src') && !$(this).hasClass('fyrelazy') ){
            $(this).addClass('fyrelazy');
        }
    });
    
    var pluginUrl = lazyLocation.pluginsUrl + '/fyrelazyload';
  
    var observer = lozad('.fyrelazy', {
        threshold: 0.2
        //threshold: 0.75
    });
    var pictureObserver = lozad('.fyrelazy-pic', {
        threshold: 0.1
    });
    var pictureObserveDelay = lozad('.fyrelazy-delay', {
        threshold: 1   
    });

    pictureObserveDelay.observe();
    observer.observe();   
    pictureObserver.observe(); 

    
    // var fyreLazyPriority = document.querySelector('.fyreLazyPriority');
    // observer.triggerLoad(fyreLazyPriority);
    // $('.fyrelazy').addClass('animate fadeIn');

// FIRE ON WINDOW EVENT
  // $(window).on('DOMContentLoaded resize scroll ajaxComplete', function(e) {
  //   ioImg(); 
  //   BackgroundLazyLoader();  
  // });  

    // function svgLink(){
    //     const svgImages = document.querySelectorAll('image[data-link]');
    //     const config = {
    //         rootMargin: '50px 0px',
    //         threshold: 0.01,
    //     };

    //     observer = new IntersectionObserver((entry, observer) => {
    //         console.log('entry:', entry);
    //         console.log('observer:', observer);
    //     }, config);
    //     // observer = new IntersectionObserver(entries => {
    //     //     console.log(entries);
    //     // });
    //     // observer = new IntersectionObserver((entries, config) => {
    //     //     entries.forEach(entry => {
    //     //         if (entry.intersectionRatio > 0) {
    //     //             console.log('in the view');
    //     //         } else {
    //     //             console.log('out of view');
    //     //         }
    //     //     });
    //     // });

    //     svgImages.forEach(image => {
    //         observer.observe(image);
    //         console.log('iamge', $(image).attr('data-link'));
    //     });


    // };
    // svgLink();

// LAZY LOAD IMAGES
    // function ioImg(){

    //     const images = document.querySelectorAll('img[data-src]');
    //     // const svgImages = document.querySelectorAll('image[data-link]');
    //     const config = {
    //         rootMargin: '50px 0px',
    //         threshold: 0.01,
    //     };

    //     let observer;

    //     if ('IntersectionObserver' in window) {

    //         observer = new IntersectionObserver(onChange, config);
    //         images.forEach(img => observer.observe(img));
    //         // svgImages.forEach(image => observer.observe(image));

    //     } else {
    //         console.log('%cIntersection Observers not supported', 'color: red');
    //         images.forEach(image => loadImage(image));
    //         // svgImages.forEach(image => loadSvgImage(image));
    //     } 

    // }
    // ioImg();

    // const loadImage = image => {
    //     image.classList.add('fade-in');
    //     image.src = image.dataset.src;
        
    // }

    // const loadSvgImage = svgimage => {
    //     // image.attr('xlink:href') = image.dataset.link;
    //     console.log('svgimgae',svgimage); 
    // }

    // function onChange(changes, observer) {
    //     changes.forEach(change => {
    //         if (change.intersectionRatio > 0) {
    //             // Stop watching and load the image
    //             loadImage(change.target);
    //             // loadSvgImage(change.target);
    //             observer.unobserve(change.target);
    //         }
            
    //     });
    // }


// LAZY LOAD BACKGROUND
    // function BackgroundNode({node, loadedClassName}) {
    //     let src = node.getAttribute('data-background');
    //     let show = (onComplete) => {
    //         requestAnimationFrame(() => {
    //             node.style.backgroundImage = `url(${src})`
    //             node.classList.add(loadedClassName);
    //             onComplete();
    //         })
    //     }

    //     return {
    //         node,

    //         // onComplete is called after the image is done loading. 
    //         load: (onComplete) => {
    //             let img = new Image();
    //             img.onload = show(onComplete);
    //             img.src = src;
    //         }
    //     }
    // }
    // let defaultOptions = {
    //     selector: '[data-background]',
    //     loadedClassName: 'loaded'
    // }

    // svg
    // function xLinkNode({node, loadedClassName}) {
    //     let xlink = node.getAttribute('data-link');
    //     let show = (onComplete) => {
    //         requestAnimationFrame(() => {
    //             // node.style.backgroundImage = `url(${link})`
    //             node.attr('xlink:href') = '${xlink}';
    //             node.classList.add(loadedClassName);
    //             onComplete();
    //         })
    //     }

    //     return {
    //         node,

    //         // onComplete is called after the image is done loading. 
    //         load: (onComplete) => {
    //             let img = new Image();
    //             img.onload = show(onComplete);
    //             img.src = xlink;
    //         }
    //     }
    // }

    // let svgOptions = {
    //     selector: '[data-link]',
    //     loadedClassName: 'loaded'
    // }

    // function BackgroundLazyLoader({selector, loadedClassName} = defaultOptions) {
    //     let nodes = [].slice.apply(document.querySelectorAll(selector))
    //         .map(node => new BackgroundNode({node, loadedClassName}));

    //     let callback = (entries, observer) => {
    //         entries.forEach(({target, isIntersecting}) => {   
    //             if (!isIntersecting) {
    //                 return;
    //             }

    //             let obj = nodes.find(it => it.node.isSameNode(target));
                
    //             if (obj) {
    //                 obj.load(() => {
    //                     // Unobserve the node:
    //                     observer.unobserve(target);
    //                     // Remove this node from our list:
    //                     nodes = nodes.filter(n => !n.node.isSameNode(target));
                        
    //                     // If there are no remaining unloaded nodes,
    //                     // disconnect the observer since we don't need it anymore.
    //                     if (!nodes.length) {
    //                         observer.disconnect();
    //                     }
    //                 });
    //             }
    //         })
    //     };
        
    //     let observer = new IntersectionObserver(callback);
    //     nodes.forEach(node => observer.observe(node.node));
    // };   

    // BackgroundLazyLoader();

// // LAZY LOAD VIDEO 
    // function loadVideo(){
    //     let videos = [].slice.call(document.querySelectorAll("[data-source]"));
    //     let observer;

    //     // if ('IntersectionObserver' in window) {

    //     //     observer = new IntersectionObserver(onChange, config);
    //     //     videos.forEach(video => observer.observe(video));

    //     // }

    //     if ("IntersectionObserver" in window) {

    //         videoObserver = new IntersectionObserver(function(videos, observer) {
    //             videos.forEach(function(video) {
    //                 console.log(video);
    //                 if (video.isIntersecting) {

    //                 }
    //             }); 
    //         });
    //     };
    //     console.log(videos);
    // };
    // loadVideo();
  //   var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));
  //   if ("IntersectionObserver" in window) {
  //   var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
  //     entries.forEach(function(video) {
  //       if (video.isIntersecting) {
  //         for (var source in video.target.children) {
  //           var videoSource = video.target.children[source];
  //           if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
  //             videoSource.src = videoSource.dataset.src;
  //           }
  //         }

  //         video.target.load();
  //         video.target.classList.remove("lazy");
  //         lazyVideoObserver.unobserve(video.target);
  //       }
  //     });
  //   });

  //   lazyVideos.forEach(function(lazyVideo) {
  //     lazyVideoObserver.observe(lazyVideo);
  //   });
  // }

})(jQuery);