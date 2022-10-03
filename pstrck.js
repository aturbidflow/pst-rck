(function(){
    var pst = 
        {
            footerH: 0,
            api:
                {
                    get: function(url, callback)   
                        {
                            var xobj = new XMLHttpRequest()

                            xobj.overrideMimeType("application/json")
                            xobj.open('GET', url + '?_=' + new Date().getTime(), true)

                            xobj.onreadystatechange = function () 
                                {
                                    if (xobj.readyState == 4) 
                                    {
                                        if (xobj.status == "200")
                                            {
                                                callback(JSON.parse(xobj.responseText))
                                            }
                                        else
                                            {
                                                console.error(xobj.statusText + ": " + xobj.responseURL)
                                            }
                                    }
                                }

                            xobj.send(null)
                        }
                },
            actions:
                {
                    twitter: function()
                        {
                            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                        },
                    rebuild: function()
                        {
                            var $wjs = document.getElementById('twitter-wjs'),
                                $ifr = document.querySelector('iframe.twitter-share-button'),
                                $tmpa = document.querySelector('a.twitter-share-button')

                            $wjs && $wjs.parentNode.removeChild($wjs)
                            $ifr && $ifr.parentNode.removeChild($ifr)
                            $tmpa && $tmpa.parentNode.removeChild($tmpa)

                            pst.$.social.innerHTML = pst.$.social.innerHTML + '<a href="https://twitter.com/share" class="twitter-share-button" data-text="«'+html+'» by" data-lang="ru" data-hashtags="HOPE">Твитнуть</a>'
                        }
                },
            get: function()
                {
                    pst.api.get('engine/ajax.0.3.php',function(data) { 
                        html = data.text;

                        window.history.replaceState({ "uniq":data.uniq },'HOPE &mdash '+ data.text, '/' + data.uniq)

                        pst.$.phrase.innerHTML = html
                        pst.$.meta.desc.innerHTML = html
                        pst.$.meta.vk.innerHTML = (VK.Share.button({url: "http://pst-rck.nw-lab.com/" + data.uniq,image: "http://cs309925.userapi.com/v309925164/138e/80-YdjSDi1w.jpg", title: html, description: "HOPE",noparse: true},{type: "button", text: "Поделиться"}));
                        
                        pst.actions.rebuild()
                        pst.actions.twitter()
                    })
                },
            generate: function(e)
                {
                    e.preventDefault()
                            
                    var padd = pst.$.phrase.style.padding,
                        tmpH

                    pst.$.phrase.style.padding = 0
                    tmpH = pst.$.phrase.clientHeight
                    pst.$.phrase.style.padding = padd
                    
                    pst.$.phrase.style.minHeight = tmpH + 'px'
                    pst.$.phrase.innerHTML = '<img src="/ajax-loader.gif" />'
                    
                    pst.get()
                },
            init: function()
                {
                    pst.$ = 
                        {
                            thnx: document.getElementById('thnx'),
                            footer: document.querySelector('footer'),
                            runbtn: document.getElementById('runbtn'),
                            phrase: document.getElementById('the-phrase'),
                            social: document.getElementById('social'),
                            meta:
                                {
                                    desc: document.querySelector('meta[name=description]'),
                                    vk: document.getElementById('vk_share'),
                                }
                        }

                    pst.actions.twitter()
                    pst.$.runbtn.addEventListener('click', pst.generate)
                }
        }

    document.addEventListener('DOMContentLoaded', pst.init)
})()