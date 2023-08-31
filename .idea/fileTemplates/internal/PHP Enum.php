<?php
#parse("PHP File Header.php")

#if (${NAMESPACE})
namespace ${NAMESPACE};

#end
#parse("PHP Class Doc Comment")
enum ${NAME}#if (${BACKED_TYPE}) : ${BACKED_TYPE} #end{

}
