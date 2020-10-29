import React from 'react';
import {  Route } from "react-router-dom"
import './App.css';

import Server from './modules/Server.js';

import Login from './components/Login/login'
import Sign from './components/Sign/sign'
import Game from './components/Game/Game';
import Header from './components/Header/Header'

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      hash: ''
    }
    this.server = new Server();
  }

  setHash(hash) {
    this.setState({ hash });
  }


  render() {
    return (
      <div className="App">
        <Header />
        <div>
          <Route path='/login' render={props => <Login server={this.server} setHash = {(hash) => this.setHash(hash)}/>}/>
          <Route path='/registration' render={props => <Sign server={this.server} setHash = {(hash) => this.setHash(hash)}/>}/>
          <Route path='/game' render={props => <Game hash = {this.state.hash}/>}/>
        </div>
      </div>
    );  
  }
}

export default App;