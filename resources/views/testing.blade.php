<div id="parentDiv"></div>
<button onclick="addFeilde()">call the function</button>
<script>
    var n = 1;

    function addFeilde() {
        "use strict";
        if (n < 3) {
            var input = document.createElement("SELECT");
            input.setAttribute("id", "mySelect" + n);
            input.setAttribute('name', 'Actor' + n);
            input.setAttribute('class', "form-control");
            var parent = document.getElementById("parentDiv");
            parent.appendChild(input);
                @foreach ($actors as $actor)
            var z = document.createElement("option");
            z.setAttribute("value", "{{$actor->id}}");
            var t = document.createTextNode("{{$actor->Name}}");
            z.appendChild(t);
            document.getElementById("mySelect" + n).appendChild(z);
            @endforeach
                n++;
        } else {
            alert('Sorry You Can only Add 3 Actors To The Movie');

        }
    }
</script>
