export default class Server {
    token = '';
    map = {}; 
    hash = '';
    update = null;
    gamer = {};
    mapHash = '';

    async sendRequest(method, data = {}) {
        data.method = method;
        data.token = this.token;
        let arr = [];
        Object.keys(data).forEach(key => arr.push(`${key}=${data[key]}`));
        const request = await fetch('http://stoneage/api/?' + arr.join('&'));
        const answer = await request.json();
        if (answer && answer.result === 'ok') {
            return answer.data;
        }
        return false;
    }

    async login(login, password) {
        if (login && password) {
            var md5 = require('md5');
            const num = Math.round(Math.random() * 100000);
            const hash = md5(md5(login + password) + num);
            this.token = await this.sendRequest('login', { login, hash, num });
            if (this.token) {
                this.gamer = await this.sendRequest('join');
                localStorage.setItem('token', this.token);
                //this.update = setInterval(() => {this.checkHash()}, 5000);
                return true;
            }
        }
        return false;
    }

    async registration(nickname, login, password) {
        if (nickname && login && password) {
            var md5 = require('md5');
            const num = Math.round(Math.random() * 100000);
            const hash = md5(login + password);
            this.token = md5(hash + num);
            this.token =  await this.sendRequest('registration', { nickname, login, hash, num });
            if (this.token) {
                this.gamer = await this.sendRequest('join');
                console.log(this.gamer);
                localStorage.setItem('token', this.token);
                //this.update = setInterval(() => {this.checkHash()}, 5000);
                return true;
            }    
        }
        return false;
    }

    async logout(token) {
        if (token) {
            this.token = token;
            const result = await this.sendRequest('logout');
            if (result) {
                this.token = '';
                this.map = {};
                this.gamer = {};
                localStorage.setItem('token', '');
                //clearInterval(this.update);
            }
        }
    }

    async getMap() {
        return await this.sendRequest('getMap');
    }

    async checkHash () {
        if (this.token) {
            let hash = this.mapHash;
            const bdHash = await this.sendRequest ('updateMap', {hash});
            if(bdHash !== this.hash && bdHash !== false) {
                this.mapHash = bdHash;
                console.log('mapHash: ' + this.mapHash);
                this.map = await this.getMap();
                if (this.map) {
                    for (let i = 0; i < this.map.gamers.length; i++) {
                        if (this.map.gamers[i].id === this.gamer.id) {
                            this.gamer = this.map.gamers[i];
                            this.map.gamer = (this.gamer);
                            break;
                        }
                    }
                }
            }
            return this.map;
        }
    }

    move(direction) {
        return this.sendRequest('move', { direction });
    }

    takeItem() {
        return this.sendRequest('takeItem');
    }

    dropItem(hand) {
        return this.sendRequest('dropItem', { hand });
    }

    putOn() {
        return this.sendRequest('putOn');
    }

    putOnBackpack() {
        return this.sendRequest('putOnBackpack');
    }

    repair() {
        return this.sendRequest('repair');
    }

    fix() {
        return this.sendRequest('fix');
    }

    eat() {
        return this.sendRequest('eat');
    }

    makeItem() {
        return this.sendRequest('makeItem');
    }

    makeBuilding() {
        return this.sendRequest('makeBuilding');
    }

    keepBuilding() {
        return this.sendRequest('keepBuilding');
    }
}