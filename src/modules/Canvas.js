export default class Canvas {
    constructor() {
        this.canvas = document.getElementById('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.canvas.width = 800;
        this.canvas.height = 800;
        this.drawSectors();
    }

    click(event) {
        const x = event.offsetX;
        const y = event.offsetY;
        const [sin, cos] = this.calcSinCos(x, y);
        let sinPiDiv = this.sinPiDiv;
        if (cos > 0) {
            if (sin > sinPiDiv(8/3)) {
                console.log('right up');
            } else if (sin > sinPiDiv(8)) {
                console.log('right');
            } else if (sin > -sinPiDiv(8)) {
                console.log('right down');
            } else if (sin > -sinPiDiv(8/3)) {
                console.log('down');
            } else {
                console.log('left down');
            }
        } else {
            if (sin > sinPiDiv(8/3)) {
                console.log('right up');
            } else if (sin > sinPiDiv(8)) {
                console.log('up');
            } else if (sin > -sinPiDiv(8)) {
                console.log('left up');
            } else if (sin > -sinPiDiv(8/3)) {
                console.log('left');
            } else {
                console.log('left down');
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

    drawSectors() {
        let ctx = this.ctx;
        let [width, height] = [this.canvas.width, this.canvas.height];
        ctx.lineWidth = 1;
        ctx.strokeStyle = 'black';
        ctx.beginPath();
            ctx.moveTo(0, height / 2 * (1 - this.sinPiDiv(8)));
            ctx.lineTo(width, height / 2 * (1 + this.sinPiDiv(8)));
            ctx.moveTo(0, height / 2 * (1 + this.sinPiDiv(8)));
            ctx.lineTo(width, height / 2 * (1 - this.sinPiDiv(8)));
            ctx.moveTo(width / 2 * (1 - this.sinPiDiv(8)), 0);
            ctx.lineTo(width / 2 * (1 + this.sinPiDiv(8)), height);
            ctx.moveTo(width / 2 * (1 + this.sinPiDiv(8)), 0);
            ctx.lineTo(width / 2 * (1 - this.sinPiDiv(8)), height);
        ctx.stroke();
    }
}