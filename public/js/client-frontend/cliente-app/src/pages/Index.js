import React, { Component } from 'react';
import logo from '../logo.svg';
import '../App.css';
import Navigation from '../components/navbar.js';
import Jumbo from '../components/jumbotron.js'
import Galeria from '../components/Galeria.js'
import Card from '../components/Cards.js'

import '../css/styles.css'

const cards = require('../initialContents/InitialTextContent');

class Index extends Component {
  render() {
    return (
      <div className="body">     
        <Navigation />
        <Jumbo />
        <Card content={cards}/>
        <Galeria />
      </div>
    );
  }
}

export default Index;
