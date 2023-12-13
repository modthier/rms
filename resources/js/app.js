import './bootstrap';

Echo.channel('orders')
    .listen('Hello', (e) => {
       var x = new Audio('http://krms.ms/noti/tone.mp3');
       x.play();
       
});