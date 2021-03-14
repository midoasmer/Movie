var n = 1,
    x = 1;

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


function anotherCategory(categories) {
    "use strict";
    if (x < 3) {
        var input = document.createElement("SELECT");
        input.setAttribute("id", "categorySelect" + x);
        input.setAttribute('name', 'Category' + x);
        input.setAttribute('class', "form-control");
        var parent = document.getElementById("addcategory");
        parent.appendChild(input);
        var c = 0;
        for (var cat in categories) {
            var z = document.createElement("option");
            z.setAttribute("value", categories[c].id);
            var t = document.createTextNode(categories[c].Name);
            z.appendChild(t);
            document.getElementById("categorySelect" + x).appendChild(z);
            c++;
        }
        x++;
    } else {
        alert('Sorry You Can only Add 3 Categories To The Movie');
    }
}

var chick1 = 0;
function anotherCategory1(id, name1,categories,n1) {
    if(chick1 === 0)
    {
        chick1 = n1;
    }
    else{
        n1=chick1;
    }
    if (n1 < 3) {
        var input = document.createElement("SELECT");
        input.setAttribute("id", "categorySelect" + n1);
        input.setAttribute('name', 'Category' + n1);
        input.setAttribute('class', "form-control");
        var parent = document.getElementById("addCategory");
        parent.appendChild(input);
        var a = document.createElement("option");
        a.setAttribute("value", id);
        var name = document.createTextNode(name1);
        a.appendChild(name);
        document.getElementById("categorySelect" + n1).appendChild(a);
        var c = 0;
        for (var cat in categories) {
            var z = document.createElement("option");
            z.setAttribute("value", categories[c].id);
            var t = document.createTextNode(categories[c].Name);
            z.appendChild(t);
            document.getElementById("categorySelect" + n1).appendChild(z);
            c++;
        }
        chick1++;
    } else {
        alert('Sorry You Can only Add 3 Categories To The Movie');
    }
}

