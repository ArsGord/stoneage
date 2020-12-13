import img from '../Sprites/SpritesMap.png'

export default class Canvas {
    constructor(server) {
        this.server = server;
        this.canvas = document.getElementById('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.canvas.width = 800;
        this.canvas.height = 800;
        this.img = new Image();
        this.img.src = img;
        this.img.onload = () => { this.updateScene(); };
    }

    map = {};
    update = setInterval(() => { this.updateScene() }, 3000);
    gamerDirection = 'down';

    clInterval() {
        this.map = null;
        clearInterval(this.update);
    }

    async updateScene() {
        this.map = await this.server.checkHash();
        if (this.map && this.map.gamer) {
            this.gamer = this.map.gamer;
            this.drawMap();
            this.drawItem();
            this.drawGamers();
            this.drawGamer();
        }
    }

    drawMap() {
        if (this.map) {
            let shiftY = this.canvas.height / 2; // убрать
            let dx = 32;
            let dy = 16;
            let tiles = this.map.tiles;
            let count = 0;
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            for (let i = 0; i < this.map.map.height; i++) {
                for (let j = 0; j < this.map.map.width; j++) {
                    this.drawImage(tiles[count].name, j * dx + i * dx, -(j * dy) + (i * dy) + shiftY);
                    count++;
                }
            }
        }
    }

    drawItem() {
        if(this.map) {
            let shiftY = this.canvas.height / 2;
            let dx = 32;
            let dy = 16;
            let items = this.map.items;
            for (let i = 0; i < items.length; i++) {
                this.drawImage(items[i].name, items[i].x * dx + items[i].y * dx, -items[i].x * dy + items[i].y * dy + shiftY);
            }
        }
    }

    drawGamer() {
        let dx = 32;
        let dy = 16;
        let shiftY = this.canvas.width / 2;
        this.drawImage(this.gamerDirection, this.gamer.x * dx + this.gamer.y * dx, -this.gamer.x * dy + this.gamer.y * dy + shiftY);
    }

    drawGamers() {
        let dx = 32;
        let dy = 16;
        let shiftY = this.canvas.width / 2;
        for (let i = 0; i < this.map.gamers.length; i++) {
            if (this.map.gamers[i].id !== this.gamer.id) {
                this.drawImage('down', this.map.gamers[i].x * dx + this.map.gamers[i].y * dx, -this.map.gamers[i].x * dy + this.map.gamers[i].y * dy + shiftY);
            }
        }
    }

    async click(event) {
        const x = event.offsetX;
        const y = event.offsetY;
        const [sin, cos] = this.calcSinCos(x, y);
        let sinPiDiv = this.sinPiDiv;
        if (cos > 0) {
            if (sin > sinPiDiv(8 / 3)) {
                this.gamerDirection = 'up';
                await this.server.move('rightUp');
            } else if (sin > sinPiDiv(8)) {
                this.gamerDirection = 'rightUp';
                await this.server.move('right');
            } else if (sin > -sinPiDiv(8)) {
                this.gamerDirection = 'right';
                await this.server.move('rightDown');
            } else if (sin > -sinPiDiv(8 / 3)) {
                this.gamerDirection = 'rightDown';
                await this.server.move('down');
            } else {
                this.gamerDirection = 'down';
                await this.server.move('leftDown');
            }
        } else {
            if (sin > sinPiDiv(8 / 3)) {
                this.gamerDirection = 'up';
                await this.server.move('rightUp');
            } else if (sin > sinPiDiv(8)) {
                this.gamerDirection = 'leftUp';
                await this.server.move('up');
            } else if (sin > -sinPiDiv(8)) {
                this.gamerDirection = 'left';
                await this.server.move('leftUp');
            } else if (sin > -sinPiDiv(8 / 3)) {
                this.gamerDirection = 'leftDown';
                await this.server.move('left');
            } else {
                this.gamerDirection = 'down';
                await this.server.move('leftDown');
            }
        }
    }

    calcSinCos(x, y) {
        const hyp = Math.sqrt(Math.pow(this.sX(x), 2) + Math.pow(this.sY(y), 2));
        const sin = this.sY(y) / hyp;
        const cos = this.sX(x) / hyp;
        return [sin, cos];
    }

    sinPiDiv(num) {
        return Math.sin(Math.PI / num);
    }

    // координаты из экранных в декартовые
    sX(x) {
        return x - this.canvas.width / 2;
    }

    sY(y) {
        return this.canvas.height / 2 - y;
    }

    // координаты из декартовых в экранные
    xS(x) {
        return this.canvas.width / 2 + x;
    }

    yS(y) {
        return this.canvas.height / 2 - y;
    }

    drawImage(name, x, y) {
        switch (name) {
            case 'dirt':
                this.ctx.drawImage(this.img, 0, 0, 64, 48, x, y, 64, 48);
                break;
            case 'grass':
                this.ctx.drawImage(this.img, 64, 0, 64, 48, x, y, 64, 48);
                break;
            case 'snow':
                this.ctx.drawImage(this.img, 128, 0, 64, 48, x, y, 64, 48);
                break;
            case 'sand':
                this.ctx.drawImage(this.img, 192, 0, 64, 48, x, y, 64, 48);
                break;
            case 'water':
                this.ctx.drawImage(this.img, 256, 0, 64, 48, x, y, 64, 48);
                break;
            case 'fenceLeft':
                this.ctx.drawImage(this.img, 320, 0, 32, 48, x, y, 32, 48);
                break;
            case 'fenceDown':
                this.ctx.drawImage(this.img, 352, 0, 64, 48, x, y, 64, 48);
                break;
            case 'fenceRight':
                this.ctx.drawImage(this.img, 416, 0, 64, 48, x, y, 64, 48);
                break;
            case 'fenceUp':
                this.ctx.drawImage(this.img, 480, 0, 32, 48, x, y, 32, 48);
                break;
            case 'poppy':
                this.ctx.drawImage(this.img, 0, 48, 64, 48, x, y, 64, 48);
                break;
            case 'tree':
                this.ctx.drawImage(this.img, 64, 48, 64, 64, x, y - 24, 64, 64);
                break;
            case 'wood':
                this.ctx.drawImage(this.img, 128, 48, 32, 48, x + 16, y - 6, 32, 48);
                break;
            case 'rock':
                this.ctx.drawImage(this.img, 192, 48, 34, 48, x + 16, y - 6, 34, 48);
                break;
            case 'hut':
                this.ctx.drawImage(this.img, 0, 114, 148, 161, x, y - 94, 148, 161);
                break;
            case 'up':
                this.ctx.drawImage(this.img, 0, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'down':
                this.ctx.drawImage(this.img, 64, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'left':
                this.ctx.drawImage(this.img, 128, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'right':
                this.ctx.drawImage(this.img, 192, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'rightUp':
                this.ctx.drawImage(this.img, 256, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'leftUp':
                this.ctx.drawImage(this.img, 320, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'leftDown':
                this.ctx.drawImage(this.img, 384, 582, 64, 42, x, y - 8, 64, 42);
                break;
            case 'rightDown':
                this.ctx.drawImage(this.img, 448, 582, 64, 42, x, y - 8, 64, 42);
                break;
            default:
                break;
        }
    }
}