# phpEchoService                                                                                                                                                                           
A PHP script that echoes back what the client sends.                                                                                                                                       
                                                                                                                                                                                           
This was created while I built web services in platforms I didn't fully understand.
With this I could easily see what and how the client requested data from the server.                   
                                                                                                                                                                                           
PATH_INFO is supported, so you can request echo.php/plain or echo.php/json to get the
responses in either of those formats. The JSON is always sent to the server with
error_log() as well.
