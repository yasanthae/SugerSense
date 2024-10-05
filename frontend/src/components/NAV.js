import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import "./fontawesome-free/css/all.css";
import { Button } from "./Button";
import "./NAV.css";

function NAV() {
  const [click, setClick] = useState(false);
  const [button, setButton] = useState(true);

  const handleClick = () => setClick(!click);
  const closeMobioeMenue = () => setClick(false);
  const showButton = () => {
    if (window.innerWidth <= 960) {
      setButton(false);
    } else {
      setButton(true);
    }
  };
  useEffect(() => {
    showButton();
  }, []);

  window.addEventListener("resize", showButton);

  return (
    <nav className="navbar">
      <div className="navbar-container">
        <Link to="/" className="title" onClick={closeMobioeMenue}>
          SugerSense
        </Link>

        <div className="menu-icon" onClick={handleClick}>
          <i className={click ? "fas fa-times" : "fas fa-bars"} />
        </div>
        <ul className={click ? "nav-menu active " : "nav-menu"}>
          <li></li>
        </ul>
        {button && <Button buttonStyle="btns">Try Now</Button>}
      </div>
    </nav>
  );
}

export default NAV;
