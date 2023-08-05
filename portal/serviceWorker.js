// const version = 1.0;
// const afidem_cache = `afidem-cache-${version}`;
const afidem_cache = `afidem-cache`;
const INTERNAL_ENDPOINT = [
  "http://127.0.0.1:8000",
  "https://afidemglobalresource.com.ng/backend/afidem",
];

const URLToIgnore = ["/api/transaction/report"];

const assets = ["/"];

// Install event: caching all necessary resources
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(afidem_cache).then((cache) => {
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
          return caches.open(afidem_cache).then(async (cache) => {
            const response = await cache.match(req);
            if (response) {
              console.table("response used cache ... ");
              return response;
            } else {
              data = {
                success: false,
                message: "Please connect to the internet to continue.",
              };
              sendMessage(data, event.clientId);
            }
          });
        } else {
          return fetch(event.request).then((fetchResponse) => {
            const cloneResponse = fetchResponse.clone();
            caches.open(afidem_cache).then((cache) => {
              cache.put(req, cloneResponse);
            });
            console.table("response used network ... ");
            return fetchResponse;
          });
        }
      })
    );
  } else {
    if (!navigator.onLine) {
      return caches.open(afidem_cache).then(async (cache) => {
        const response = await cache.match(event.request);
        if (response) {
          console.table("response used cache ... ");
          return response;
        } else {
          data = {
            success: false,
            message: "Please connect to the internet to continue.",
          };
          sendMessage(data, event.clientId);
        }
      });
    } else {
      event.respondWith(
        // Otherwise, fetch the request from the network
        fetch(event.request).then((fetchResponse) => {
          // Clone the response to cache it
          const cloneResponse = fetchResponse.clone();

          // Cache the fetched response
          caches.open(afidem_cache).then((cache) => {
            cache.put(event.request, cloneResponse);
          });

          return fetchResponse;
        })
      );
    }
  }
});

async function convertPostRequestToGet(cloneReq) {
  modifiedUrl = "";

  if (cloneReq.headers.get("Content-Type").includes("application/json")) {
    const data = await cloneReq.json();

    // Convert the JSON data to query parameters
    const params = new URLSearchParams();
    Object.keys(data).forEach((key) => {
      params.append(key, data[key]);
    });

    // Modify the request URL with the query parameters
    modifiedUrl = cloneReq.url + "?" + params.toString();
  } else {
    modifiedUrl = cloneReq.url;
  }

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

const sendMessage = async (msg, clientId) => {
  let allClients = [];
  if (clientId) {
    let client = await clients.get(clientId);
    allClients.push(client);
  } else {
    allClients = await clients.matchAll({ includeUncontrolled: true });
  }
  return Promise.all(
    allClients.map((client) => {
      // console.log('postMessage', msg, 'to', client.id);
      return client.postMessage(msg);
    })
  );
};
