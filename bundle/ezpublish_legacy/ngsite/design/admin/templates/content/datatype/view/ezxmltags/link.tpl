{if and(is_set($link_suffix), $link_suffix|trim|count_chars|gt(0))}
    {set $href = $href|concat($link_suffix)}
{/if}
<a href={$href|ezurl}{if $id} id="{$id}"{/if}{if $title} title="{$title}"{/if}{if $target} target="{$target}"{/if}{if $classification} class="{$classification|wash}"{/if}{if and(is_set( $hreflang ), $hreflang)} hreflang="{$hreflang|wash}"{/if}>{$content}</a>
