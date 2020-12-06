import React from 'react';
import Canvas from '../../modules/Canvas.js'
import 'bootstrap/dist/css/bootstrap.min.css';
import './style.css';
import { Button } from 'react-bootstrap';
import { LinkContainer } from 'react-router-bootstrap';

class Game extends React.Component {
    constructor(props) {
        super();
        this.server = props.server;
        this.state = {
          canvas: null
        }
    }

    async componentDidMount() {
      this.server.getMap();
      this.canvas = new Canvas(this.server);
      document.getElementById('canvas').addEventListener('click', (event) => { this.canvas.click(event) });
    }

    componentWillUnmount() {
      this.server.logout(localStorage.getItem('token'));
      this.canvas.clInterval();
    }

    async sendRequest(method) {
      if (method && typeof method === 'string') {
          switch (method) {
            case 'logout':
              await this.server.logout(localStorage.getItem('token'));
              break;
            case 'move':
              await this.server.move('left');
              break;
            case 'takeItem':
              await this.server.takeItem();
              break;
            case 'dropItem':
              await this.server.dropItem('right');
              break;
            case 'putOn':
              await this.server.putOn();
              break;
            case 'putOnBackpack':
              await this.server.putOnBackpack();
              break;
            case 'repair':
              await this.server.repair();
              break;
            case 'fix':
              await this.server.fix();
              break;
            case 'eat':
              await this.server.checkHash();
              break;
            case 'makeItem':
              await this.server.makeItem();
              break;
            case 'makeBuilding':
              await this.server.makeBuilding();
              break;
            case 'keepBuilding':
              await this.server.keepBuilding();
              break;
            default:
              break;
          }
      }
    }
  
    render() {
      return (
          <div>
            <div className="navbar" >
                <div className="h2">Stone Age</div>
                <div>
                <LinkContainer to='/login'>
                  <Button onClick={() => { this.sendRequest('logout'); this.canvas.clInterval(); }} className="logout-button">Выход</Button>
                </LinkContainer>
                </div>
            </div>
            <div>
              <canvas id="canvas"></canvas>
            </div>
            <div className="buttons">
              <button className="interface-button" onClick={() => this.sendRequest('move')}>move</button>
              <button className="interface-button" onClick={() => this.sendRequest('takeItem')}>takeItem</button>
              <button className="interface-button" onClick={() => this.sendRequest('dropItem')}>dropItem</button>
              <button className="interface-button" onClick={() => this.sendRequest('putOn')}>putOn</button>
              <button className="interface-button" onClick={() => this.sendRequest('putOnBackpack')}>putOnBackpack</button>
              <button className="interface-button" onClick={() => this.sendRequest('repair')}>repair</button>
              <button className="interface-button" onClick={() => this.sendRequest('fix')}>fix</button>
              <button className="interface-button" onClick={() => this.sendRequest('eat')}>eat</button>
              <button className="interface-button" onClick={() => this.sendRequest('makeItem')}>makeItem</button>
              <button className="interface-button" onClick={() => this.sendRequest('makeBuilding')}>makeBuilding</button>
              <button className="interface-button" onClick={() => this.sendRequest('keepBuilding')}>keepBuilding</button>
            </div>
          </div>
      );
    }
  }
  
  export default Game;