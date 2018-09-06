document.writeln("<div class=\"snow\" style=\"height:1200px; background-color:transparent;   position:fixed; left:0px; top:0px; right:0px; bottom:0px; pointer-events: none;z-index: 9999;\"><canvas width=\"1904\" height=\"913\" style=\"position: absolute;left: 0;top: 0;\"></canvas></div>");
$(function() {
if (/MSIE 6|MSIE 7|MSIE 8/.test(navigator.userAgent)) {
return
}
var container = document.querySelector(".snow");
if (/MSIE 9|MSIE 10/.test(navigator.userAgent)) {
$(container).bind('click mousemove', function(evt) {
this.style.display = 'none';
var x = evt.pageX, y = evt.pageY
if ($(document).scrollTop() > 0 || $(document).scrollTop() > 0) {
x = x - $(document).scrollLeft() + 1
y = y - $(document).scrollTop() + 1
}
evt.preventDefault();
evt.stopPropagation();
var under = document.elementFromPoint(x, y);
var evtType = evt.type === 'click' ? 'click' : 'mouseenter'
if (evt.type === 'click') {
$(under)[0].click();
} else {
$(under).trigger('mouseenter');
}
$('body').css('cursor', 'default')
this.style.display = '';
return false;
});
}
var containerWidth = $(container).width();
var containerHeight = $(container).height();
var particle;
var camera;
var scene;
var renderer;
var mouseX = 0;
var mouseY = 0;
var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;
var particles = [];
var particleImages = [new Image(),new Image(),new Image(),new Image(),new Image()];
particleImages[0].src = "/home/img/p1.png";
particleImages[1].src = "/home/img/p2.png";
particleImages[2].src = "/home/img/p3.png";
particleImages[3].src = "/home/img/p4.png";
particleImages[4].src = "/home/img/p5.png";
var snowNum = 50;
function init() {
camera = new THREE.PerspectiveCamera(75, containerWidth / containerHeight, 1, 10000);
camera.position.z = 1000;
scene = new THREE.Scene();
scene.add(camera);
renderer = new THREE.CanvasRenderer();
renderer.setSize(containerWidth, containerHeight);
for (var i = 0; i < snowNum; i++) {
var material = new THREE.ParticleBasicMaterial({ map: new THREE.Texture(particleImages[i % 5]) });
particle = new Particle3D(material);
particle.position.x = Math.random() * 2000 - 1000;
particle.position.y = Math.random() * 2000 - 1000;
particle.position.z = Math.random() * 2000 - 1000;
particle.scale.x = particle.scale.y = 1;
scene.add(particle);
particles.push(particle)
}
container.appendChild(renderer.domElement);
document.addEventListener("mousemove", onDocumentMouseMove, false);
document.addEventListener("touchstart", onDocumentTouchStart, false);
document.addEventListener("touchmove", onDocumentTouchMove, false);
setInterval(loop, 1000 / 50)
}
function onDocumentMouseMove(event) {
mouseX = event.clientX - windowHalfX;
mouseY = event.clientY - windowHalfY
}
function onDocumentTouchStart(event) {
if (event.touches.length === 1) {
event.preventDefault();
mouseX = event.touches[0].pageX - windowHalfX;
mouseY = event.touches[0].pageY - windowHalfY
}
}
function onDocumentTouchMove(event) {
if (event.touches.length === 1) {
event.preventDefault();
mouseX = event.touches[0].pageX - windowHalfX;
mouseY = event.touches[0].pageY - windowHalfY
}
}
function loop() {
for (var i = 0; i < particles.length; i++) {
var particle = particles[i];
if ($(window).scrollTop() < 1000) {
particle.scale.x = particle.scale.y = 1;
} else {
if (i > particles.length / 5 * 3) {
particle.scale.x = particle.scale.y = 0;
} else {
particle.scale.x = particle.scale.y = 0.8;
}
}
particle.updatePhysics();
with(particle.position) {
if (y < -1000) {
y += 2000
}
if (x > 1000) {
x -= 2000
} else {
if (x < -1000) {
x += 2000
}
}
if (z > 1000) {
z -= 2000
} else {
if (z < -1000) {
z += 2000
}
}
}
}
camera.position.x += (mouseX - camera.position.x) * 0.005;
camera.position.y += (-mouseY - camera.position.y) * 0.005;
camera.lookAt(scene.position);
renderer.render(scene, camera)
}
init()
});