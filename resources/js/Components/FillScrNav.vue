<script setup>

import {Head, Link} from "@inertiajs/vue3";
import {faTimes} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {ref} from "vue";
const showNav = ref(false);
</script>

<template>
    <Head title="Naked God-Eye" />
    <div class="main-header">
        <div class="container">
            <div class=" header flex flex-row justify-between align-middle">
                <div class="brand-name">
                    <Link href="/" @click="showNav = false">
                        <strong> Emeka Onyejesi ™ </strong>
                    </Link>
                </div>
                <button @click="showNav = !showNav" type="button" class="open-nav">
                    <span></span>
                </button>
                <nav class="nav" :class="{ open: showNav}">
                    <button @click="showNav = !showNav" type="button" class="close-nav">&times;</button>
                    <div class="nav-inner">
                        <ul>
                            <li><a href="/" @click="showNav = false">home</a></li>
                            <li><a href="/about" @click="showNav = false">about</a></li>
                            <li><a href="/albums" @click="showNav = false">collections</a></li>
                            <li><a href="/journal" @click="showNav = false">Journal</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container{
    max-width: 1170px;
    margin:auto;
    padding: 0 1rem;
}

@media (min-width: 640px) {
    .container {
        padding: 0 1.5rem;
    }
}

@media (min-width: 768px) {
    .container {
        padding: 0 2rem;
    }
}

.open-nav{
    mix-blend-mode: difference;
}

.close-nav{
    mix-blend-mode: difference;
}
.brand-name{
    font-size: 1rem;
    padding-left: 0.5rem;
    color:whitesmoke;
}

@media (min-width: 640px) {
    .brand-name {
        font-size: 1.125rem;
        padding-left: 0.75rem;
    }
}

@media (min-width: 768px) {
    .brand-name {
        font-size: 1.25rem;
        padding-left: 1rem;
    }
}

.main-header
{
    height: 60px;
    width: 100%;
    padding: 1.5rem;
    z-index:2;
    /*background-color: transparent;*/
    /* background: rgba(14, 13, 13, 0.43); */
    position: absolute;
    color: whitesmoke;
    border-bottom: 3px solid transparent ;
    transition: border-bottom 1s;
}

@media (min-width: 640px) {
    .main-header {
        height: 70px;
        padding: 2rem;
    }
}

@media (min-width: 768px) {
    .main-header {
        height: 80px;
        padding: 2.5rem;
    }
}

@media (min-width: 1024px) {
    .main-header {
        padding: 3rem;
    }
}

.main-header:hover{
    border-color: white;
}

.header .open-nav{
    height: 34px;
    width: 44px;
    background-color: transparent;
    display: inline-block;
    border:none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    min-height: 44px;
    min-width: 44px;
}

@media (min-width: 640px) {
    .header .open-nav {
        height: 38px;
        width: 48px;
    }
}

.header .open-nav span{
    display: inline-block;
    width: 18px;
    background-color: #ffffff;
    height: 2px;
    position: relative;
}

@media (min-width: 640px) {
    .header .open-nav span {
        width: 20px;
    }
}

.header .open-nav span::before,
.header .open-nav span::after{
    content: '';
    position: absolute;
    right:0;
    top:0;
    height: 2px;
    width: 50%;
    background-color: inherit;
    transition: all 0.3s ease;
}
.header .open-nav span::before{
    transform: translateY(-6px);
}
.header .open-nav span::after{
    transform: translateY(6px);
}
.header .open-nav:hover span::before,
.header .open-nav:hover span::after,
.header .open-nav:focus span::before,
.header .open-nav:focus span::after{
    width: 100%;
}
.header .nav{
    position: fixed;
    left:0;
    top:0;
    height: 100%;
    width: 100%;
    z-index: 999;
    background-color: rgba(0, 0, 0, 0.9);
    overflow-y: auto;
    transform: translateX(100%);
    transition: all 0.5s ease;
}
.header .nav.open{
    transform: translateX(0%);
}
.header .nav .close-nav{
    position: absolute;
    right: 1.5rem;
    top: 1rem;
    background-color: transparent;
    height: 40px;
    width: 40px;
    border:none;
    cursor: pointer;
    font-size: 2rem;
    color: #ffffff;
    transition: all 0.3s ease;
    transform: translateY(-55px);
    opacity:0;
    min-height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .header .nav .close-nav {
        right: 2rem;
        top: 1.5rem;
        font-size: 2.25rem;
        height: 44px;
        width: 44px;
    }
}

@media (min-width: 768px) {
    .header .nav .close-nav {
        right: 2.5rem;
        top: 2rem;
        font-size: 2.5rem;
    }
}

@media (min-width: 1024px) {
    .header .nav .close-nav {
        right: 3.5rem;
    }
}

.header .nav.open .close-nav{
    transform: translateY(0px);
    opacity: 1;
    transition-delay: 0.5s;
}
.header .nav-inner{
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

@media (min-width: 640px) {
    .header .nav-inner {
        padding: 3rem;
    }
}

@media (min-width: 768px) {
    .header .nav-inner {
        padding: 4rem;
    }
}

@media (min-width: 1024px) {
    .header .nav-inner {
        padding: 60px;
    }
}

.header .nav ul{
    transform: translateX(-80px);
    opacity: 0;
    transition: all 0.3s ease;
}
.header .nav.open ul{
    transform: translateX(0px);
    opacity: 1;
    transition-delay: 0.5s;
}
.header .nav ul li{
    margin-bottom: 20px;
    text-align: center;
}

@media (min-width: 640px) {
    .header .nav ul li {
        margin-bottom: 25px;
    }
}

@media (min-width: 768px) {
    .header .nav ul li {
        margin-bottom: 30px;
    }
}

.header .nav ul li a{
    display: inline-block;
    font-size: 1.5rem;
    color:#ffffff;
    text-transform: capitalize;
    position: relative;
    padding: 0.5rem;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .header .nav ul li a {
        font-size: 2rem;
    }
}

@media (min-width: 768px) {
    .header .nav ul li a {
        font-size: 2.25rem;
    }
}

@media (min-width: 1024px) {
    .header .nav ul li a {
        font-size: 2.5rem;
    }
}

.header .nav ul li a::before{
    content: '';
    position: absolute;
    left:0;
    bottom:-5px;
    height: 2px;
    background-color: #ffffff;
    width:0%;
    transition: all 0.3s ease;
}
.header .nav ul li a:hover::before,
.header .nav ul li a:focus::before{
    width: 100%;
}
</style>
