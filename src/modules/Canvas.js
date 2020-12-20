export default class Canvas {
    constructor(img, server) {
        this.server = server;
        this.img = img;
        this.canvas = document.getElementById('canvas');
        if (this.canvas) {
            this.ctx = this.canvas.getContext('2d');
            this.canvas.width = 800;
            this.canvas.height = 800;
        }
    }

    getShifts(gamer) {
        return {
            x: this.canvas.width / 2 - Number(gamer.x) * 32 - Number(gamer.y) * 32 - 32,
            y: this.canvas.height / 2 + Number(gamer.x) * 16 - Number(gamer.y) * 16 - 16
        }
    }

    drawMap(map, gamer) {
        if (map && gamer) {
            let shifts = this.getShifts(gamer);
            let dx = 32;
            let dy = 16;
            let tiles = map.tiles;
            let count = 0;
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            for (let i = 0; i < map.map.height; i++) {
                for (let j = 0; j < map.map.width; j++) {
                    let x = j * dx + i * dx + shifts.x;
                    let y = -(j * dy) + (i * dy) + shifts.y;
                    if (x > -64 && x < this.canvas.width && y > -64 && y < this.canvas.height) {
                        this.drawImage(tiles[count].name, x, y);
                    }
                    count++;
                }
            }
        }
    }

    drawItem(map, gamer) {
        if(map && gamer) {
            let shifts = this.getShifts(gamer);
            let dx = 32;
            let dy = 16;
            let items = map.items;
            for (let i = 0; i < items.length; i++) {
                this.drawImage(items[i].name, items[i].x * dx + items[i].y * dx + shifts.x, -items[i].x * dy + items[i].y * dy + shifts.y);
            }
        }
    }

    drawGamer(gamer) {
        this.drawImage(this.changeDiretction(gamer.direction), this.canvas.width / 2 - 32, this.canvas.height / 2 - 16);
    }

    drawGamers(map, gamer) {
        if (map && gamer) {
            let shifts = this.getShifts(gamer);
            let dx = 32;
            let dy = 16;
            for (let i = 0; i < map.gamers.length; i++) {
                if (map.gamers[i].id !== gamer.id) {
                    this.drawImage(this.changeDiretction(map.gamers[i].direction), map.gamers[i].x * dx + map.gamers[i].y * dx + shifts.x, -map.gamers[i].x * dy + map.gamers[i].y * dy + shifts.y);
                }
            }
        }
    }

    changeDiretction(direction) {
        switch (direction) {
            case 'left':
                return 'leftDown';
            case 'right':
                return 'rightUp';
            case 'up':
                return 'leftUp';
            case 'down':
                return 'rightDown';
            case 'rightDown':
                return 'right';
            case 'leftDown':
                return 'down';
            case 'rightUp':
                return 'up';
            case 'leftUp':
                return 'left';
            default:
                return '';
        }
    }

    async click(event) {
        const x = event.offsetX;
        const y = event.offsetY;
        const [sin, cos] = this.calcSinCos(x, y);
        let sinPiDiv = this.sinPiDiv;
        if (cos > 0) {
            if (sin > sinPiDiv(8 / 3)) {
                await this.server.move('rightUp');
            } else if (sin > sinPiDiv(8)) {
                await this.server.move('right');
            } else if (sin > -sinPiDiv(8)) {
                await this.server.move('rightDown');
            } else if (sin > -sinPiDiv(8 / 3)) {
                await this.server.move('down');
            } else {
                await this.server.move('leftDown');
            }
        } else {
            if (sin > sinPiDiv(8 / 3)) {
                await this.server.move('rightUp');
            } else if (sin > sinPiDiv(8)) {
                await this.server.move('up');
            } else if (sin > -sinPiDiv(8)) {
                await this.server.move('leftUp');
            } else if (sin > -sinPiDiv(8 / 3)) {
                await this.server.move('left');
            } else {
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
                this.ctx.drawImage(this.img, 256, 48, 64, 64, x, y - 16, 64, 64);
                break;
            case 'rock':
                this.ctx.drawImage(this.img, 192, 64, 64, 64, x, y - 16, 34, 48);
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