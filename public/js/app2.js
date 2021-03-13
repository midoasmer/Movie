var n = 1;

function anotherActor(actors) {
    "use strict";
    if (n < 3) {
        var input = document.createElement("SELECT");
        input.setAttribute("id", "mySelect" + n);
        input.setAttribute('name', 'Actor' + n);
        input.setAttribute('class', "form-control");
        var parent = document.getElementById("add");
        parent.appendChild(input);
        var c = 0;
        for (var atr in actors) {
            var z = document.createElement("option");
            z.setAttribute("value", actors[c].id);
            var t = document.createTextNode(actors[c].Name);
            z.appendChild(t);
            document.getElementById("mySelect" + n).appendChild(z);
            c++;
        }
        n++;
    } else {
        alert('Sorry You Can only Add 3 Actors To The Movie');
    }
}

var chick = 0;
function anotherActor1(id, name1,actors,n1) {
    if(chick === 0)
    {
        chick = n1;
    }
    else{
        n1=chick;
    }
    if (n1 < 3) {
        var input = document.createElement("SELECT");
        input.setAttribute("id", "mySelect" + n1);
        input.setAttribute('name', 'Actor' + n1);
        input.setAttribute('class', "form-control");
        var parent = document.getElementById("add");
        parent.appendChild(input);
        var a = document.createElement("option");
        a.setAttribute("value", id);
        var name = document.createTextNode(name1);
        a.appendChild(name);
        document.getElementById("mySelect" + n1).appendChild(a);
        var c = 0;
        for (var atr in actors) {
            var z = document.createElement("option");
            z.setAttribute("value", actors[c].id);
            var t = document.createTextNode(actors[c].Name);
            z.appendChild(t);
            document.getElementById("mySelect" + n1).appendChild(z);
            c++;
        }
        chick++;
    } else {
        alert('Sorry You Can only Add 3 Actors To The Movie');
    }
}
