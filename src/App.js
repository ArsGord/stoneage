import React from 'react';
import { Route } from 'react-router-dom';
import Login from './components/Login/login'
import Sign from './components/Sign/sign'
import Game from './components/Game/Game';
import Header from './components/Header/Header';
import './App.css';
import Server from './modules/Server.js';

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      hash: ''
    }
    this.server = new Server();
    this.setHash = this.setHash.bind(this);
  }

  setHash(hash) {
    if (hash) {
      this.setState({ hash });
      localStorage.setItem('token', this.state.hash);
    } else {
      this.setState({ hash: '' });
      localStorage.setItem('token', this.state.hash);
    }
  }

  render() {
    return (
      <div className="App">
        <Header/>
        <div>
          <Route path='/login' render={() => <Login server={this.server} setHash = {(hash) => this.setHash(hash)} hash = {this.state.hash}/>}/>
          <Route path='/registration' render={() => <Sign server={this.server} setHash = {(hash) => this.setHash(hash)} hash = {this.state.hash}/>}/>
          <Route path='/game' render={() => <Game server={this.server} setHash = {(hash) => this.setHash(hash)}/>}/>
        </div>
      </div>
    );  
  }
}

export default App;