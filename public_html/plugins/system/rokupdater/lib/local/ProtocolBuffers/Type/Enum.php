<?php
/**
 * @author Nikolai Kordulla
 */
class ProtocolBuffers_Type_Enum extends ProtocolBuffers_Type_Scalar
{
	protected $wired_type = ProtocolBuffers_AbstractMessage::WIRED_VARINT;
	protected $names = array();
	
	/**
	 * Parses the message for this type
	 *
	 * @param array
	 */
	public function ParseFromArray()
	{
		$this->value = $this->reader->next();
		
		$this->clean();
	}

	/**
	 * Serializes type
	 */
	public function SerializeToString($rec=-1)
	{
		$string = '';

		if ($rec > -1)
		{
			$string .= $this->base128->set_value($rec << 3 | $this->wired_type);
		}

		$value = $this->base128->set_value($this->value);
		$string .= $value;

		return $string;
	}
	
	public function get_description()
	{
		if (isset($this->names[$this->value]))
			return $this->names[$this->value];
		
		return "";
	}
}