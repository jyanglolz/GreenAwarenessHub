using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;


namespace GreenAwarenessHub.Models
{
    public class UserRole
    {
        [Key]
        public int RoleID { get; set; }


        public string? RoleName { get; set; }
    }
}
