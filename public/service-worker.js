var CACHE_NAME = "airport-taxi-sharing-cache-v1";

var urlsToCache = [
  // "./",
  "./you-are-offline",
  "./assets/img/logo.jpg",
  "./assets/img/offline-logo.png",
  "./assets/img/alert.png",
  "./assets/img/loader.gif",
  "./assets/img/taxi.png",
  "./assets/img/airport-marker.png",
  "./assets/img/user-loc-marker.png",
  "./assets/img/titik-pengantaran.png",
  "./assets/img/bg-landing.jpg",
  "./assets/img/bg-login.jpg",
];

self.addEventListener("install", function (event) {
  // Perform install steps

  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      console.log("Opened cache");
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("fetch", function (event) {
  event.respondWith(
    caches
      .match(event.request)
      .then(function (response) {
        return response || fetch(event.request);
      })
      .catch(function () {
        return caches.match("https://jo.yokcaridok.id/you-are-offline");
      })
  );
});

self.addEventListener("activate", function (event) {
  var cacheAllowlist = CACHE_NAME;
  event.waitUntil(
    caches.keys().then(function (cacheNames) {
      return Promise.all(
        cacheNames.map(function (cacheName) {
          if (cacheAllowlist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

self.addEventListener("activate", function (event) {
  event.waitUntil(
    caches.keys().then(function (cacheNames) {
      return Promise.all(
        cacheNames
          .filter(function (cacheName) {
            // Return true if you want to remove this cache,
            // but remember that caches are shared across
            // the whole origin
          })
          .map(function (cacheName) {
            return caches.delete(cacheName);
          })
      );
    })
  );
});

function updateCache(request, response) {
  return caches.open(CACHE_NAME).then(function (cache) {
    return cache.put(request, response);
  });
}
