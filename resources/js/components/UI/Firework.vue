<template>
    <div class="firework-container">

    </div>
</template>

<script>
export default {
    mounted() {
        function createFirework() {
            // const colors = ['#ff6347', '#ff4500', '#dc143c', '#ff69b4', '#ff1493']; // Различные яркие цвета
            const colors = ['#FF2400', '#FF2B2B', '#900020', '#BC5D58', '#ffd700', '#ffa500'];

            const canvas = document.createElement('canvas');
            canvas.classList.add('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = 400;
            canvas.height = 400;

            const posX = Math.random() * window.innerWidth;
            const posY = Math.random() * window.innerHeight;

            canvas.style.left = posX + 'px';
            canvas.style.top = posY + 'px';

            document.querySelector('.firework-container').appendChild(canvas);

            const particles = [];

            for (let i = 0; i < 300; i++) { //колличество частиц
                particles.push({
                    x: canvas.width / 2, 
                    y: canvas.height / 2, 
                    radius: Math.random() * 3 + 1, // радиус частицы //РАЗМЕРЫ!
                    vx: Math.random() * 6 - 3, // скорость по x
                    vy: Math.random() * 6 - 3, // скорость по y
                    color: colors[Math.floor(Math.random() * colors.length)]
                });
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                particles.forEach((particle, index) => {
                    ctx.beginPath();
                    ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
                    ctx.fillStyle = particle.color;
                    ctx.fill();

                    particle.x += particle.vx;
                    particle.y += particle.vy;
                    particle.radius -= 0.05;

                    if (particle.radius < 0) {
                        particles.splice(index, 1);
                    }
                });

                requestAnimationFrame(draw);

                if (particles.length === 0) {
                    canvas.remove();
                }
            }

            draw();
        }

        setInterval(createFirework, 300); 
    }
}
</script>

<style>
.firework-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9998;
    margin: 0;
    padding: 0;
}

canvas.canvas {
    position: absolute;
    pointer-events: none;
}
</style>