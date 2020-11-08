import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import Login from './components/Login/login'
import Sign from './components/Sign/sign'
import Game from './components/Game/Game';
import './App.css';
import Server from './modules/Server.js';

class App extends React.Component {
  constructor() {
    super();
    this.server = new Server();
  }

  render() {
    return (
      <div className="App">
        <Redirect to='/login'/>
        <div>
          <Route path='/login' render={() => <Login server={this.server}/>}/>
          <Route path='/registration' render={() => <Sign server={this.server}/>}/>
          <Route path='/game' render={() => <Game server={this.server}/>}/>
        </div>
      </div>
    );  
  }
}

export default App;