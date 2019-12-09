

const showLocalNotification = (title, body, swRegistration) => {
  const options = {
    body:body,
    icon:"https://upload.wikimedia.org/wikipedia/commons/8/87/Google_Chrome_icon_%282011%29.png",
    vibrate: [500,110,500,110,450,110,200,110,170,40,450,110,200,110,170,40,500],
    sound:'https://notificationsounds.com/soundfiles/4e4b5fbbbb602b6d35bea8460aa8f8e5/file-sounds-1096-light.mp3'
    
  }
  swRegistration.showNotification(title, options)
}



self.addEventListener('push', function(event) {
  event.waitUntil(clients.matchAll({
    type: "window"
  }).then(function(clientList) {
        if (event.data) {
          showLocalNotification(event.data.json().title,event.data.json().body,self.registration);
        } else {
      }
  })); 
})
self.addEventListener('notificationclick',(event)=> {

})
