<style>
#main-wrapper{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    min-height: calc(100vh - 50px);
}
#main-wrapper > div{
    width: 100%;
}
#main-wrapper .left-col{
    padding: 10px;
    max-width: 300px;
}
#main-wrapper .right-col {
    max-width: calc(100% - 300px);
    padding: 20px;
    /* background: #282925; */
}

#main-menu {
    overflow-y: auto;
    height: 100%;
    position: fixed;
    top: 70px;
    left: 0;
    width: 300px;
    padding: 10px;
    padding-bottom: 50px;
    border-right: 1px solid #ccc;
}

#main-menu ul {
    margin-bottom: 50px;
}

#main-menu ul.no-group{
    margin-bottom: 10px;
}

#main-menu li a {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    text-transform: capitalize;
}
.menu-list.no-group li a{
    padding: .5em 0;
}
#main-content {
    max-width: 1080px;
    margin: auto;
}
</style>
