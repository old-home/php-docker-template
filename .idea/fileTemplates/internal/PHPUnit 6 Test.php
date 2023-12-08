<?php
#parse("PHP File Header.php")

#if (${NAMESPACE})
namespace ${NAMESPACE};
#end

#if (${TESTED_NAME} && ${NAMESPACE} && !${TESTED_NAMESPACE})
use ${TESTED_NAME};
#elseif (${TESTED_NAME} && ${TESTED_NAMESPACE} && ${NAMESPACE} != ${TESTED_NAMESPACE})
use ${TESTED_NAMESPACE}\\${TESTED_NAME};
#end
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#parse("PHP Class Doc Comment")
#[CoversClass(${TESTED_NAME}::class)]
class ${NAME} extends TestCase {

}
