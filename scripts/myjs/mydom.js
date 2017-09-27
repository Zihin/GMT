function elem(name, attrs, style, text) {
    var e = document.createElement(name);
    if (attrs) {
        for (key in attrs) {
            if (key == 'class') {
                e.className = attrs[key];
            } else if (key == 'id') {
                e.id = attrs[key];
            } else {
                e.setAttribute(key, attrs[key]);
            }
        }
    }
    if (style) {
        for (key in style) {
            e.style[key] = style[key];
        }
    }
    if (text) {
        e.appendChild(document.createTextNode(text));
    }
    return e;
}

//----------------------------------
// return next node in document order
function nextNode(node) {
    if (!node) return null;
    if (node.firstChild){
        return node.firstChild;
    } else {
        return nextWide(node);
    }
}
// helper function for nextNode()
function nextWide(node) {
    if (!node) return null;
    if (node.nextSibling) {
        return node.nextSibling;
    } else {
        return nextWide(node.parentNode);
    }
}
// return previous node in document order
function prevNode(node) {
    if (!node) return null;
    if (node.previousSibling) {
      return previousDeep(node.previousSibling);
    }
    return node.parentNode;
}
// helper function for prevNode()
function previousDeep(node) {
    if (!node) return null;
    while (node.childNodes.length) {
        node = node.lastChild;
    }
    return node;
}

//---------------------------------------

// return an Array of all nodes, starting at startNode and
// continuing through the rest of the DOM tree
function listNodes(startNode) {
    var list = new Array();
    var node = startNode;
    while(node) {
        list.push(node);
        node = nextNode(node);
    }
    return list;
}
// The same as listNodes(), but works backwards from startNode.
// Note that this is not the same as running listNodes() and
// reversing the list.
function listNodesReversed(startNode) {
    var list = new Array();
    var node = startNode;
    while(node) {
        list.push(node);
        node = prevNode(node);
    }
    return list;
}
// apply func to each node in nodeList, return new list of results
function map(list, func) {
    var result_list = new Array();
    for (var i = 0; i < list.length; i++) {
        result_list.push(func(list[i]));
    }
    return result_list;
}
// apply test to each node, return a new list of nodes for which
// test(node) returns true
function filter(list, test) {
    var result_list = new Array();
    for (var i = 0; i < list.length; i++) {
        if (test(list[i])) result_list.push(list[i]);
    }
    return result_list;
}