const staticStartUpUno = "ryte-site-v1"
const assets = [
  "/",
  "/index.php",
  "/css/style.css",
  
]

self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(staticRyteCrypto).then(cache => {
      cache.addAll(assets)
    })
  )
})

self.addEventListener("fetch", fetchEvent => {
    fetchEvent.respondWith(
      caches.match(fetchEvent.request).then(res => {
        return res || fetch(fetchEvent.request)
      })
    )
  })