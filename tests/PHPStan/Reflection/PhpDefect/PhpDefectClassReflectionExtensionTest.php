<?php declare(strict_types = 1);

namespace PHPStan\Reflection\PhpDefect;

use PHPStan\Broker\Broker;
use ZipArchive;

class PhpDefectClassReflectionExtensionTest extends \PHPStan\TestCase
{

	/**
	 * @dataProvider dataDateIntervalProperties
	 * @dataProvider dataDomDocumentProperties
	 * @dataProvider dataZipArchiveProperties
	 *
	 * @param string $className
	 * @param string $declaringClassName
	 * @param array  $data
	 */
	public function testProperties(string $className, string $declaringClassName, array $data)
	{
		foreach ($data as $propertyName => $typeDescription) {
			$broker = $this->getContainer()->getByType(Broker::class);
			$classReflection = $broker->getClass($className);
			$this->assertTrue($classReflection->hasProperty($propertyName));
			$propertyReflection = $classReflection->getProperty($propertyName);
			$this->assertInstanceOf(PhpDefectPropertyReflection::class, $propertyReflection);
			$this->assertSame($declaringClassName, $propertyReflection->getDeclaringClass()->getName());
			$this->assertSame($typeDescription, $propertyReflection->getType()->describe(), sprintf('%s::$%s', $className, $propertyName));
		}
	}

	public function dataDateIntervalProperties(): array
	{
		return [
			[
				\DateInterval::class,
				\DateInterval::class,
				[
					'y' => 'int',
					'm' => 'int',
					'd' => 'int',
					'h' => 'int',
					'i' => 'int',
					's' => 'int',
					'invert' => 'int',
					'days' => 'mixed',
				],
			],
			[
				\PhpDefectClasses\DateIntervalChild::class,
				\DateInterval::class,
				[
					'y' => 'int',
					'm' => 'int',
					'd' => 'int',
					'h' => 'int',
					'i' => 'int',
					's' => 'int',
					'invert' => 'int',
					'days' => 'mixed',
				],
			],
		];
	}

	public function dataDomDocumentProperties(): array
	{
		return [
			[
				\DOMDocument::class,
				\DOMDocument::class,
				[
					'documentURI' => 'string',
					'encoding' => 'string',
					'formatOutput' => 'bool',
					'implementation' => 'bool',
					'preserveWhiteSpace' => 'bool',
					'recover' => 'bool',
					'resolveExternals' => 'bool',
					'standalone' => 'bool',
					'strictErrorChecking' => 'bool',
					'substituteEntities' => 'bool',
					'validateOnParse' => 'bool',
					'version' => 'string',
					'xmlEncoding' => 'string',
					'xmlVersion' => 'string',
				],
			],
		];
	}



	public function dataZipArchiveProperties(): array
	{
		return [
			[
				ZipArchive::class,
				ZipArchive::class,
				[
					'status' => 'int',
					'statusSys' => 'int',
					'numFiles' => 'int',
					'filename' => 'string',
					'comment' => 'string',
				],
			],
		];
	}

}
