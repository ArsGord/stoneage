export class Server {
    token = 'wersdsgf';

    async sendRequest(method, data = {}) {
        data.method = method;
        data.token = this.token;
        let arr = [];
        Object.keys(data).forEach(key => arr.push(`${key}=${data[key]}`));
        const request = await fetch('api/?' + arr.join('&'));
        const answer = await request.json();
        if (answer && answer.result === 'ok') {
            return answer.data;
        }
        return false;
    }

    registration(nickname, login, password) {
        return this.sendRequest('registration', { nickname, login, password });
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

    eat() {
        return this.sendRequest('eat', {});
    }
}