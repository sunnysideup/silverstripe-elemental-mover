# Upgrade to Silverstripe CMS 6

## New requirements

⚠️ **Update composer dependency**: `dnadesign/silverstripe-elemental` now requires `^6.0` (previously `^4 || ^5`)

## API changes

### Namespace changes

⚠️ **Replace deprecated ArrayList import**:
- Change `use SilverStripe\ORM\ArrayList;` to `use SilverStripe\Model\List\ArrayList;`

⚠️ **Replace deprecated ArrayData import**:
- Change `use SilverStripe\View\ArrayData;` to `use SilverStripe\Model\ArrayData;`

### Extension methods

**Remove `parent::onBeforeWrite()` call** in `ElementalMoverExtension::onBeforeWrite()` - no longer required in SilverStripe 6
