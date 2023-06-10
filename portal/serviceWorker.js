const afidem_cache = "afidem-v1";
const INTERNAL_ENDPOINT = [
  "http://127.0.0.1:8000",
  "https://afidemglobalresource.com.ng/backend/afidem",
];
const assets = [
  "./",
  //   "/index.html",
  //   "/css/style.css",
  //   "/js/app.js",
  //   "/images/coffee1.png",
  //   "/images/coffee2.png",
  //   "/images/coffee3.png",
  //   "/images/coffee4.png",
  //   "/images/coffee5.png",
  //   "/images/coffee6.png",
  //   "/images/coffee7.png",
  //   "/images/coffee8.png",
  //   "/images/coffee9.png"
];

// Install event: caching all necessary resources
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open("afidem_pages").then((cache) => {
      return cache.addAll(assets);
    })
  );
  self.skipWaiting();
});

// Fetch event: intercepting network requests
self.addEventListener("fetch", (event) => {
  if (event.request.method === "POST") {
    const cloneReq = event.request.clone();

    event.respondWith(
      convertPostRequestToGet(cloneReq).then((req) => {
        if (!navigator.onLine) {
          return caches.match(req).then((response) => {
            if (response) {
              console.table(response + " used cache ... ");
              return response;
            }
          });
        } else {
          return fetch(event.request).then((fetchResponse) => {
            const cloneResponse = fetchResponse.clone();
            caches.open("afidem_requests").then((cache) => {
              cache.put(req, cloneResponse);
            });
            console.table(fetchResponse + " used network ... ");
            return fetchResponse;
          });
        }
      })
    );
  } else {
    if (!navigator.onLine) {
      event.respondWith(
        caches.match(event.request).then((response) => {
          // Return the cached response if found
          if (response) {
            return response;
          }
        })
      );
    } else {
      event.respondWith(
        // Otherwise, fetch the request from the network
        fetch(event.request).then((fetchResponse) => {
          // Clone the response to cache it
          const cloneResponse = fetchResponse.clone();

          // Cache the fetched response
          caches.open("afidem_requests").then((cache) => {
            cache.put(event.request, cloneResponse);
          });

          return fetchResponse;
        })
      );
    }
  }
});

// ===================================================================================
//====================================================================================

// self.addEventListener("fetch", (event) => {
//   event.respondWith(start(event));
// });

// async function start(event) {
//   if (event.request.method === "POST") {
//     cloneReq = event.request.clone();
//     convertPostRequestToGet(cloneReq).then((req) => {
//       caches.match(req).then((response) => {
//         // Return the cached response if found
//         if (response) {
//           console.table(req + " AVAILABLE IN THE CACHE !");
//           return response;
//         } else {
//           console.table(req + " NOT AVAILABLE IN THE CACHE !");
//           return interceptAndCache(event.request);
//         }
//       });
//     });
//   } else {
//     caches.match(event.request).then((response) => {
//       // Return the cached response if found
//       req = event.request.clone();
//       console.table(event.request);
//       if (response) {
//         console.table(response);
//         console.table(req + " AVAILABLE IN THE CACHE !");
//         return response;
//       } else {
//         console.table(req + " NOT AVAILABLE IN THE CACHE !");
//         return interceptAndCache(event.request);
//       }
//     });
//   }
// }

// async function interceptAndCache(request) {
//   // Log the request
//   console.log("Request:", request.url);
//   if (request.method === "POST") {
//     cloneReq = request.clone();
//     modifiedRequest = "";
//     convertPostRequestToGet(cloneReq).then((req) => {
//       modifiedRequest = req;
//       return processCache(request, modifiedRequest);
//     });
//   } else {
//     return processCache(request, null);
//   }
// }

async function convertPostRequestToGet(cloneReq) {
  const data = await cloneReq.json();

  // Convert the JSON data to query parameters
  const params = new URLSearchParams();
  Object.keys(data).forEach((key) => {
    params.append(key, data[key]);
  });

  // Modify the request URL with the query parameters
  const modifiedUrl = cloneReq.url + "?" + params.toString();

  const modifiedRequest = new Request(cloneReq.url, {
    method: "GET",
    headers: cloneReq.headers,
    mode: cloneReq.mode,
    credentials: cloneReq.credentials,
    redirect: cloneReq.redirect,
    referrer: cloneReq.referrer,
    referrerPolicy: cloneReq.referrerPolicy,
  });

  return modifiedUrl;
}

// async function processCache(request, modifiedRequest) {
//   // Fetch the request from the network
//   const response = await fetch(request);

//   // Clone the response to be able to read it twice (once for caching, once for consuming)
//   const responseClone = response.clone();

//   // Log the response
//   console.log("Response:", responseClone);

//   // Cache the response
//   if (
//     request.url.includes(INTERNAL_ENDPOINT[0]) ||
//     request.url.includes(INTERNAL_ENDPOINT[1])
//   ) {
//     console.log("CACHED REQ :", request.url);

//     caches.open("afidem_api_cache").then((cache) => {
//       if (request.method === "POST") {
//         console.table(modifiedRequest);
//         cache.put(modifiedRequest, responseClone);
//       } else {
//         cache.put(request, responseClone);
//       }
//     });
//   } else {
//     caches.open("afidem_web_asset_cache").then((cache) => {
//       cache.put(request, responseClone);
//     });
//   }

//   // Return the original response
//   return response;
// }

// ===================================================================================
//====================================================================================
