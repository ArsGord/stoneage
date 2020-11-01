export default class Server {
    token = '';

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

    login(login, password) {
        if (login && password) {
            var md5 = require('md5');
            const num = Math.round(Math.random() * 100000);
            const hash = md5(md5(login + password) + num);
            return this.sendRequest('login', { login, hash, num });
        }
        return false;
    }

    registration(nickname, login, password) {
        if (nickname && login && password) {
            var md5 = require('md5');
            const num = Math.round(Math.random() * 100000);
            const hash = md5(md5(login + password) + num);
            return this.sendRequest('registration', { nickname, login, hash, num });    
        }
        return false;
    }

    logout(token) {
        if (token) {
            this.token = token;
            return this.sendRequest('logout', {  });
        }
    }

    move(direction) {
        return this.sendRequest('move', { direction });
    }

    takeItem() {
        return this.sendRequest('takeItem', {});
    }

    dropItem(hand) {
        return this.sendRequest('dropItem', { hand });
    }

    putOn() {
        return this.sendRequest('putOn', {});
    }

    putOnBackpack() {
        return this.sendRequest('putOnBackpack', {});
    }

    repair() {
        return this.sendRequest('repair', {});
    }

    fix() {
        return this.sendRequest('fix', {});
    }

    eat() {
        return this.sendRequest('eat', {});
    }

    makeItem() {
        return this.sendRequest('makeItem', {});
    }

    makeBuilding() {
        return this.sendRequest('makeBuilding', {});
    }

    keepBuilding() {
        return this.sendRequest('keepBuilding', {});
    }
}