const depLeft = document.getElementById('depliantLeft');
const depRight = document.getElementById('depliantRight');
const all = document.querySelector('main');
const formLang = document.getElementById('formChoixLangue1');
let controlClickFormLang = true;

formLang.addEventListener('click',function(event){
    event.stopPropagation();
    controlClickFormLang = true;
});

depLeft.addEventListener('click',function(event){
    event.preventDefault();
    event.stopPropagation();
    const left = document.getElementById('left');
    left.style.display='block';
    left.style.position='absolute';
    left.style.zIndex=1;
    all.style.opacity='10%';
});

depRight.addEventListener('click',function(event){
    const right = document.getElementById('right');
    right.style.display='block';
    right.style.position='absolute';
    right.style.zIndex=1;
    all.style.opacity='10%';
    event.stopPropagation();
    event.preventDefault();
});

const repRight = document.querySelector('body:not(#right)');
const repLeft = document.querySelector('body:not(#left)');

repRight.addEventListener('click',function(event){
    const droit = document.getElementById('right');
    if((screen.width<=714) && (controlClickFormLang==true)){
        droit.style.display='none';
    }
    all.style.opacity='100%';
    event.stopPropagation();
});

repLeft.addEventListener('click',function(event){
    const gauche = document.getElementById('left');
    if(screen.width<=714){
        gauche.style.display='none';
    }
    all.style.opacity='100%';
    event.stopPropagation();
});